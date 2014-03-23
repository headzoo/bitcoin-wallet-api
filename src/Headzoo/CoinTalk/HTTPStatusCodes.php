<?php
namespace Headzoo\CoinTalk;

/**
 * The http status codes returned by the api.
 */
class HTTPStatusCodes
{
    /**
     * HTTP status code 200
     */
    const OK                    = 200;

    /**
     * HTTP status code 400
     */
    const BAD_REQUEST           = 400;

    /**
     * HTTP status code 401
     */
    const UNAUTHORIZED          = 401;

    /**
     * HTTP status code 403
     */
    const FORBIDDEN             = 403;

    /**
     * HTTP status code 404
     */
    const NOT_FOUND             = 404;

    /**
     * HTTP status code 500
     */
    const INTERNAL_SERVER_ERROR = 500;
} 