<?php
namespace Headzoo\Bitcoin\Wallet\Api\Exceptions;

/**
 * Thrown when the rpc when the api responds with a bad request status code.
 */
class BadRequestException
    extends HTTPException {}