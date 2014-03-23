<?php
namespace Headzoo\Bitcoin\Wallet\Api\Exceptions;

/**
 * Thrown when the rpc when the api responds with a forbidden status code.
 */
class ForbiddenException
    extends RPCException {}