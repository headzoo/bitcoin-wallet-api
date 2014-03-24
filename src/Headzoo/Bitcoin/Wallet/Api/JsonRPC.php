<?php
namespace Headzoo\Bitcoin\Wallet\Api;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

/**
 * Core class which directly communicates with Bitcoin wallets supporting the JSON-RPC API.
 *
 * This class provides a single `query($method, array $params = [])` method via the
 * `Headzoo\Bitcoin\Wallet\Api\JsonRPCInterface` interface. Although you may use this class directly to query a wallet,
 * it's best to use an instance of `Headzoo\Bitcoin\Wallet\Api\Wallet` instead.
 * 
 * Example:
 * ```php
 *  $conf = [
 *      "user" => "test",
 *      "pass" => "pass",
 *      "host" => "localhost",
 *      "port" => 9332
 *  ];
 *  $rpc  = new JsonRPC($conf);
 *
 *  $info      = $rpc->query("getInfo");
 *  $balance   = $rpc->query("getBalance", ["headz", 1]);
 *  $signature = $rpc->query(
 *      "signMessage",
 *      [
 *          "1Headz2mYtpBRo6KFaaUEtcm5Kce6BZRJM",
 *          "Mary had a little lamb."
 *      ]
 *  );
 * ```
 */
class JsonRPC
    implements JsonRPCInterface
{
    /**
     * Configuration for the litecoind rpc
     * @var array
     */
    private $conf = [
        "user" => "test",
        "pass" => "test",
        "host" => "localhost",
        "port" => 9332
    ];

    /**
     * Used to make http request to the wallet
     * @var HTTPInterface
     */
    private $http;

    /**
     * Used to generate request ids
     * @var Nonce
     */
    private $nonce;

    /**
     * Used to log messages
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Map of http status codes to exceptions that should be thrown
     * @var array
     */
    private static $exceptions = [
        HTTPStatusCodes::UNAUTHORIZED           => '\Exceptions\AuthenticationException',
        HTTPStatusCodes::NOT_FOUND              => '\Exceptions\MethodNotFoundException',
        HTTPStatusCodes::BAD_REQUEST            => '\Exceptions\BadRequestException',
        HTTPStatusCodes::FORBIDDEN              => '\Exceptions\ForbiddenException',
        HTTPStatusCodes::INTERNAL_SERVER_ERROR  => '\Exceptions\InternalServerErrorException'
    ];

    /**
     * Constructor
     *
     * @param array           $conf   See the setConf() method
     * @param HTTPInterface   $http   Used to make http post requests
     * @param LoggerInterface $logger Log requests and errors with this instance
     */
    public function __construct(array $conf = [], HTTPInterface $http = null, LoggerInterface $logger = null)
    {
        $this->setConf($conf);
        if (null !== $http) {
            $this->setHTTP($http);
        }
        if (null !== $logger) {
            $this->setLogger($logger);
        }
    }

    /**
     * Sets the configuration for the rpc
     *
     * The configuration array should contain 4 items:
     * ```
     *  "user" - The rpc username, default "test"
     *  "pass" - The rpc password, default "test"
     *  "host" - The rpc server host, default "localhost"
     *  "port" - The rpc server port, default 9332
     * ```
     *
     * @param  array $conf Configuration for the rpc
     * @return $this
     */
    public function setConf(array $conf)
    {
        $this->conf = array_merge($this->conf, $conf);
        return $this;
    }

    /**
     * Sets a logger instance
     * 
     * Once set, requests and errors will be logged using the instance.
     * 
     * @param  LoggerInterface $logger The logger
     * @return $this
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
        return $this;
    }

    /**
     * Sets the HTTPInterface used to make requests to the wallet
     * 
     * @param  HTTPInterface $http The HTTPInterface instance
     * @return $this
     */
    public function setHTTP(HTTPInterface $http)
    {
        $this->http = $http;
        return $this;
    }

    /**
     * Returns the HTTPInterface instance used to make requests to the wallet
     * 
     * Automatically creates an instance if none has been set.
     * 
     * @return HTTPInterface
     */
    public function getHTTP()
    {
        if (null === $this->http) {
            $this->http = new HTTP();
        }
        
        return $this->http;
    }

    /**
     * Sets the object used to create request ids
     * 
     * @param  NonceInterface $nonce Any instance of NonceInterface
     * @return $this
     */
    public function setNonce(NonceInterface $nonce)
    {
        $this->nonce = $nonce;
        return $this;
    }
    
    /**
     * {@inheritDoc}
     */
    public function query($method, array $params = [])
    {
        $request = [
            "method" => strtolower($method),
            "params" => $params,
            "id"     => $this->getNonce()
        ];
        $response = $this->exec(json_encode($request));
        $response = json_decode($response, true);
        
        if (!$response) {
            throw new Exceptions\JsonException(
                "Unable to json decode server response."
            );
        }
        if ($response["id"] !== $request["id"]) {
            throw new Exceptions\IdentityException(
                "Server returned ID '{$response['id']}', was expecting '{$request['id']}'."
            );
        }

        return $response["result"];
    }

    /**
     * Sends the query string to the server and returns the response
     *
     * @param  string $query The query string to send
     * @return string
     * @throws Exceptions\RPCException
     */
    protected function exec($query)
    {
        if (!$query) {
            throw new Exceptions\RPCException("Empty query.");
        }
        
        $url = sprintf("http://%s:%d", $this->conf["host"], $this->conf["port"]);
        $http = $this->getHTTP()
            ->setUrl($url)
            ->setContentType("application/json")
            ->setAuthUser($this->conf["user"])
            ->setAuthPass($this->conf["pass"])
            ->setPostData($query);
        $response    = $http->request();
        $status_code = $http->getStatusCode();
        
        $this->log(
            (HTTPStatusCodes::OK == $status_code) ? LogLevel::INFO: LogLevel::ERROR,
            "{$status_code}: '{$url}' => '{$response}'"
        );
        
        if (isset(self::$exceptions[$status_code])) {
            $error     = $this->getResponseError($response, $status_code);
            $exception = __NAMESPACE__ . self::$exceptions[$status_code];
            throw new $exception(
                $error["message"],
                $error["code"]
            );
        }

        return trim($response);
    }

    /**
     * Creates an array of error information based on the server response
     *
     * The Bitcoin api is a real mess. For some errors the server responds with a json encoded string.
     * For other errors an html string is returned, but the format of the html varies depending on
     * the error. Some of the html is well formatted, and can be parsed with SimpleXML, and other html
     * strings are not well formatted.
     * 
     * This method attempts to parse the various error responses, and returns an array with the keys:
     * ```
     *  "message"   - (string)  A message describing the error
     *  "code"      - (int)     An error code
     * ```
     * 
     * Returns `["message" => "", "code" => 0]` when there is no error.
     * 
     * @param  string $response    The server response
     * @param  int    $status_code The http status code
     * @return array
     */
    protected function getResponseError($response, $status_code)
    {
        $error = [
            "message" => "",
            "code"    => 0
        ];
        
        $obj = json_decode($response, true);
        if (!$obj) {
            if (stripos($response, "<H1>401 Unauthorized.</H1>") !== false) {
                $error["message"] = "Unauthorized";
                $error["code"]    = RPCErrorCodes::WALLET_PASSPHRASE_INCORRECT;
            } else if (strpos($response, "<?xml") !== false) {
                $xml = simplexml_load_string($response);
                if ($xml && isset($xml->body->p[0])) {
                    $error["message"] = trim((string)$xml->body->p[0]);
                    $error["message"] = preg_replace("/[\\n\\r]/", "", $error["message"]);
                    $error["message"] = preg_replace("/\\s{2,}/", " ", $error["message"]);
                    $error["code"]    = $status_code;
                } else {
                    $error["message"] = $response;
                    $error["code"]    = $status_code;
                }
            }
        } else if (!empty($obj["error"])) {
            $error = $obj["error"];
        }
        
        return $error;
    }

    /**
     * Logs a message with an arbitrary level when logging is enabled
     *
     * @param  mixed $level     The logging level
     * @param  string $message  The message to log
     * @param  array $context   Values to place into the message
     * @return null
     */
    protected function log($level, $message, array $context = [])
    {
        if ($this->logger) {
            $this->logger->log($level, $message, $context);
        }
    }

    /**
     * Generates and returns a nonce value for use as a request id
     * 
     * @return string
     */
    protected function getNonce()
    {
        if (null === $this->nonce) {
            $this->nonce = new Nonce();
        }
        return $this->nonce->generate();
    }
} 