<?php
namespace Headzoo\Bitcoin\Wallet\Api;

/**
 * Used to generate random nonce values.
 */
class Nonce
{
    /**
     * {@inheritDoc}
     */
    public function generate()
    {
        return (string)str_replace(".", "", uniqid("", true));
    }
} 