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
 *  $api = new Api($server);
 *  $info = $api->getInfo();
 * </code>
 *
 * @see https://en.bitcoin.it/wiki/Original_Bitcoin_client/API_Calls_list
 */
class Api
{
    /**
     * Used to query the coin server
     * @var IServer
     */
    protected $server = null;

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
     * Add a nrequired-to-sign multisignature address to the wallet. Each key is a bitcoin address or hex-encoded
     * public key. If [account] is specified, assign address to [account].
     *
     * @param  string $nrequired
     * @param  array  $keys
     * @param  string $account
     * @return array
     */
    public function addMultiSigAddress($nrequired, array $keys, $account = null)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Attempts add or remove <node> from the addnode list or try a connection to <node> once.
     *
     * @version 0.8
     * @param  mixed  $node
     * @param  string $type One of "add", "remove", or "onetry"
     * @return array
     */
    public function addNode($node, $type = null)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Safely copies wallet.dat to destination, which can be a directory or a path with filename.
     *
     * @param  string $destination Directory or file path
     * @return array
     */
    public function backupWallet($destination)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Creates a multi-signature address and returns a json object
     *
     * @param  mixed $nrequired
     * @param  array $keys
     * @return array
     */
    public function createMultiSig($nrequired, array $keys)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Creates a raw transaction spending given inputs.
     *
     * @version 0.7
     * @param  string $transaction
     * @return array
     */
    public function createRawTransaction($transaction)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Produces a human-readable JSON object for a raw transaction.
     *
     * @version 0.7
     * @param  string $hex_string
     * @return array
     */
    public function decodeRawTransaction($hex_string)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Reveals the private key corresponding to <bitcoinaddress>
     *
     * @param  string $address
     * @return array
     */
    public function dumpPrivKey($address)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Encrypts the wallet with <passphrase>.
     *
     * @param  string $pass_phrase
     * @return array
     */
    public function encryptWallet($pass_phrase)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Returns the account associated with the given address.
     *
     * @param  string $address
     * @return array
     */
    public function getAccount($address)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Returns the current bitcoin address for receiving payments to this account.
     *
     * @param  string $account
     * @return array
     */
    public function getAccountAddress($account)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Returns information about the given added node, or all added nodes (note that onetry addnodes are not listed
     * here) If dns is false, only a list of added nodes will be provided, otherwise connected information will also
     * be available.
     *
     * @version 0.8
     * @param  string $dns
     * @param  mixed  $node
     * @return array
     */
    public function getAddedNodeInfo($dns, $node = null)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Returns the list of addresses for the given account.
     * 
     * @param  string $account Name of the account
     * @return array
     */
    public function getAddressByAccount($account)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * If [account] is not specified, returns the server's total available balance.
     * If [account] is specified, returns the balance in the account.
     *
     * @param  string $account
     * @param  int    $minconf
     * @return array
     */
    public function getBalance($account, $minconf = 1)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Returns the hash of the best (tip) block in the longest block chain.
     *
     * @version recent git checkouts only
     * @return array
     */
    public function getBestBlockHash()
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Returns information about the block with the given hash.
     *
     * @param  string $hash
     * @return array
     */
    public function getBlock($hash)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Returns the number of blocks in the longest block chain.
     *
     * @return array
     */
    public function getBlockCount()
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Returns hash of block in best-block-chain at <index>; index 0 is the genesis block
     *
     * @param  int $index
     * @return array
     */
    public function getBlockHash($index)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Returns data needed to construct a block to work on. See BIP_0022 for more info on params.
     *
     * @see https://en.bitcoin.it/wiki/BIP_0022
     *
     * @param  string $params
     * @return array
     */
    public function getBlockTemplate($params)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Returns the number of connections to other nodes.
     *
     * @return array
     */
    public function getConnectionCount()
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Returns the proof-of-work difficulty as a multiple of the minimum difficulty.
     *
     * @return array
     */
    public function getDifficulty()
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Returns true or false whether bitcoind is currently generating hashes
     *
     * @return array
     */
    public function getGenerate()
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Returns a recent hashes per second performance measurement while generating.
     *
     * @return array
     */
    public function getHashesPerSec()
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Returns an object containing various state info.
     *
     * @return array
     */
    public function getInfo()
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Returns an object containing mining-related information:
     *  blocks
     *  currentblocksize
     *  currentblocktxt
     *  difficulty
     *  errors
     *  generate
     *  genproclimit
     *  hashespersec
     *  pooledtxt
     *  testnet
     *
     * @return array
     */
    public function getMiningInfo()
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Returns a new bitcoin address for receiving payments. If [account] is specified (recommended), it is added to
     * the address book so payments received with the address will be credited to [account].
     *
     * @param  string $account
     * @return array
     */
    public function getNewAddress($account)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Returns data about each connected node.
     *
     * @version 0.7
     * @return array
     */
    public function getPeerInfo()
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Returns a new Bitcoin address, for receiving change. This is for use with raw transactions, NOT normal use.
     *
     * @version recent git checkouts only
     * @param  string $account
     * @return array
     */
    public function getRawChangeAddress($account)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Returns all transaction ids in memory pool
     *
     * @version 0.7
     * @return array
     */
    public function getRawMemPool()
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Returns raw transaction representation for given transaction id.
     *
     * @version 0.7
     * @param  string $txid
     * @param  int    $verbose
     * @return array
     */
    public function getRawTransaction($txid, $verbose = 0)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Returns the total amount received by addresses with [account] in transactions with at least [minconf]
     * confirmations. If [account] not provided return will include all transactions to all accounts.
     *
     * @param  string $account
     * @param  int    $minconf
     * @return array
     */
    public function getReceivedByAccount($account, $minconf = 1)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Returns the amount received by <bitcoinaddress> in transactions with at least [minconf] confirmations. It
     * correctly handles the case where someone has sent to the address in multiple transactions. Keep in mind that
     * addresses are only ever used for receiving transactions. Works only for addresses in the local wallet, external
     * addresses will always show 0.
     *
     * @param  string $address
     * @param  int    $minconf
     * @return array
     */
    public function getReceivedByAddress($address, $minconf = 1)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Returns an object about the given transaction
     *
     * @param  string $txid
     * @return array
     */
    public function getTransaction($txid)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Returns details about an unspent transaction output (UTXO)
     *
     * @param  string $txid
     * @param  int    $n
     * @param  bool   $include_mem_pool
     * @return array
     */
    public function getTxOut($txid, $n, $include_mem_pool = true)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Returns statistics about the unspent transaction output (UTXO) set
     *
     * @return array
     */
    public function getTxOutSetInfo()
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * If [data] is not specified, returns formatted hash data to work on
     *
     * @param  mixed $data
     * @return array
     */
    public function getWork($data)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Adds a private key (as returned by dumpprivkey) to your wallet. This may take a while, as a rescan is done,
     * looking for existing transactions. Optional [rescan] parameter added in 0.8.0.
     *
     * @param  mixed  $coin_priv_key
     * @param  string $label
     * @param  bool   $rescan
     * @return array
     */
    public function importPrivKey($coin_priv_key, $label, $rescan = true)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Fills the keypool, requires wallet passphrase to be set.
     *
     * @return array
     */
    public function keyPoolRefill()
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Returns Object that has account names as keys, account balances as values.
     *
     * @param  int $minconf
     * @return array
     */
    public function listAccounts($minconf = 1)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Returns all addresses in the wallet and info used for coincontrol.
     *
     * @version 0.7
     * @return array
     */
    public function listAddressGroupings()
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Returns an array of objects containing:
     *  account - the account of the receiving addresses
     *  amount - total amount received by addresses with this account
     *  confirmations - number of confirmations of the most recent transaction included
     *
     * @param  int  $minconf
     * @param  bool $include_empty
     * @return array
     */
    public function listReceivedByAccount($minconf = 1, $include_empty = false)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Returns an array of objects containing:
     *  address - receiving address
     *  account - the account of the receiving address
     *  amount - total amount received by the address
     *  confirmations - number of confirmations of the most recent transaction included
     *
     * To get a list of accounts on the system, execute bitcoind listreceivedbyaddress 0 true
     *
     * @param  int  $minconf
     * @param  bool $include_mem_pool
     * @return array
     */
    public function listReceivedByAddress($minconf = 1, $include_mem_pool = false)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Get all transactions in blocks since block [blockhash], or all transactions if omitted.
     *
     * @param  string $hash
     * @param  int    $target_confirmations
     * @return array
     */
    public function listSinceBlock($hash, $target_confirmations)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Returns up to [count] most recent transactions skipping the first [from] transactions for account [account].
     * If [account] not provided will return recent transaction from all accounts.
     *
     * @param  string $account
     * @param  int    $count
     * @param  int    $from
     * @return array
     */
    public function listTransactions($account, $count = 100, $from = 0)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Returns array of unspent transaction inputs in the wallet.
     *
     * @version 0.7
     * @param  int $minconf
     * @param  int $maxconf
     * @return array
     */
    public function listUnspent($minconf = 1, $maxconf = 999999)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Returns list of temporarily unspendable outputs
     *
     * @version 0.8
     * @return array
     */
    public function listLockUnspent()
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Updates list of temporarily unspendable outputs
     *
     * @version 0.8
     * @param  mixed $unlock
     * @param  mixed $objs
     * @return array
     */
    public function lockUnspent($unlock, $objs = null)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Move from one account in your wallet to another
     *
     * @param  string $from_account
     * @param  string $to_account
     * @param  float  $amount
     * @param  int    $minconf
     * @param  string $comment
     * @return array
     */
    public function move($from_account, $to_account, $amount, $minconf = 1, $comment = null)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * <amount> is a real and is rounded to 8 decimal places. Will send the given amount to the given address,
     * ensuring the account has a valid balance using [minconf] confirmations. Returns the transaction ID if successful
     * (not in JSON object).
     *
     * @param  string $from_account
     * @param  string $to_address
     * @param  float  $amount
     * @param  int    $minconf
     * @param  string $comment
     * @param  string $comment_to
     * @return array
     */
    public function sendFrom($from_account, $to_address, $amount, $minconf = 1, $comment = null, $comment_to = null)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * <amount> is a real and is rounded to 8 decimal places. Returns the transaction ID <txid> if successful.
     *
     * @param  string $address
     * @param  float  $amount
     * @param  string $comment
     * @param  string $comment_to
     * @return array
     */
    public function sendToAddress($address, $amount, $comment = null, $comment_to = null)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }


    /**
     * amounts are double-precision floating point numbers
     *
     * @param  string $from_account
     * @param  array  $addresses ["address1" => "amount1", "address2" => "amount2"]
     * @param  int    $minconf
     * @param  string $comment
     * @return array
     */
    public function sendMany($from_account, array $addresses, $minconf = 1, $comment = null)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Submits raw transaction (serialized, hex-encoded) to local node and network.
     *
     * @version 0.7
     * @param  string $hex_string
     * @return array
     */
    public function sendRawTransaction($hex_string)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Sets the account associated with the given address. Assigning address that is already assigned to the same
     * account will create a new address associated with that account.
     *
     * @param  string $address
     * @param  string $account
     * @return array
     */
    public function setAccount($address, $account)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * <generate> is true or false to turn generation on or off.
     * Generation is limited to [genproclimit] processors, -1 is unlimited.
     *
     * @param  bool $generate
     * @param  int  $gen_proc_limit
     * @return array
     */
    public function setGenerate($generate, $gen_proc_limit = -1)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * <amount> is a real and is rounded to the nearest 0.00000001
     *
     * @param  float $amount
     * @return array
     */
    public function setTxFee($amount)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Sign a message with the private key of an address.
     *
     * @param  string $address
     * @param  string $message
     * @return array
     */
    public function signMessage($address, $message)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Adds signatures to a raw transaction and returns the resulting raw transaction.
     *
     * @version 0.7
     * @param  string $hex_string
     * @param  string $transaction
     * @return array
     */
    public function signRawTransaction($hex_string, $transaction = null)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Stop bitcoin server.
     *
     * @return array
     */
    public function stop()
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Attempts to submit new block to network.
     *
     * @param  string $hex_data
     * @param  mixed  $params
     * @return array
     */
    public function submitBlock($hex_data, $params = null)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Return information about <bitcoinaddress>.
     *
     * @param  string $address
     * @return array
     */
    public function validateAddress($address)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Verify a signed message.
     *
     * @param  string $address
     * @param  string $signature
     * @param  string $message
     * @return array
     */
    public function verifyMessage($address, $signature, $message)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Removes the wallet encryption key from memory, locking the wallet. After calling this method, you will need to
     * call walletpassphrase again before being able to call any methods which require the wallet to be unlocked.
     *
     * @return array
     */
    public function walletLock()
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Stores the wallet decryption key in memory for <timeout> seconds.
     *
     * @param  string $passphrase
     * @param  int    $timeout
     * @return array
     */
    public function walletPassPhrase($passphrase, $timeout)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }

    /**
     * Changes the wallet passphrase from <oldpassphrase> to <newpassphrase>.
     *
     * @param  string $old_passphrase
     * @param  string $new_passphrase
     * @return array
     */
    public function walletPassPhraseChange($old_passphrase, $new_passphrase)
    {
        return $this->server->query(__FUNCTION__, func_get_args());
    }
} 