<?php
namespace Headzoo\Bitcoin\Wallet\Api;

/**
 * Interface for the Bitcoin json-rpc.
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
     *  $info = $rpc->query("getinfo");
     *  echo $info["version"];
     *  echo $info["balance"];
     *  echo $info["difficulty"];
     * ```
     *
     * @param  string $method The method to call
     * @param  array  $params The method parameters
     * @return array
     * @throws Exceptions\JsonException When encoding or decoding the server data fails
     * @throws Exceptions\RPCException  When the server returns an error message
     */
    public function query($method, array $params = []);
} 