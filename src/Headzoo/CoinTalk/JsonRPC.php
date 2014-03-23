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
    implements IServer
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
            throw new ServerException($obj["error"]["message"]);
        }
        if ($obj["id"] != $request_id) {
            throw new ServerException(
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
     * @throws HttpException When there was an error sending the request
     * @throws ServerException When the rpc server returns an error message
     */
    protected function exec($query)
    {
        $error_str = null;

        $ch = curl_init("http://{$this->conf['host']}:{$this->conf['port']}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,    1);
        curl_setopt($ch, CURLOPT_POST,              1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,        $query);
        curl_setopt($ch, CURLOPT_HTTPHEADER,        ["Content-Type: application/json"]);
        curl_setopt($ch, CURLOPT_USERPWD,           "{$this->conf['user']}:{$this->conf['pass']}");
        $response    = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (false === $response) {
            $error_str = curl_error($ch);
        }
        curl_close($ch);

        if (null !== $error_str) {
            throw new HttpException($error_str, $status_code);
        }
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
                            throw new ServerException(
                                $response["error"]["message"],
                                $code
                            );
                            break;
                    }
                }
            }
            
            throw new HttpException(
                "Received HTTP status code {$status_code} from the server. '{$response}'.",
                $status_code
            );
        }

        return $response;
    }
} 