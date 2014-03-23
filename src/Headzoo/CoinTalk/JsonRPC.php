<?php
namespace Headzoo\CoinTalk;

/**
 * Used to query the coin rpc server.
 *
 * Example:
 * <code>
 *  $conf = [
 *      "user" => "test",
 *      "pass" => "pass",
 *      "host" => "localhost",
 *      "port" => 9332
 *  ];
 *  $rpc  = new JsonRPC($conf);
 *  $info = $rpc->query("getinfo");
 * </code>
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
     * Constructor
     *
     * @param array $conf See the setConf() method
     */
    public function __construct(array $conf = [])
    {
        $this->setConf($conf);
    }

    /**
     * Sets the configuration for the rpc
     *
     * The configuration array should contain 4 items:
     *  "user" - The rpc username, default "test"
     *  "pass" - The rpc password, default "test"
     *  "host" - The rpc server host, default "localhost"
     *  "port" - The rpc server port, default 9332
     *
     * @param array $conf Configuration for the rpc
     * @return $this
     */
    public function setConf(array $conf)
    {
        $this->conf = array_merge($this->conf, $conf);
        return $this;
    }

    /**
     * Sets the HTTPInterface used to make requests to the wallet
     * 
     * @param HTTPInterface $http The HTTPInterface instance
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
     * {@inheritDoc}
     */
    public function query($method, array $params = [])
    {
        $request_id = rand();
        $query = json_encode([
            "method" => strtolower($method),
            "params" => $params,
            "id"     => $request_id
        ]);
        if (false === $query) {
            throw new JsonException(
                "Unable to encode server request."
            );
        }

        $response = $this->exec($query);
        $obj = json_decode(trim($response), true);
        if (!$obj) {
            throw new JsonException(
                "Unable to decode server response."
            );
        }

        if (!empty($obj["error"])) {
            throw new RPCException($obj["error"]["message"]);
        }
        if ($obj["id"] != $request_id) {
            throw new RPCException(
                "Server returned ID {$obj['id']}, was expecting {$request_id}."
            );
        }

        return $obj["result"];

    }

    /**
     * Sends the query string to the server and returns the response
     *
     * @param string $query The query string to send
     * @return string
     * @throws AuthenticationException When the wrong rpc username or password was sent
     * @throws HTTPException When there was an error sending the request
     * @throws RPCException When the rpc server returns an error message
     */
    protected function exec($query)
    {
        $http = $this->getHTTP()
            ->setUrl("http://{$this->conf['host']}:{$this->conf['port']}")
            ->setContentType("application/json")
            ->setAuthUser($this->conf["user"])
            ->setAuthPass($this->conf["pass"])
            ->setPostData($query);
        $response    = $http->request();
        $status_code = $http->getStatusCode();

        if (HTTPStatusCodes::UNAUTHORIZED == $status_code) {
            throw new AuthenticationException(
                "The RPC username or password was incorrect.",
                $status_code
            );
        }
        if (HTTPStatusCodes::NOT_FOUND == $status_code) {
            $query = json_decode($query, true);
            throw new MethodNotFoundException(
                "The method '{$query['method']}' was not found.",
                RPCErrorCodes::METHOD_NOT_FOUND
            );
        }
        if (HTTPStatusCodes::OK != $status_code) {
            if ($response) {
                $response = json_decode($response, true);
                if (is_array($response) && !empty($response["error"])) {
                    switch($response["error"]["code"]) {
                        case RPCErrorCodes::WALLET_UNLOCK_NEEDED:
                            throw new UnlockNeededException(
                                $response["error"]["message"],
                                $response["error"]["code"]
                            );
                            break;
                        default:
                            $code = !empty($response["error"]["code"])
                                ? $response["error"]["code"]
                                : $status_code;
                            throw new RPCException(
                                $response["error"]["message"],
                                $code
                            );
                            break;
                    }
                }
            }

            throw new RPCException(
                "Received HTTP status code {$status_code} from the server. '{$response}'.",
                $status_code
            );
        }

        return $response;
    }
} 