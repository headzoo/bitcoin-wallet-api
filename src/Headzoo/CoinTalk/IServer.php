<?php
namespace Headzoo\CoinTalk;

/**
 * Interface for the Bitcoin json-rpc.
 */
interface IServer
{
    /**
     * Sends a raw query the litecoind rpc
     *
     * Returns an array which contains the server response.
     *
     * Example:
     * <code>
     *  $rpc  = new JsonRPC();
     *  $info = $rpc->query("getinfo");
     *  echo $info["version"];
     *  echo $info["balance"];
     *  echo $info["difficulty"];
     * </code>
     *
     * @param  string $method The method to call
     * @param  array  $params The method parameters
     * @return array
     * @throws JsonException            When encoding or decoding the server data fails
     * @throws ServerException          When the server returns an error message
     * @throws MethodNotFoundException  When the method does not exist
     * @throws UnlockNeededException    When trying to call a method which requires an unlocked wallet
     */
    public function query($method, array $params = []);
} 