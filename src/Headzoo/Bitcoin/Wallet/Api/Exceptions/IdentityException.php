<?php
namespace Headzoo\Bitcoin\Wallet\Api\Exceptions;

/**
 * Thrown when the wallet server identifies itself incorrectly.
 * 
 * This usually means the server returned a request id (nonce) different than the id we sent.
 */
class IdentityException
    extends RPCException {}