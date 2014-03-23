<?php
namespace Headzoo\Bitcoin\Wallet\Api\Exceptions;

/**
 * Thrown when the rpc when the api responds with an internal server error status code.
 */
class InternalServerErrorException
    extends HTTPException {}