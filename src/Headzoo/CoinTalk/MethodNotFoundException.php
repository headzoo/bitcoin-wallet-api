<?php
namespace Headzoo\CoinTalk;

/**
 * Thrown when calling an rpc method which does not exist.
 */
class MethodNotFoundException
    extends HTTPException {}