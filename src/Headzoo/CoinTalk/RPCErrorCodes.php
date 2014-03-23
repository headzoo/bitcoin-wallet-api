<?php
namespace Headzoo\CoinTalk;

/**
 * Codes for various errors returned by the api.
 */
class RPCErrorCodes
{
    /**
     * Standard error
     */
    const INVALID_REQUEST             = -32600;

    /**
     * The rpc method does not exist
     */
    const METHOD_NOT_FOUND            = -32601;

    /**
     * The rpc parameters are invalid
     */
    const INVALID_PARAMS              = -32602;

    /**
     * Internal error
     */
    const INTERNAL_ERROR              = -32603;

    /**
     * An rpc request parsing error
     */
    const PARSE_ERROR                 = -32700;

    /**
     * std::exception thrown in command handling
     */
    const MISC_ERROR                  = -1;

    /**
     * Server is in safe mode, and command is not allowed in safe mode
     */
    const FORBIDDEN_BY_SAFE_MODE      = -2;

    /**
     * Unexpected type was passed as parameter
     */
    const TYPE_ERROR                  = -3;

    /**
     * Invalid address or key
     */
    const INVALID_ADDRESS_OR_KEY      = -5;

    /**
     * Ran out of memory during operation
     */
    const OUT_OF_MEMORY               = -7;

    /**
     * Invalid, missing or duplicate parameter
     */
    const INVALID_PARAMETER           = -8;

    /**
     * Database error
     */
    const DATABASE_ERROR              = -20;

    /**
     * Error parsing or validating structure in raw format
     */
    const DESERIALIZATION_ERROR       = -22;

    /**
     * Bitcoin is not connected
     */
    const CLIENT_NOT_CONNECTED        = -9;

    /**
     * Still downloading initial blocks
     */
    const CLIENT_IN_INITIAL_DOWNLOAD  = -10;

    /**
     * Node is already added
     */
    const CLIENT_NODE_ALREADY_ADDED   = -23;

    /**
     * Node has not been added before
     */
    const CLIENT_NODE_NOT_ADDED       = -24;

    /**
     * Unspecified problem with wallet (key not found etc.)
     */
    const WALLET_ERROR                = -4;

    /**
     * Not enough funds in wallet or account
     */
    const WALLET_INSUFFICIENT_FUNDS   = -6;

    /**
     * Invalid account name
     */
    const WALLET_INVALID_ACCOUNT_NAME = -11;

    /**
     * Keypool ran out, call fillKeyPool() first
     */
    const WALLET_KEYPOOL_RAN_OUT      = -12;

    /**
     * Enter the wallet passphrase with unlock() first
     */
    const WALLET_UNLOCK_NEEDED        = -13;

    /**
     * The wallet passphrase entered was incorrect
     */
    const WALLET_PASSPHRASE_INCORRECT = -14;

    /**
     * Command given in wrong wallet encryption state (encrypting an encrypted wallet etc.)
     */
    const WALLET_WRONG_ENC_STATE      = -15;

    /**
     * Failed to encrypt the wallet
     */
    const WALLET_ENCRYPTION_FAILED    = -16;

    /**
     * Wallet is already unlocked
     */
    const WALLET_ALREADY_UNLOCKED     = -17; 
} 