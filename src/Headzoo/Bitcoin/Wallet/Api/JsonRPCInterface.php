<?php
namespace Headzoo\Bitcoin\Wallet\Api;
use Headzoo\Web\Tools\WebClientInterface;

/**
 * Core interface for communicating with a Bitcoin wallet supporting the JSON-RPC API.
 */
interface JsonRPCInterface
{
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
    public function setConf(array $conf);

    /**
     * Sets the WebClientInterface used to make requests to the wallet
     *
     * @param  WebClientInterface $web The WebClientInterface instance
     * @return $this
     */
    public function setWebClient(WebClientInterface $web);

    /**
     * Returns the WebClientInterface instance used to make requests to the wallet
     *
     * Automatically creates an instance if none has been set.
     *
     * @return WebClientInterface
     */
    public function getWebClient();

    /**
     * Sets the object used to create request ids
     *
     * @param  NonceInterface $nonce Any instance of NonceInterface
     * @return $this
     */
    public function setNonce(NonceInterface $nonce);
        
    /**
     * Sends a raw query the litecoind rpc
     *
     * Returns an array which contains the server response.
     *
     * Example:
     * ```php
     *  $rpc  = new JsonRPC();
     *  $info = $rpc->query("getInfo");
     *  echo $info["version"];
     *  echo $info["balance"];
     *  echo $info["difficulty"];
     *
     * $signature = $rpc->query(
     *      "signMessage",
     *      [
     *          "1Headz2mYtpBRo6KFaaUEtcm5Kce6BZRJM",
     *          "Mary had a little lamb."
     *      ]
     * );
     * ```
     * 
     * @see https://en.bitcoin.it/wiki/Original_Bitcoin_client/API_Calls_list
     * @param  string $method The name of the api method to call
     * @param  array  $params Optional method parameters
     * @return array
     * @throws Exceptions\RPCException
     */
    public function query($method, array $params = []);
} 