<?php
namespace Headzoo\Bitcoin\Wallet\Api;

/**
 * Used to generate random nonce values.
 */
interface NonceInterface
{
    /**
     * Generates and returns a new nonce value
     * 
     * @return string
     */
    public function generate();
} 