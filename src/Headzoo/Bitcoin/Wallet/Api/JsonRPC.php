<?php
namespace Headzoo\Bitcoin\Wallet\Api;
use Headzoo\Web\Tools\WebClientInterface;
use Headzoo\Web\Tools\WebClient;
use Headzoo\Web\Tools\WebResponse;
use Headzoo\Web\Tools\HttpMethods;

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
     * @var WebClientInterface
     */
    private $web;

    /**
     * Used to generate request ids
     * @var Nonce
     */
    private $nonce;

    /**
     * Map of http status codes to exceptions that should be thrown
     * @var array
     */
    private static $exceptions = [
        HTTPStatusCodes::UNAUTHORIZED           => Exceptions\AuthenticationException::class,
        HTTPStatusCodes::NOT_FOUND              => Exceptions\MethodNotFoundException::class,
        HTTPStatusCodes::BAD_REQUEST            => Exceptions\BadRequestException::class,
        HTTPStatusCodes::FORBIDDEN              => Exceptions\ForbiddenException::class,
        HTTPStatusCodes::INTERNAL_SERVER_ERROR  => Exceptions\InternalServerErrorException::class
    ];

    /**
     * Constructor
     *
     * @param array              $conf  See the setConf() method
     * @param WebClientInterface $web   Used to make http post requests
     * @param NonceInterface     $nonce Any instance of NonceInterface
     */
    public function __construct(array $conf = [], WebClientInterface $web = null, NonceInterface $nonce = null)
    {
        $this->setConf($conf);
        if (null !== $web) {
            $this->setWebClient($web);
        }
        if (null !== $nonce) {
            $this->setNonce($nonce);
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
     * Sets the WebClientInterface used to make requests to the wallet
     *
     * @param  WebClientInterface $web The WebClientInterface instance
     * @return $this
     */
    public function setWebClient(WebClientInterface $web)
    {
        $this->web = $web;
        return $this;
    }

    /**
     * Returns the WebClientInterface instance used to make requests to the wallet
     *
     * Automatically creates an instance if none has been set.
     *
     * @return WebClientInterface
     */
    public function getWebClient()
    {
        if (null === $this->web) {
            $this->web = new WebClient();
        }
        
        return $this->web;
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
            "id"     => $this->getNonceValue()
        ];
        $response = $this->exec(json_encode($request));
        $response = json_decode($response->getBody(), true);
        
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
     * @return WebResponse
     * @throws Exceptions\RPCException
     */
    protected function exec($query)
    {
        if (!$query) {
            throw new Exceptions\RPCException("Empty query.");
        }
        
        $url = sprintf("http://%s:%d", $this->conf["host"], $this->conf["port"]);
        $web = $this->getWebClient();
        $web->setMethod(HttpMethods::POST);
        $web->addHeader("Content-Type", "application/json");
        $web->setBasicAuth($this->conf["user"], $this->conf["pass"]);
        $web->setData($query);
        $response    = $web->request($url);
        $status_code = $response->getCode();
        
        if (isset(self::$exceptions[$status_code])) {
            $error = $this->getResponseError($response, $status_code);
            throw new self::$exceptions[$status_code](
                $error["message"],
                $error["code"]
            );
        }

        return $response;
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
     * @param  WebResponse $response    The server response
     * @return array
     */
    protected function getResponseError(WebResponse $response)
    {
        $error = [
            "message" => "",
            "code"    => 0
        ];
        
        $response_text = $response->getBody();
        $obj = json_decode($response_text, true);
        if (!$obj) {
            if (stripos($response_text, "<H1>401 Unauthorized.</H1>") !== false) {
                $error["message"] = "Unauthorized";
                $error["code"]    = RPCErrorCodes::WALLET_PASSPHRASE_INCORRECT;
            } else if (strpos($response_text, "<?xml") !== false) {
                $xml = simplexml_load_string($response_text);
                if ($xml && isset($xml->body->p[0])) {
                    $error["message"] = trim((string)$xml->body->p[0]);
                    $error["message"] = preg_replace("/[\\n\\r]/", "", $error["message"]);
                    $error["message"] = preg_replace("/\\s{2,}/", " ", $error["message"]);
                    $error["code"]    = $response->getCode();
                } else {
                    $error["message"] = $response_text;
                    $error["code"]    = $response->getCode();
                }
            }
        } else if (!empty($obj["error"])) {
            $error = $obj["error"];
        }
        
        return $error;
    }

    /**
     * Generates and returns a nonce value for use as a request id
     * 
     * @return string
     */
    protected function getNonceValue()
    {
        if (null === $this->nonce) {
            $this->nonce = new Nonce();
        }
        return $this->nonce->generate();
    }
} 