<?php
namespace Headzoo\Bitcoin\Wallet\Api\Exceptions;

/**
 * Thrown when calling an rpc method which does not exist.
 */
class MethodNotFoundException
    extends HTTPException {}