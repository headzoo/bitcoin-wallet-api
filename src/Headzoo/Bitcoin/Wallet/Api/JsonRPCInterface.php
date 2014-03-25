<?php
namespace Headzoo\Bitcoin\Wallet\Api;

/**
 * Core interface for communicating with a Bitcoin wallet supporting the JSON-RPC API.
 */
interface JsonRPCInterface
{
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