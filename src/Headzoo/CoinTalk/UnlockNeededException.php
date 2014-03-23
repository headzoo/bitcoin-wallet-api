<?php
namespace Headzoo\CoinTalk;

/**
 * Thrown when calling an rpc method on a locked wallet which requires an unlocked wallet.
 */
class UnlockNeededException
    extends RPCException {}