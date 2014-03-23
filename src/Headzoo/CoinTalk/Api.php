<?php
namespace Headzoo\CoinTalk;

/**
 * Server wrapper class
 *
 * Wraps a Server instance, and provides concrete methods for each of the
 * methods provided by the server.
 *
 * Example:
 * <code>
 *  $conf = [
 *      "user" => "test",
 *      "pass" => "pass",
 *      "host" => "localhost",
 *      "port" => 9332
 *  ];
 *  $server = new Server($conf);
 *  $api    = new Api($server);
 *  $info   = $api->getInfo();
 * </code>
 *
 * @see https://en.bitcoin.it/wiki/Original_Bitcoin_client/API_Calls_list
 *      
 * Note: Some of the methods in this class are not supported by old wallets. Upgrade your wallet to the most recent
 * version to ensure 100% compatibility.
 *
 * Note: Internally the methods cast each argument to expected types (instead of simply using func_get_args()) to catch
 * type errors. Be sure to have error reporting turned on during development to catch those errors.
 */
class Api
{
    /**
     * Used to query the coin server
     * @var IServer
     */
    protected $server;

    /**
     * Constructor
     *
     * @param IServer $server Needed to communicate with the server
     */
    public function __construct(IServer $server)
    {
        $this->server = $server;
    }

    /**
     * Returns the IServer instance being wrapped
     * 
     * @return IServer
     */
    public function server()
    {
        return $this->server;
    }

    /**
     * Returns a multi-signature address
     *
     * Returns an array with the following keys:
     *  "address"       - The multi-signature address
     *  "redeemScript"  - The redeem script
     *
     * @param  int   $nrequired Number of keys needed to redeem
     * @param  array $keys      Array of public keys
     * @return array
     */
    public function createMultiSig($nrequired, array $keys)
    {
        $args = [
            (int)$nrequired,
            $keys
        ];
        return $this->server->query(__FUNCTION__, $args);
    }
    
    /**
     * Add a nrequired-to-sign multisignature address to the wallet
     *
     * Each key is a bitcoin address or hex-encoded public key. If $account is specified, assign address to $account.
     * 
     * Returns the The multi-signature address.
     *
     * @param  int    $nrequired Number of keys needed to redeem
     * @param  array  $keys      Array of public keys
     * @param  string $account   Name of account which receives the address
     * @return string
     */
    public function addMultiSigAddress($nrequired, array $keys, $account = null)
    {
        // Can't use null for $account. Must be left out of the args completely when not specified.
        $args = [
            (int)$nrequired,
            $keys
        ];
        if (null !== $account) {
            $args[] = (string)$account;
        }
        return $this->server->query(__FUNCTION__, $args);
    }

    /**
     * Attempts add or remove a node from the addnode list or try a connection to it once
     *
     * @param  string $node The node ip address and port in <ip>:<port> format (see getPeerInfo() for nodes)
     * @param  string $type Use "add" to add a node to the list, "remove" to remove a node from the list, "onetry" to try a connection to the node once
     * @return bool
     */
    public function addNode($node, $type = "")
    {
        $args = [
            (string)$node,
            (string)$type
        ];
        return null === $this->server->query(__FUNCTION__, $args);
    }

    /**
     * Safely copies wallet.dat to destination
     * 
     * The destination can be a directory or a path with filename.
     *
     * @param  string $destination The destination directory or file
     * @return bool
     */
    public function backupWallet($destination)
    {
        $args = [
            (string)$destination
        ];
        return null === $this->server->query(__FUNCTION__, $args);
    }

    /**
     * Returns a hex-encoded raw transaction spending the given inputs and sending to the given addresses
     *
     * The $transactions argument is a multidimensional array, which each value being an array with the following keys:
     *  "txid"  - The transaction id.
     *  "vout"  - The output number.
     * 
     * The $addresses argument is an associative array using addresses for keys, and amounts to send to the address
     * as values. For example:
     *  [
     *      "1Headz2mYtpBRo6KFaaUEtcm5Kce6BZRJM" => 0.5,
     *      "1FVCaRTKQtpxeE4gypz69NvDkyZUd7Y3SJ" => 0.08
     *  ]
     * 
     * Note: This method only creates the raw transaction data. The transaction's inputs are not signed, and it is not
     * stored in the wallet or transmitted to the network.
     * 
     * Example:
     * <code>
     *  $transactions = [
     *      [
     *          "txid" => "7de4c9a1e715a9aaf6f8573ce16f8bc3c06f927826e2d0c39424e1524eccda89",
     *          "vout" => 1
     *      ],
     *      [
     *          "tdid" => "d2e611dcb3348c315dadeaa959cff662328f124e3a3e80fe8f33056bac95b9fe",
     *          "vout" => 2
     *      ]
     *  ];
     *  $addresses = [
     *      "1Headz2mYtpBRo6KFaaUEtcm5Kce6BZRJM" => 0.5,
     *      "13P4LpjYyBvWt283DffjsHpoFWFprr9dVq" => 0.08
     *  ];
     *  $raw = $api->createRawTransaction($transactions, $addresses);
     * </code>
     * 
     * @param  array $transactions The transactions
     * @param  array $addresses    Array using addresses for keys, and amounts for values
     * @return array
     */
    public function createRawTransaction(array $transactions, array $addresses)
    {
        $args = [
            $transactions,
            $addresses
        ];
        return $this->server->query(__FUNCTION__, $args);
    }

    /**
     * Decodes a raw serialized transaction
     *
     * Given a serialized, hex-encoded transaction, the method decodes it, and returns an array of the transaction
     * information.
     * 
     * Returns an array with the following keys:
     *  "hex"               - (string) The serialized, hex-encoded data.
     *  "txid"              - (string) The transaction id.
     *  "version"           - (int) The version.
     *  "locktime"          - (int) The lock time.
     *  "vin"               - (array) An array with the following keys:
     *      "txid"          - (string) The transaction id.
     *      "vout"          - (int) The vout index.
     *      "scriptSig"     - (array) The script, an array with keys:
     *          "asm"       - (string) Script in asm format.
     *          "hex"       - (string) Script in hex format.
     *      "sequence"      - (int) The script sequence number.
     *  "vout"              - (array) An array with the following keys:
     *      "value"         - (double) The amount sent.
     *      "n"             - (int) The index.
     *      "scriptPubKey"  - (array) An array with the following keys:
     *          "asm"       - (string) The script in asm format.
     *          "hex"       - (string) The script in hex format.
     *          "reqSigs"   - (int) The number of required sigs.
     *          "type"      - (string) The type, eg 'pubkeyhash'.
     *          "addresses" - (array) An array of addresses.
     *  "blockhash"         - (string) The block hash.
     *  "confirmations"     - (int) The number of confirmations.
     *  "time"              - (int) The transaction time in seconds since epoch (Jan 1 1970 GMT).
     *  "blocktime"         - (int) The block time in seconds since epoch (Jan 1 1970 GMT).
     * 
     * @param  string $hex_string The serialized, hex-encoded transaction data
     * @return array
     */
    public function decodeRawTransaction($hex_string)
    {
        $args = [
            (string)$hex_string
        ];
        return $this->server->query(__FUNCTION__, $args);
    }

    /**
     * Returns the private key for the given address
     *
     * Returns null when the address does not belong to any wallet account.
     * 
     * @param  string $address The address for the private key
     * @return string
     * @throws ServerException
     */
    public function dumpPrivKey($address)
    {
        $args = [
            (string)$address
        ];
        
        $priv_key = null;
        try {
            $priv_key = $this->server->query(__FUNCTION__, $args);
        } catch (ServerException $e) {
            if (strpos($e->getMessage(), "not known") === false) {
                throw $e;
            }
        }
        
        return $priv_key;
    }

    /**
     * Encrypts the wallet with the given pass phrase
     *
     * After this, any calls that interact with private keys such as sending or signing will require the passphrase to
     * be set prior the making these calls. Use the walletPassPhrase() for this, and then walletLock(). If the wallet
     * is already encrypted, use the walletPassPhraseChange() method.
     * 
     * Note: This will shutdown the server.
     * 
     * @param  string $pass_phrase The pass phrase to encrypt the wallet with. It must be at least 1 character, but should be long
     * @return bool
     */
    public function encryptWallet($pass_phrase)
    {
        $args = [
            (string)$pass_phrase
        ];
        return null === $this->server->query(__FUNCTION__, $args);
    }

    /**
     * Returns the account associated with the given address
     *
     * Returns null when an account does not exist for the given address.
     * 
     * @param  string $address The address for account lookup
     * @return string|null
     */
    public function getAccount($address)
    {
        $args = [
            (string)$address
        ];
        $account = $this->server->query(__FUNCTION__, $args);
        
        return !empty($account) ? $account : null;
    }

    /**
     * Returns the current address for receiving payments to this account
     *
     * The account does not need to exist, it will be created and a new address created if there is no account by
     * the given name.
     * 
     * @param  string $account The account name for the address. It can also be set to the empty string "" to represent the default account
     * @return string
     */
    public function getAccountAddress($account)
    {
        $args = [
            (string)$account
        ];
        return $this->server->query(__FUNCTION__, $args);
    }

    /**
     * Returns information about the given added node, or all added nodes
     *
     * If dns is false, only a list of added nodes will be provided, otherwise connected information will also
     * be available.
     * 
     * Note: Nodes added using addNode() and "onetry" nodes are not returned.
     * 
     * When $dns is false, returns multidimensional array, with sub-arrays containing the keys:
     *  "addednode"     - (string) The node ip address and port in format <ip>:<port>.
     * 
     * When $dns is true, returns a mutlidimentional array, with the sub-arrays containing the keys:
     *  "addednode"     - (string)  The node ip address and port in format <ip>:<port>.
     *  "connected"     - (boolean) If connected.
     *  "addresses"     - (array)   Array of node peers. Each sub-array contains the keys:
     *      "address"   - (string)  The node ip address and port in format <ip>:<port>.
     *      "connected" - (bool)    If connected.
     *
     * @param  bool   $dns  If false, only a list of added nodes will be provided, otherwise connected information will also be available
     * @param  string $node If provided, return information about this specific node, otherwise all nodes are returned
     * @return array
     */
    public function getAddedNodeInfo($dns, $node = null)
    {
        // Can't pass null as the second arg. The arg must not exist.
        $args = [
            (bool)$dns
        ];
        if (null !== $node) {
            $args[] = (string)$node;
        }
        return $this->server->query(__FUNCTION__, $args);
    }

    /**
     * Returns an array of addresses for the given account
     * 
     * @param  string $account The account name or "" for the default account
     * @return array
     */
    public function getAddressesByAccount($account)
    {
        $args = [
            (string)$account
        ];
        return $this->server->query(__FUNCTION__, $args);
    }

    /**
     * Returns the balance of the given account
     *
     * If $account is not specified, returns the server's total available balance. If $account is specified, returns
     * the balance in the account.
     *
     * @param  string $account The selected account, or "*" for entire wallet. It may be the default account using "".
     * @param  int    $minconf Only include transactions confirmed at least this many times
     * @return double
     */
    public function getBalance($account = "", $minconf = 1)
    {
        $args = [
            (string)$account,
            (int)$minconf
        ];
        return $this->server->query(__FUNCTION__, $args);
    }

    /**
     * Returns the hash of the best (tip) block in the longest block chain
     *
     * @return string
     */
    public function getBestBlockHash()
    {
        return $this->server->query(__FUNCTION__);
    }

    /**
     * Returns the number of blocks in the longest block chain
     *
     * @return int
     */
    public function getBlockCount()
    {
        return $this->server->query(__FUNCTION__);
    }

    /**
     * Returns information about the block with the given hash
     *
     * When $verbose is set to false, this method returns the serialized and hex-encoded block data.
     * 
     * When $verbose is set to true, the return value will be an array with the following keys:
     *  "hash"              - (string)  The block hash (same as provided).
     *  "confirmations"     - (int)     The number of confirmations.
     *  "size"              - (int)     The block size.
     *  "height"            - (int)     The block height or index.
     *  "version"           - (int)     The block version.
     *  "merkleroot"        - (string)  The merkle root.
     *  "tx"                - (array)   The transaction ids.
     *  "time"              - (int)     The block time in seconds since epoch (Jan 1 1970 GMT).
     *  "nonce"             - (double)  The nonce.
     *  "bits"              - (string)  The bits.
     *  "difficulty"        - (double)  The difficulty.
     *  "previousblockhash" - (string)  The hash of the previous block.
     *  "nextblockhash"     - (string)  The hash of the next block.
     * 
     * @param  string $hash    The block hash
     * @param  bool   $verbose True for an array, false for the hex encoded data
     * @return array|string
     */
    public function getBlock($hash, $verbose = true)
    {
        $args = [
            (string)$hash,
            (bool)$verbose
        ];
        return $this->server->query(__FUNCTION__, $args);
    }
    
    /**
     * Returns hash of block in best-block-chain at $index
     *
     * Index 0 is the genesis block.
     *
     * @param  int $index The block index
     * @return string
     */
    public function getBlockHash($index)
    {
        $args = [
            (int)$index
        ];
        return $this->server->query(__FUNCTION__, $args);
    }

    /**
     * Returns data needed to construct a block to work on
     * 
     * If the $mode argument is set, that is used to explicitly select between the default "template"
     * request or a "proposal".
     * 
     * The returned array contains the following keys:
     *  "version"               - (int)     The block version.
     *  "previousblockhash"     - (string)  The hash of current highest block.
     *  "transactions"          - (array)   Array of non-coinbase transactions which should be included in the block. Each contains the following keys:
     *      "data"              - (string)  Transaction data encoded in hexadecimal (byte-for-byte).
     *      "hash"              - (string)  Hash/id encoded in little-endian hexadecimal.
     *      "depends"           - (array)   Array of numbers.
     *      "fee"               - (int)     Difference in value between transaction inputs and outputs (in Satoshis); for coinbase transactions, this is a negative Number of the total collected block fees (ie, not including the block subsidy); if key is not present, fee is unknown and clients MUST NOT assume there isn't one.
     *      "sigops"            - (int)     Total number of SigOps, as counted for purposes of block limits; if key is not present, sigop count is unknown and clients MUST NOT assume there aren't any.
     *      "required"          - (boolean) If provided and true, this transaction must be in the final block.
     *  "coinbaseaux"           - (array)   Array of data that should be included in the coinbase's scriptSig content. Contains the following key:
     *      "flags"             - (string)  The data to include.
     *  "coinbasevalue"         - (double)  Maximum allowable input to coinbase transaction, including the generation award and transaction fees (in Satoshis).
     *  "coinbasetxn"           - (array)   Information for coinbase transaction.
     *  "target"                - (string)  The hash target.
     *  "mintime"               - (int)     The minimum timestamp appropriate for next block time in seconds since epoch (Jan 1 1970 GMT).
     *  "mutable"               - (array)   List of ways the block template may be changed. Contains the following keys:
     *      "value"             - (string)  A way the block template may be changed, e.g. 'time', 'transactions', 'prevblock'.
     *  "noncerange"            - (string)  A range of valid nonces.
     *  "sigoplimit"            - (int)     Limit of sigops in blocks.
     *  "sizelimit"             - (int)     Limit of block size.
     *  "curtime"               - (int)     Current timestamp in seconds since epoch (Jan 1 1970 GMT).
     *  "bits"                  - (string)  Compressed target of next block.
     *  "height"                - (int)     The height of the next block.
     * 
     * @see https://en.bitcoin.it/wiki/BIP_0022
     * @param  array        $capabilities An array of supported features, "longpoll", "coinbasetxn", "coinbasevalue", "proposal", "serverlist", "workid"
     * @param  string|null  $mode         This must be set to "template" or omitted
     * @return array
     */
    public function getBlockTemplate(array $capabilities = [], $mode = null)
    {
        $params = new \stdClass();
        $params->capabilities = $capabilities;
        if (null !== $mode) {
            $params->mode = $mode;
        }
        $args = [
            $params
        ];
        return $this->server->query(__FUNCTION__, $args);
    }

    /**
     * Returns the number of connections to other nodes
     *
     * @return int
     */
    public function getConnectionCount()
    {
        return $this->server->query(__FUNCTION__);
    }

    /**
     * Returns the proof-of-work difficulty as a multiple of the minimum difficulty
     *
     * @return double
     */
    public function getDifficulty()
    {
        return $this->server->query(__FUNCTION__);
    }

    /**
     * Returns true or false whether the wallet is currently generating hashes
     *
     * @return bool
     */
    public function getGenerate()
    {
        return $this->server->query(__FUNCTION__);
    }

    /**
     * Returns a recent hashes per second performance measurement while generating
     *
     * See the getGenerate() and setGenerate() calls to turn generation on and off.
     * 
     * @return int
     */
    public function getHashesPerSec()
    {
        return $this->server->query(__FUNCTION__);
    }

    /**
     * Returns an array containing various state info
     *
     * The returned array contains the following keys:
     *  "version"           - (int)     The server version.
     *  "protocolversion"   - (int)     The protocol version.
     *  "walletversion"     - (int)     The wallet version.
     *  "balance"           - (double)  The total bitcoin balance of the wallet.
     *  "blocks"            - (int)     The current number of blocks processed in the server.
     *  "timeoffset"        - (int)     The time offset.
     *  "connections"       - (int)     The number of connections.
     *  "proxy"             - (string)  The proxy used by the server.
     *  "difficulty"        - (double)  The current difficulty.
     *  "testnet"           - (boolean) If the server is using testnet or not.
     *  "keypoololdest"     - (int)     The timestamp (seconds since GMT epoch) of the oldest pre-generated key in the key pool.
     *  "keypoolsize"       - (int)     How many new keys are pre-generated.
     *  "unlocked_until"    - (int)     The timestamp in seconds since epoch (midnight Jan 1 1970 GMT) that the wallet is unlocked for transfers, or 0 if the wallet is locked.
     *  "paytxfee"          - (double)  The transaction fee set in btc/kb.
     *  "errors"            - (string)  Any error messages.
     * 
     * @return array
     */
    public function getInfo()
    {
        return $this->server->query(__FUNCTION__);
    }

    /**
     * Returns an array of mining related information
     * 
     * The returned array contains the following keys:
     *  "blocks"            - (int)     The current block.
     *  "currentblocksize"  - (int)     The last block size.
     *  "currentblocktxt"   - (int)     The last block transaction.
     *  "difficulty"        - (double)  The current difficulty.
     *  "errors"            - (string)  Current errors.
     *  "generate"          - (boolean) If the generation is on or off.
     *  "genproclimit"      - (int)     The processor limit for generation. -1 if no generation.
     *  "hashespersec"      - (int)     The hashes per second of the generation, or 0 if no generation.
     *  "networkhashps"     - (double)  The estimated network hashes per second based on the last n blocks.
     *  "pooledtxt"         - (int)     The size of the mem pool.
     *  "testnet"           - (boolean) If using testnet or not.
     *
     * @return array
     */
    public function getMiningInfo()
    {
        return $this->server->query(__FUNCTION__);
    }

    /**
     * Returns a new address for receiving payments
     *
     * If $account is specified (recommended), it is added to the address book so payments received with the address
     * will be credited to $account.
     *
     * @param  string $account The account name for the address to be linked to. if not provided, the default account "" is used
     * @return string
     */
    public function getNewAddress($account = "")
    {
        $args = [
            (string)$account
        ];
        return $this->server->query(__FUNCTION__, $args);
    }

    /**
     * Returns an array describing each connected node
     *
     * Returns an associative array, which each sub-array containing the following keys:
     *  "addr"              - (string)  The ip address and port of the peer.
     *  "addrlocal"         - (string)  The local address.
     *  "services"          - (string)  The supported services.
     *  "lastsend"          - (int)     The time in seconds since epoch (Jan 1 1970 GMT) of the last send.
     *  "lastrecv"          - (int)     The time in seconds since epoch (Jan 1 1970 GMT) of the last receive.
     *  "bytessent"         - (int)     The total bytes sent.
     *  "bytesrecv"         - (int)     The total bytes received.
     *  "conntime"          - (int)     The connection time in seconds since epoch (Jan 1 1970 GMT).
     *  "pingtime"          - (double)  The ping time.
     *  "version"           - (int)     The peer version, such as 7001.
     *  "subver"            - (string)  The string version, such as "Satoshi:0.8.5".
     *  "inbound"           - (boolean) Inbound (true) or Outbound (false).
     *  "startingheight"    - (int)     The starting height (block) of the peer.
     *  "banscore"          - (int)     The ban score (stats.nMisbehavior).
     *  "syncnode"          - (boolean) True if sync node.
     * 
     * @return array
     */
    public function getPeerInfo()
    {
        return $this->server->query(__FUNCTION__);
    }

    /**
     * Returns a new address for receiving change
     *
     * This is for use with raw transactions, NOT normal use.
     *
     * @param  string $account Name of the account or "" for the default account
     * @return string
     */
    public function getRawChangeAddress($account = "")
    {
        $args = [
            (string)$account
        ];
        return $this->server->query(__FUNCTION__, $args);
    }

    /**
     * Returns an array of transaction ids in memory pool
     *
     * @return array
     */
    public function getRawMemPool()
    {
        return $this->server->query(__FUNCTION__);
    }

    /**
     * Returns raw transaction representation for given transaction id
     *
     * Returns the raw transaction data as a string when $verbose is 0. Use decodeRawTransaction() to convert the
     * transaction data into an array.
     *
     * Returns an array with the following keys when $verbose is 1.
     *  "hex"               - (string) The serialized, hex-encoded data.
     *  "txid"              - (string) The transaction id.
     *  "version"           - (int) The version.
     *  "locktime"          - (int) The lock time.
     *  "vin"               - (array) An array with the following keys:
     *      "txid"          - (string) The transaction id.
     *      "vout"          - (int) The vout index.
     *      "scriptSig"     - (array) The script, an array with keys:
     *          "asm"       - (string) Script in asm format.
     *          "hex"       - (string) Script in hex format.
     *      "sequence"      - (int) The script sequence number.
     *  "vout"              - (array) An array with the following keys:
     *      "value"         - (double) The amount sent.
     *      "n"             - (int) The index.
     *      "scriptPubKey"  - (array) An array with the following keys:
     *          "asm"       - (string) The script in asm format.
     *          "hex"       - (string) The script in hex format.
     *          "reqSigs"   - (int) The number of required sigs.
     *          "type"      - (string) The type, eg 'pubkeyhash'.
     *          "addresses" - (array) An array of addresses.
     *  "blockhash"         - (string) The block hash.
     *  "confirmations"     - (int) The number of confirmations.
     *  "time"              - (int) The transaction time in seconds since epoch (Jan 1 1970 GMT).
     *  "blocktime"         - (int) The block time in seconds since epoch (Jan 1 1970 GMT).
     * 
     * @param  string $txid     The transaction id
     * @param  int    $verbose  If 0, return a string, other return a json object
     * @return array
     */
    public function getRawTransaction($txid, $verbose = 0)
    {
        $args = [
            (string)$txid,
            (int)$verbose
        ];
        return $this->server->query(__FUNCTION__, $args);
    }

    /**
     * Returns the total amount received by addresses with $account in transactions with at least $minconf
     * confirmations.
     *
     * If $account not provided return will include all transactions to all accounts.
     *
     * @param  string $account The selected account, may be the default account using ""
     * @param  int    $minconf Only include transactions confirmed at least this many times
     * @return double
     */
    public function getReceivedByAccount($account = "", $minconf = 1)
    {
        $args = [
            (string)$account,
            (int)$minconf
        ];
        return $this->server->query(__FUNCTION__, $args);
    }

    /**
     * Returns the amount received by $address in transactions with at least $minconf confirmations
     *
     * It correctly handles the case where someone has sent to the address in multiple transactions. Keep in mind that
     * addresses are only ever used for receiving transactions. Works only for addresses in the local wallet, external
     * addresses will always show 0.
     *
     * @param  string $address The address for transactions
     * @param  int    $minconf Only include transactions confirmed at least this many times
     * @return double
     */
    public function getReceivedByAddress($address, $minconf = 1)
    {
        $args = [
            (string)$address,
            (int)$minconf
        ];
        return $this->server->query(__FUNCTION__, $args);
    }

    /**
     * Returns detailed information about in-wallet transaction
     *
     * This method cannot be used to get information about non-wallet transactions. Use getRawTransaction() for
     * non-wallet transactions.
     * 
     * The returned array will contain the following keys:
     *  "amount"        - (double) The transaction amount.
     *  "fee"           - (double) The transaction fee.
     *  "confirmations" - (int) The number of confirmations.
     *  "blockhash"     - (string) The block hash.
     *  "blockindex"    - (int) The block index.
     *  "blocktime"     - (int) The time in seconds since epoch (1 Jan 1970 GMT).
     *  "txid"          - (string) The transaction id.
     *  "time"          - (int) The transaction time in seconds since epoch (1 Jan 1970 GMT).
     *  "timereceived"  - (int) The time received in seconds since epoch (1 Jan 1970 GMT).
     *  "details"       - 
     *      "account"   - (string) The account name involved in the transaction, can be "" for the default account.
     *      "address"   - (string) The address involved in the transaction.
     *      "category"  - (string) The category, either "send" or "receive".
     *      "amount"    - (double) The amount.
     *      "fee"       - (double) The transaction fee.
     *
     * @param  string $txid The transaction id
     * @return array
     */
    public function getTransaction($txid)
    {
        $args = [
            (string)$txid
        ];
        return $this->server->query(__FUNCTION__, $args);
    }

    /**
     * Returns details about an unspent transaction output
     * 
     * Returns an array with the following keys:
     *  "bestblock"         - (string) the block hash.
     *  "confirmations"     - (numeric) The number of confirmations.
     *  "value"             - (numeric) The transaction value.
     *  "scriptPubKey"      - (array) The script, an array with the following keys:
     *      "asm"           - (string) The code in asm format.
     *      "hex"           - (string) The code in hex format.
     *      "regSigs"       - (int) Number of required signatures.
     *      "type"          - (string) The type, eg "pubkeyhash".
     *      "addresses"     - (array) An array of addresses.
     *  "version"           - (int) The version.
     *  "coinbase"          - (bool) Coinbase transaction or not.
     * 
     * @param  string $txid             The transaction id
     * @param  int    $n                The vout value
     * @param  bool   $include_mem_pool Whether to included the mem pool
     * @return array
     */
    public function getTxOut($txid, $n, $include_mem_pool = true)
    {
        $args = [
            (string)$txid,
            (int)$n,
            (bool)$include_mem_pool
        ];
        return $this->server->query(__FUNCTION__, $args);
    }

    /**
     * Returns statistics about the unspent transaction output set
     *
     * Note this call may take some time.
     * 
     * Returns an array with the following keys:
     *  "height"            - (int) The current block height.
     *  "bestblock"         - (string) The best block hash hex.
     *  "transactions"      - (int) The number of transactions.
     *  "txouts"            - (int) The number of output transactions.
     *  "bytes_serialized"  - (int) The serialized size.
     *  "hash_serialized"   - (string) The serialized hash.
     *  "total_amount"      - (double) The total amount.
     * 
     * @return array
     */
    public function getTxOutSetInfo()
    {
        return $this->server->query(__FUNCTION__);
    }

    /**
     * Returns work data, or works on existing data
     *
     * If $data is not specified, returns formatted hash data to work on. If $data is specified, tries to solve the
     * block and returns a boolean value indicating success or failure.
     *
     * When $data is not specified, the return value will be an array with the following keys:
     *  "midstate"  - The precomputed hash state after hashing the first half of the data (DEPRECATED).
     *  "data"      - The serialized block data.
     *  "hash1"     - The formatted hash buffer for second hash (DEPRECATED).
     *  "target"    - The little endian hash target.
     * 
     * @param  string $data The hex encoded data to solve
     * @return array|bool
     */
    public function getWork($data = null)
    {
        // Strangely getwork won't accept null or an empty string. No arguments should be sent when $data is null.
        if (null === $data) {
            $args = [];
        } else {
            $args = [
                (string)$data
            ];
        }
        return $this->server->query(__FUNCTION__, $args);
    }

    /**
     * Adds a private key to the wallet
     *
     * Rescanning may take a while looking for existing transactions, and may even freeze up the wallet.
     *
     * @param  string $priv_key The private key
     * @param  string $label    An optional label
     * @param  bool   $rescan   Whether to rescan the wallet for transactions
     * @return bool
     */
    public function importPrivKey($priv_key, $label, $rescan = true)
    {
        $args = [
            (string)$priv_key,
            (string)$label,
            (bool)$rescan
        ];
        return null === $this->server->query(__FUNCTION__, $args);
    }

    /**
     * Fills the keypool
     *
     * @return array
     */
    public function keyPoolRefill()
    {
        return null === $this->server->query(__FUNCTION__);
    }

    /**
     * Returns array that has account names as keys, account balances as values
     *
     * Example return value:
     *  [
     *      ""       => 5.31,
     *      "Paper1" => 123.34,
     *      "Mining" => 15.98
     *  ]
     * 
     * @param  int $minconf Only include transactions with at least this many confirmations
     * @return array
     */
    public function listAccounts($minconf = 1)
    {
        $args = [
            (int)$minconf
        ];
        return $this->server->query(__FUNCTION__, $args);
    }

    /**
     * Returns groups of addresses which have had their common ownership made public by common use as inputs or as the
     * resulting change in past transactions
     *
     * Example return value:
     * [
     *  [
     *      [
     *          "MKnsZ7hDFaf9ozLaEhjKkoktDhQeQ8sBcH",   // The address
     *          0.10747106                              // The amount
     *      ]
     *  ]
     * ]
     * 
     * @return array
     */
    public function listAddressGroupings()
    {
        return $this->server->query(__FUNCTION__);
    }

    /**
     * Returns balances by account
     *
     * Returns an associative array, which each sub-array containing the following keys:
     *  "account"       - The account name of the receiving account.
     *  "amount"        - The total amount received by addresses with this account.
     *  "confirmations" - The number of confirmations of the most recent transaction included.
     *
     * @param  int  $minconf        Include transactions with at least this number of confirmations
     * @param  bool $include_empty  Include empty accounts or not
     * @return array
     */
    public function listReceivedByAccount($minconf = 1, $include_empty = false)
    {
        $args = [
            (int)$minconf,
            (bool)$include_empty
        ];
        return $this->server->query(__FUNCTION__, $args);
    }

    /**
     * Returns balances by receiving address
     * 
     * Returns an associative array, which each sub-array containing the following keys:
     *  "address"       - The receiving address.
     *  "account"       - The account of the receiving address. The default account is "".
     *  "amount"        - The total amount received by the address.
     *  "confirmations" - The number of confirmations of the most recent transaction included.
     *  "txids"         - An array of transaction ids.
     *
     * To get a list of accounts on the system, call listReceivedByAddress(0, true).
     *
     * @param  int  $minconf       The minimum number of confirmations before payments are included
     * @param  bool $include_empty Whether to include addresses that haven't received any payments
     * @return array
     */
    public function listReceivedByAddress($minconf = 1, $include_empty = false)
    {
        $args = [
            (int)$minconf,
            (bool)$include_empty
        ];
        return $this->server->query(__FUNCTION__, $args);
    }

    /**
     * Get all transactions in blocks since block $hash
     *
     * Returns all transaction if $hash is omitted.
     *
     * The return value will be an associative array:
     *  "lastblock"         - The hash of the last block.
     *  "transactions"      - An array of one or more transactions. Each transaction will contain the following keys:
     *      "account"           - The account name associated with the transaction. Will be "" for the default account.
     *      "address"           - The address of the transaction. Not present for move transactions (category = move).
     *      "category"          - The type of transaction, eg "send", "receive", or "move".
     *      "amount"            - The transaction amount. This is negative for the "send" category, and for the 'move' category for moves outbound, otherwise it's positive.
     *      "fee"               - The transaction fee. This is negative and only available for the 'send' category of transactions.
     *      "confirmations"     - The number of confirmations for the transaction. Available for 'send' and 'receive' category of transactions.
     *      "blockhash"         - The block hash containing the transaction. Available for 'send' and 'receive' category of transactions.
     *      "blockindex"        - The block index containing the transaction. Available for 'send' and 'receive' category of transactions.
     *      "blocktime"         - The block time in seconds since epoch (1 Jan 1970 GMT).
     *      "txid"              - The transaction id.
     *      "time"              - The transaction time in seconds since epoch (Jan 1 1970 GMT).
     *      "timereceived"      - The time received in seconds since epoch (Jan 1 1970 GMT). Available for 'send' and 'receive' category of transactions.
     *      "comment"           - If a comment is associated with the transaction.
     *      "to"                - If a comment to is associated with the transaction.
     * 
     * @param  string $hash                 The block hash to list transactions since
     * @param  int    $target_confirmations The confirmations required, must be 1 or more
     * @return array
     */
    public function listSinceBlock($hash = null, $target_confirmations = 1)
    {
        $args = [
            (string)$hash,
            (int)$target_confirmations
        ];
        return $this->server->query(__FUNCTION__, $args);
    }

    /**
     * Returns up to $count most recent transactions
     *
     * The first $from transactions are skipped. If $account not provided will return recent transaction from all
     * accounts.
     * 
     * The return value will be an associative array, with each sub-array containing the following keys:
     *  "account"           - The account name associated with the transaction. Will be "" for the default account.
     *  "address"           - The address of the transaction. Not present for move transactions (category = move).
     *  "category"          - The type of transaction, eg "send", "receive", or "move".
     *  "amount"            - The transaction amount. This is negative for the "send" category, and for the 'move' category for moves outbound, otherwise it's positive.
     *  "fee"               - The transaction fee. This is negative and only available for the 'send' category of transactions.
     *  "confirmations"     - The number of confirmations for the transaction. Available for 'send' and 'receive' category of transactions.
     *  "blockhash"         - The block hash containing the transaction. Available for 'send' and 'receive' category of transactions.
     *  "blockindex"        - The block index containing the transaction. Available for 'send' and 'receive' category of transactions.
     *  "blocktime"         - The block time in seconds since epoch (1 Jan 1970 GMT).
     *  "txid"              - The transaction id.
     *  "time"              - The transaction time in seconds since epoch (Jan 1 1970 GMT).
     *  "timereceived"      - The time received in seconds since epoch (Jan 1 1970 GMT). Available for 'send' and 'receive' category of transactions.
     *  "comment"           - If a comment is associated with the transaction.
     *
     * @param  string $account The name of the account
     * @param  int    $count   Number of transactions to return
     * @param  int    $from    Offset from the last transaction
     * @return array
     */
    public function listTransactions($account, $count = 100, $from = 0)
    {
        $args = [
            (string)$account,
            (int)$count,
            (int)$from
        ];
        return $this->server->query(__FUNCTION__, $args);
    }

    /**
     * Returns array of unspent transaction inputs in the wallet between $minconf and $maxconf
     *
     * The returned array will contain the following keys:
     *  "txid"          - Thr transaction id
     *  "vout"          - The vout value
     *  "address"       - The address
     *  "account"       - The associated account, or "" for the default account
     *  "scriptPubKey"  - The script key
     *  "amount"        - The transaction amount
     *  "confirmations" - The number of confirmations
     * 
     * @param  int $minconf The minimum confirmations to filter
     * @param  int $maxconf The maximum confirmations to filter
     * @return array
     */
    public function listUnspent($minconf = 1, $maxconf = 999999)
    {
        $args = [
            (int)$minconf,
            (int)$maxconf
        ];
        return $this->server->query(__FUNCTION__, $args);
    }

    /**
     * Returns list of temporarily unspendable outputs
     *
     * Use the lockUnspent() method to lock and unlock transactions for spending.
     * 
     * @return array
     */
    public function listLockUnspent()
    {
        return $this->server->query(__FUNCTION__);
    }

    /**
     * Updates list of temporarily unspendable outputs
     *
     * Temporarily lock (true) or unlock (false) specified transaction outputs.
     * 
     * @param  mixed $unlock Whether to unlock (true) or lock (false) the specified transactions
     * @param  mixed $objs   An array of objects. Each object the txid (string) vout (numeric)
     * @return bool
     */
    public function lockUnspent($unlock, $objs = null)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Move from one account in your wallet to another
     *
     * @param  string $from_account Name of the from account
     * @param  string $to_account   Name of the to account
     * @param  double  $amount       The amount to transfer
     * @param  int    $minconf      Minimum confirmations in from account balance
     * @param  string $comment      Comment to record with this transaction
     * @return bool
     */
    public function move($from_account, $to_account, $amount, $minconf = 1, $comment = "")
    {
        $args = [
            (string)$from_account,
            (string)$to_account,
            (double)$amount,
            (int)$minconf,
            (string)$comment
        ];
        return $this->server->query(__FUNCTION__, $args);
    }

    /**
     * Will send the given amount to the given address
     *
     * Ensures the account has a valid balance using $minconf confirmations. Returns the transaction id if successful.
     *
     * @param  string $account    Name of the from account
     * @param  string $address    Address to send to
     * @param  double  $amount     The amount to send
     * @param  int    $minconf    Minimum confirmations in from account balance
     * @param  string $comment    Comment to record with this transaction
     * @param  string $comment_to Comment sent to the network with the transaction
     * @return string
     */
    public function sendFrom($account, $address, $amount, $minconf = 1, $comment = null, $comment_to = null)
    {
        $args = [
            (string)$account,
            (string)$address,
            (double)$amount,
            (int)$minconf,
            (string)$comment,
            (string)$comment_to
        ];
        return $this->server->query(__FUNCTION__, $args);
    }

    /**
     * Sends coins to the given address
     *
     * Returns the transaction id if successful.
     * 
     * @param  string $address    Address to send to
     * @param  double  $amount     The amount to send
     * @param  string $comment    Comment to record with this transaction
     * @param  string $comment_to Comment sent to the network with the transaction
     * @return string
     */
    public function sendToAddress($address, $amount, $comment = null, $comment_to = null)
    {
        $args = [
            (string)$address,
            (double)$amount,
            (string)$comment,
            (string)$comment_to
        ];
        return $this->server->query(__FUNCTION__, $args);
    }


    /**
     * Sends coins to multiple addresses
     *
     * Ensures the account has a valid balance using $minconf confirmations. Returns the transaction id if successful.
     * 
     * @param  string $from_account Name of the from account
     * @param  array  $addresses    ["address1" => "amount1", "address2" => "amount2"]
     * @param  int    $minconf      Minimum confirmations in from account balance
     * @param  string $comment      A comment on this transaction
     * @return array
     */
    public function sendMany($from_account, array $addresses, $minconf = 1, $comment = null)
    {
        $args = [
            (string)$from_account,
            $addresses,
            (int)$minconf,
            (string)$comment
        ];
        return $this->server->query(__FUNCTION__, $args);
    }

    /**
     * Submits raw transaction (serialized, hex-encoded) to local node and network.
     *
     * @param  string $hex_string The raw transaction
     * @return array
     */
    public function sendRawTransaction($hex_string)
    {
        $args = [
            (string)$hex_string
        ];
        return $this->server->query(__FUNCTION__, $args);
    }

    /**
     * Sets the account associated with the given address
     *
     * Assigning address that is already assigned to the same account will create a new address associated with
     * that account.
     *
     * @param  string $address A coin address from the wallet
     * @param  string $account Name of the account
     * @return bool
     */
    public function setAccount($address, $account)
    {
        $args = [
            (string)$address,
            (string)$account
        ];
        return null === $this->server->query(__FUNCTION__, $args);
    }

    /**
     * Sets whether the wallet should generate coins
     *
     * Generation is limited to $gen_proc_limit processors, -1 is unlimited.
     *
     * @param  bool $generate       Turn coin generation on (true) or off (false)
     * @param  int  $gen_proc_limit The processor limit, or -1 for unlimited
     * @return bool
     */
    public function setGenerate($generate, $gen_proc_limit = -1)
    {
        $args = [
            (bool)$generate,
            (int)$gen_proc_limit
        ];
        return null === $this->server->query(__FUNCTION__, $args);
    }

    /**
     * Sets the transaction fee amount
     *
     * @param  double $amount Amount to use for transaction fees
     * @return array
     */
    public function setTxFee($amount)
    {
        $args = [
            (double)$amount
        ];
        return $this->server->query(__FUNCTION__, $args);
    }

    /**
     * Sign a message with the private key of an address
     *
     * @param  string $address The coin address
     * @param  string $message The message to sign
     * @return string
     */
    public function signMessage($address, $message)
    {
        $args = [
            (string)$address,
            (string)$message
        ];
        return $this->server->query(__FUNCTION__, $args);
    }

    /**
     * Adds signatures to a raw transaction and returns the resulting raw transaction
     *
     * @param  string $hex_string
     * @param  string $transaction
     * @return array
     */
    public function signRawTransaction($hex_string, $transaction = "")
    {
        $args = [
            (string)$hex_string,
            (string)$transaction
        ];
        return $this->server->query(__FUNCTION__, $args);
    }

    /**
     * Stop bitcoin server
     *
     * @return array
     */
    public function stop()
    {
        return $this->server->query(__FUNCTION__);
    }

    /**
     * Attempts to submit new block to network
     *
     * @param  string $hex_data The serialized (hex) block data
     * @param  mixed  $params Optional parameters
     * @return array
     */
    public function submitBlock($hex_data, $params = null)
    {
        $args = [
            (string)$hex_data,
            $params
        ];
        return $this->server->query(__FUNCTION__, $args);
    }

    /**
     * Returns address information
     *
     * The returned array will contain one or more of the following keys:
     *  "isvalid"      - Whether the address is valid
     *  "address"      - The address
     *  "ismine"       - Whether the address belongs to the wallet
     *  "isscript"     - Is this a script address?
     *  "pubkey"       - The address public key
     *  "iscompressed" - Is the address compressed?
     *  "account"      - The account the address belongs to
     * 
     * The returned array will only contain ["isvalid" => false] when the address is not valid.
     * 
     * @param  string $address The coin address
     * @return array
     */
    public function validateAddress($address)
    {
        $args = [
            (string)$address
        ];
        return $this->server->query(__FUNCTION__, $args);
    }

    /**
     * Verify a signed message
     * 
     * Returns a boolean value indicating whether the message was successfully verified.
     *
     * @param  string $address   A coin address
     * @param  string $signature The signature
     * @param  string $message   The message
     * @return bool
     */
    public function verifyMessage($address, $signature, $message)
    {
        $args = [
            (string)$address,
            (string)$signature,
            (string)$message
        ];
        return $this->server->query(__FUNCTION__, $args);
    }

    /**
     * Removes the wallet encryption key from memory, locking the wallet.
     *
     * After calling this method, you will need to call walletPassPhrase() again before being able to call any methods
     * which require the wallet to be unlocked.
     *
     * @return array
     */
    public function walletLock()
    {
        return $this->server->query(__FUNCTION__);
    }

    /**
     * Stores the wallet decryption key in memory for $timeout seconds
     *
     * @param  string $passphrase The pass phrase
     * @param  int    $timeout    Number of seconds to keep the pass phrase in memory
     * @param  bool   $throws     True to throw an exception when the wallet is already unlocked, otherwise ignore that error
     * @return bool
     * @throws ServerException When $throws == true and the wallet is already unlocked
     */
    public function walletPassPhrase($passphrase, $timeout, $throws = false)
    {
        $args = [
            (string)$passphrase,
            (int)$timeout
        ];
        
        try {
            $this->server->query(__FUNCTION__, $args);
        } catch (ServerException $e) {
            if ($throws && strpos($e->getMessage(), "already unlocked") !== false) {
                throw $e;
            } else if (strpos($e->getMessage(), "already unlocked") === false) {
                throw $e;
            }
        }
        
        return true;
    }

    /**
     * Changes the wallet passphrase
     *
     * @param  string $old_passphrase The old pass phrase
     * @param  string $new_passphrase The new pass phrase
     * @return array
     */
    public function walletPassPhraseChange($old_passphrase, $new_passphrase)
    {
        $args = [
            (string)$old_passphrase,
            (string)$new_passphrase
        ];
        return null === $this->server->query(__FUNCTION__, $args);
    }
} 