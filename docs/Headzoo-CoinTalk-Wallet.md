Headzoo\CoinTalk\Wallet
===============

JsonRPC wrapper class

Wraps a JsonRPCInterface instance, and provides concrete methods for each of the
methods provided by the server.

Example:
<code>
 $conf = [
     "user" => "test",
     "pass" => "pass",
     "host" => "localhost",
     "port" => 9332
 ];
 $rpc    = new JsonRPC($conf);
 $wallet = new Wallet($rpc);
 $info   = $wallet->getInfo();
</code>


* Class name: Wallet
* Namespace: Headzoo\CoinTalk





Properties
----------


### $rpc

```
protected \Headzoo\CoinTalk\JsonRPCInterface $rpc
```

Used to query the coin server



* Visibility: **protected**


### $minconf

```
protected int $minconf = 1
```

Only include transactions confirmed at least this many times



* Visibility: **protected**


Methods
-------


### \Headzoo\CoinTalk\Wallet::__construct()

```
mixed Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::__construct()(\Headzoo\CoinTalk\JsonRPCInterface $server, int $minconf)
```

Constructor



* Visibility: **public**

#### Arguments

* $server **[Headzoo\CoinTalk\JsonRPCInterface](Headzoo-CoinTalk-JsonRPCInterface.md)** - &lt;p&gt;Needed to communicate with the server&lt;/p&gt;
* $minconf **int** - &lt;p&gt;Only include transactions confirmed at least this many times&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::getJsonRPC()

```
\Headzoo\CoinTalk\JsonRPCInterface Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::getJsonRPC()()
```

Returns the JsonRPCInterface instance being wrapped



* Visibility: **public**



### \Headzoo\CoinTalk\Wallet::getMinConf()

```
int Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::getMinConf()()
```

Returns the minimum number of confirmations needed when checking balances



* Visibility: **public**



### \Headzoo\CoinTalk\Wallet::setMinConf()

```
\Headzoo\CoinTalk\Wallet Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::setMinConf()(int $minconf)
```

Sets the minimum number of confirmations needed when checking balances



* Visibility: **public**

#### Arguments

* $minconf **int** - &lt;p&gt;Only include transactions confirmed at least this many times&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::getInfo()

```
array Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::getInfo()()
```

Returns an array containing various state info

The returned array contains the following keys:
 "version"           - (int)     The server version.
 "protocolversion"   - (int)     The protocol version.
 "walletversion"     - (int)     The wallet version.
 "balance"           - (double)  The total bitcoin balance of the wallet.
 "blocks"            - (int)     The current number of blocks processed in the server.
 "timeoffset"        - (int)     The time offset.
 "connections"       - (int)     The number of connections.
 "proxy"             - (string)  The proxy used by the server.
 "difficulty"        - (double)  The current difficulty.
 "testnet"           - (boolean) If the server is using testnet or not.
 "keypoololdest"     - (int)     The timestamp (seconds since GMT epoch) of the oldest pre-generated key in the key pool.
 "keypoolsize"       - (int)     How many new keys are pre-generated.
 "unlocked_until"    - (int)     The timestamp in seconds since epoch (midnight Jan 1 1970 GMT) that the wallet is unlocked for transfers, or 0 if the wallet is locked.
 "paytxfee"          - (double)  The transaction fee set in btc/kb.
 "errors"            - (string)  Any error messages.

* Visibility: **public**



### \Headzoo\CoinTalk\Wallet::getConnectionCount()

```
int Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::getConnectionCount()()
```

Returns the number of connections to other nodes



* Visibility: **public**



### \Headzoo\CoinTalk\Wallet::getDifficulty()

```
double Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::getDifficulty()()
```

Returns the proof-of-work difficulty as a multiple of the minimum difficulty



* Visibility: **public**



### \Headzoo\CoinTalk\Wallet::getGenerate()

```
bool Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::getGenerate()()
```

Returns true or false whether the wallet is currently generating hashes



* Visibility: **public**



### \Headzoo\CoinTalk\Wallet::getHashesPerSec()

```
int Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::getHashesPerSec()()
```

Returns a recent hashes per second performance measurement while generating

See the getGenerate() and setGenerate() calls to turn generation on and off.

* Visibility: **public**



### \Headzoo\CoinTalk\Wallet::getMiningInfo()

```
array Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::getMiningInfo()()
```

Returns an array of mining related information

The returned array contains the following keys:
 "blocks"            - (int)     The current block.
 "currentblocksize"  - (int)     The last block size.
 "currentblocktxt"   - (int)     The last block transaction.
 "difficulty"        - (double)  The current difficulty.
 "errors"            - (string)  Current errors.
 "generate"          - (boolean) If the generation is on or off.
 "genproclimit"      - (int)     The processor limit for generation. -1 if no generation.
 "hashespersec"      - (int)     The hashes per second of the generation, or 0 if no generation.
 "networkhashps"     - (double)  The estimated network hashes per second based on the last n blocks.
 "pooledtxt"         - (int)     The size of the mem pool.
 "testnet"           - (boolean) If using testnet or not.

* Visibility: **public**



### \Headzoo\CoinTalk\Wallet::getPeerInfo()

```
array Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::getPeerInfo()()
```

Returns an array describing each connected node

Returns an mutlidimentional array, which each sub-array containing the following keys:
 "addr"              - (string)  The ip address and port of the peer.
 "addrlocal"         - (string)  The local address.
 "services"          - (string)  The supported services.
 "lastsend"          - (int)     The time in seconds since epoch (Jan 1 1970 GMT) of the last send.
 "lastrecv"          - (int)     The time in seconds since epoch (Jan 1 1970 GMT) of the last receive.
 "bytessent"         - (int)     The total bytes sent.
 "bytesrecv"         - (int)     The total bytes received.
 "conntime"          - (int)     The connection time in seconds since epoch (Jan 1 1970 GMT).
 "pingtime"          - (double)  The ping time.
 "version"           - (int)     The peer version, such as 7001.
 "subver"            - (string)  The string version, such as "Satoshi:0.8.5".
 "inbound"           - (boolean) Inbound (true) or Outbound (false).
 "startingheight"    - (int)     The starting height (block) of the peer.
 "banscore"          - (int)     The ban score (stats.nMisbehavior).
 "syncnode"          - (boolean) True if sync node.

* Visibility: **public**



### \Headzoo\CoinTalk\Wallet::getBestBlockHash()

```
string Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::getBestBlockHash()()
```

Returns the hash of the best (tip) block in the longest block chain



* Visibility: **public**



### \Headzoo\CoinTalk\Wallet::getBlockCount()

```
int Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::getBlockCount()()
```

Returns the number of blocks in the longest block chain



* Visibility: **public**



### \Headzoo\CoinTalk\Wallet::setTransactionFee()

```
bool Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::setTransactionFee()(double $amount)
```

Sets the transaction fee amount



* Visibility: **public**

#### Arguments

* $amount **double** - &lt;p&gt;Amount to use for transaction fees&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::setGenerate()

```
bool Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::setGenerate()(bool $generate, int $gen_proc_limit)
```

Sets whether the wallet should generate coins

Generation is limited to $gen_proc_limit processors, -1 is unlimited.

* Visibility: **public**

#### Arguments

* $generate **bool** - &lt;p&gt;Turn coin generation on (true) or off (false)&lt;/p&gt;
* $gen_proc_limit **int** - &lt;p&gt;The processor limit, or -1 for unlimited&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::addNode()

```
bool Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::addNode()(string $node, string $type)
```

Attempts add or remove a node from the addnode list or try a connection to it once



* Visibility: **public**

#### Arguments

* $node **string** - &lt;p&gt;The node ip address and port in &lt;ip&gt;:&lt;port&gt; format (see getPeerInfo() for nodes)&lt;/p&gt;
* $type **string** - &lt;p&gt;Use &quot;add&quot; to add a node to the list, &quot;remove&quot; to remove a node from the list, &quot;onetry&quot; to try a connection to the node once&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::getNodeInfo()

```
array Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::getNodeInfo()(bool $dns, string $node)
```

Returns information about the given added node, or all added nodes

If dns is false, only a list of added nodes will be provided, otherwise connected information will also
be available.

Note: Nodes added using the addnode configuration and "onetry" nodes are not returned.

When $dns is false, returns multidimensional array, with sub-arrays containing the keys:
 "addednode"     - (string) The node ip address and port in format <ip>:<port>.

When $dns is true, returns a mutlidimentional array, with the sub-arrays containing the keys:
 "addednode"     - (string)  The node ip address and port in format <ip>:<port>.
 "connected"     - (boolean) If connected.
 "addresses"     - (array)   Array of node peers. Each sub-array contains the keys:
     "address"   - (string)  The node ip address and port in format <ip>:<port>.
     "connected" - (bool)    If connected.

* Visibility: **public**

#### Arguments

* $dns **bool** - &lt;p&gt;If false, only a list of added nodes will be provided, otherwise connected information will also be available&lt;/p&gt;
* $node **string** - &lt;p&gt;If provided, return information about this specific node, otherwise all nodes are returned&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::signMessage()

```
string Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::signMessage()(string $address, string $message)
```

Sign a message with the private key of an address



* Visibility: **public**

#### Arguments

* $address **string** - &lt;p&gt;The coin address&lt;/p&gt;
* $message **string** - &lt;p&gt;The message to sign&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::signRawTransaction()

```
array Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::signRawTransaction()(string $hex_data, array $prevtxs, array $priv_keys, string $sighashtype)
```

Adds signatures to a raw transaction and returns the resulting raw transaction

If provided, the $prev_txs argument should be a multidimensional array, with the sub-arrays having the
following keys:
 "txid"          - (string)  The transaction id.
 "vout"          - (int)     The output number.
 "scriptPubKey"  - (string)  The script key.
 "redeemScript"  - (string)  The redeem script.

Example return value:
 [
     // The raw transaction with signature(s) (hex-encoded string).
     "hex" => "010000000263f2dde1d550b081d59c09ccb3f8a83b01...",

     // If transaction has a complete set of signature (0 if not).
     "complete" => 1
 ]

* Visibility: **public**

#### Arguments

* $hex_data **string** - &lt;p&gt;The transaction hex string&lt;/p&gt;
* $prevtxs **array** - &lt;p&gt;An array of previous dependent transaction outputs&lt;/p&gt;
* $priv_keys **array** - &lt;p&gt;Array of base58-encoded private keys for signing&lt;/p&gt;
* $sighashtype **string** - &lt;p&gt;The signature hash type, one of &quot;ALL&quot;, &quot;NONE&quot;, &quot;SINGLE&quot;, &quot;ALL|ANYONECANPAY&quot;, &quot;NONE|ANYONECANPAY&quot;, &quot;SINGLE|ANYONECANPAY&quot;&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::isSignedMessageValid()

```
bool Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::isSignedMessageValid()(string $address, string $signature, string $message)
```

Verify a signed message

Returns a boolean value indicating whether the message was successfully verified.

* Visibility: **public**

#### Arguments

* $address **string** - &lt;p&gt;A coin address&lt;/p&gt;
* $signature **string** - &lt;p&gt;The signature&lt;/p&gt;
* $message **string** - &lt;p&gt;The message&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::getBalance()

```
double Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::getBalance()()
```

Returns the balance for the entire wallet



* Visibility: **public**



### \Headzoo\CoinTalk\Wallet::getBalances()

```
array Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::getBalances()(bool $include_empty)
```

Returns balances by for every address

Returns an mutlidimentional array, which each sub-array containing the following keys:
 "address"       - (string)  The receiving address.
 "account"       - (string)  The account of the receiving address, using "" to represent the default account.
 "amount"        - (double)  The total amount received by the address.
 "confirmations" - (int)     The number of confirmations of the most recent transaction included.
 "txids"         - (array)   An array of transaction ids.

To get a list of accounts on the system, call getReceivedByAddress(0, true).

* Visibility: **public**

#### Arguments

* $include_empty **bool** - &lt;p&gt;Whether to include addresses that haven&#039;t received any payments&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::getBalanceByAccount()

```
double Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::getBalanceByAccount()(string $account)
```

Returns the balance for the given account



* Visibility: **public**

#### Arguments

* $account **string** - &lt;p&gt;The account name, using &quot;&quot; for the default account&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::getBalanceByAddress()

```
double Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::getBalanceByAddress()(string $address)
```

Returns the balance for a given address



* Visibility: **public**

#### Arguments

* $address **string** - &lt;p&gt;The address&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::move()

```
bool Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::move()(string $from_account, string $to_account, double $amount, string $comment)
```

Move from one account in your wallet to another



* Visibility: **public**

#### Arguments

* $from_account **string** - &lt;p&gt;Name of the from account&lt;/p&gt;
* $to_account **string** - &lt;p&gt;Name of the to account&lt;/p&gt;
* $amount **double** - &lt;p&gt;The amount to transfer&lt;/p&gt;
* $comment **string** - &lt;p&gt;Comment to record with this transaction&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::send()

```
string Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::send()(string $address, double $amount, string $comment, string $comment_to)
```

Sends coins to the given address

Returns the transaction id if successful.

* Visibility: **public**

#### Arguments

* $address **string** - &lt;p&gt;Address to send to&lt;/p&gt;
* $amount **double** - &lt;p&gt;The amount to send&lt;/p&gt;
* $comment **string** - &lt;p&gt;Comment to record with this transaction&lt;/p&gt;
* $comment_to **string** - &lt;p&gt;Comment sent to the network with the transaction&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::sendFromAccount()

```
string Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::sendFromAccount()(string $account, string $address, double $amount, string $comment, string $comment_to)
```

Sends coins from the given account to the given address



* Visibility: **public**

#### Arguments

* $account **string** - &lt;p&gt;Name of the from account&lt;/p&gt;
* $address **string** - &lt;p&gt;Address to send to&lt;/p&gt;
* $amount **double** - &lt;p&gt;The amount to send&lt;/p&gt;
* $comment **string** - &lt;p&gt;Comment to record with this transaction&lt;/p&gt;
* $comment_to **string** - &lt;p&gt;Comment sent to the network with the transaction&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::sendManyFromAccount()

```
array Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::sendManyFromAccount()(string $account, array $addresses, string $comment)
```

Sends coins to multiple addresses



* Visibility: **public**

#### Arguments

* $account **string** - &lt;p&gt;Name of the from account&lt;/p&gt;
* $addresses **array** - &lt;p&gt;[&quot;address1&quot; =&gt; &quot;amount1&quot;, &quot;address2&quot; =&gt; &quot;amount2&quot;]&lt;/p&gt;
* $comment **string** - &lt;p&gt;A comment on this transaction&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::getAccounts()

```
array Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::getAccounts()()
```

Returns the wallet accounts

Example return value:
 [
     "",
     "Paper1",
     "Mining"
 ]

* Visibility: **public**



### \Headzoo\CoinTalk\Wallet::setAccount()

```
bool Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::setAccount()(string $address, string $account)
```

Sets the account associated with the given address

Assigning address that is already assigned to the same account will create a new address associated with
that account.

* Visibility: **public**

#### Arguments

* $address **string** - &lt;p&gt;A coin address from the wallet&lt;/p&gt;
* $account **string** - &lt;p&gt;Name of the account&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::getAccountByAddress()

```
string|null Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::getAccountByAddress()(string $address)
```

Returns the account associated with the given address

Returns null when an account does not exist for the given address.

* Visibility: **public**

#### Arguments

* $address **string** - &lt;p&gt;The address for account lookup&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::getAddresses()

```
array Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::getAddresses()()
```

Returns the wallet addresses

Example return value:
 [
     "1Headz2mYtpBRo6KFaaUEtcm5Kce6BZRJM",
     "1JBKAM8W9jEnuGNvPRFjtpmeDGvfQx6PLU",
     "19tjsa4nBeAtn48kcmW9Gg2wRFtm24GRG2"
 ]

* Visibility: **public**



### \Headzoo\CoinTalk\Wallet::getAddressByAccount()

```
string Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::getAddressByAccount()(string $account)
```

Returns the current address for receiving payments to this account

The account does not need to exist, it will be created and a new address created if there is no account by
the given name.

* Visibility: **public**

#### Arguments

* $account **string** - &lt;p&gt;The account name for the address, using &quot;&quot; to represent the default account&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::getAddressesByAccount()

```
array Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::getAddressesByAccount()(string $account)
```

Returns the addresses for the given account



* Visibility: **public**

#### Arguments

* $account **string** - &lt;p&gt;The account name, using &quot;&quot; to represent the default account&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::getRawChangeAddress()

```
string Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::getRawChangeAddress()(string $account)
```

Returns a new address for receiving change

This is for use with raw transactions, NOT normal use.

* Visibility: **public**

#### Arguments

* $account **string** - &lt;p&gt;Name of the account, using &quot;&quot; to represent the default account&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::getNewAddress()

```
string Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::getNewAddress()(string $account)
```

Returns a new address for receiving payments

If $account is specified (recommended), it is added to the address book so payments received with the address
will be credited to $account.

* Visibility: **public**

#### Arguments

* $account **string** - &lt;p&gt;The account name for the address to be linked to, using &quot;&quot; to represent the default account&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::getAddressInfo()

```
array Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::getAddressInfo()(string $address)
```

Returns address information

The returned array will contain one or more of the following keys:
 "isvalid"      - (bool)     Whether the address is valid.
 "address"      - (string)   The address.
 "ismine"       - (bool)     Whether the address belongs to the wallet.
 "isscript"     - (bool)     Is this a script address?
 "pubkey"       - (string)   The address public key.
 "iscompressed" - (bool)     Is the address compressed?
 "account"      - (string)   The account the address belongs to.

The returned array will only contain ["isvalid" => false] when the address is not valid.

* Visibility: **public**

#### Arguments

* $address **string** - &lt;p&gt;The coin address&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::getNewMultiSignatureAddress()

```
array Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::getNewMultiSignatureAddress()(int $nrequired, array $keys)
```

Returns a new multi-signature address

Returns an array with the following keys:
 "address"       - (string) The multi-signature address
 "redeemScript"  - (string) The redeem script

* Visibility: **public**

#### Arguments

* $nrequired **int** - &lt;p&gt;Number of keys needed to redeem&lt;/p&gt;
* $keys **array** - &lt;p&gt;Array of public keys&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::addMultiSignatureAddress()

```
string Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::addMultiSignatureAddress()(int $nrequired, array $keys, string $account)
```

Add a nrequired-to-sign multisignature address to the wallet

Each key is a address or hex-encoded public key. If $account is specified, assign address to $account.

Returns the the multi-signature address.

* Visibility: **public**

#### Arguments

* $nrequired **int** - &lt;p&gt;Number of keys needed to redeem&lt;/p&gt;
* $keys **array** - &lt;p&gt;Array of public keys&lt;/p&gt;
* $account **string** - &lt;p&gt;Name of account which receives the address&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::getPrivateKeyByAddress()

```
string Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::getPrivateKeyByAddress()(string $address)
```

Returns the private key for the given address

Returns null when the address does not belong to any wallet account.

* Visibility: **public**

#### Arguments

* $address **string** - &lt;p&gt;The address for the private key&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::addPrivateKey()

```
bool Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::addPrivateKey()(string $priv_key, string $label, bool $rescan)
```

Adds a private key to the wallet

Rescanning may take a while looking for existing transactions, and may even freeze up the wallet.

* Visibility: **public**

#### Arguments

* $priv_key **string** - &lt;p&gt;The private key&lt;/p&gt;
* $label **string** - &lt;p&gt;An optional label&lt;/p&gt;
* $rescan **bool** - &lt;p&gt;Whether to rescan the wallet for transactions&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::getBlock()

```
array|string Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::getBlock()(string $hash, bool $verbose)
```

Returns information about the block with the given hash

When $verbose is set to false, this method returns the serialized and hex-encoded block data.

When $verbose is set to true, the return value will be an array with the following keys:
 "hash"              - (string)  The block hash (same as provided).
 "confirmations"     - (int)     The number of confirmations.
 "size"              - (int)     The block size.
 "height"            - (int)     The block height or index.
 "version"           - (int)     The block version.
 "merkleroot"        - (string)  The merkle root.
 "tx"                - (array)   The transaction ids.
 "time"              - (int)     The block time in seconds since epoch (Jan 1 1970 GMT).
 "nonce"             - (double)  The nonce.
 "bits"              - (string)  The bits.
 "difficulty"        - (double)  The difficulty.
 "previousblockhash" - (string)  The hash of the previous block.
 "nextblockhash"     - (string)  The hash of the next block.

* Visibility: **public**

#### Arguments

* $hash **string** - &lt;p&gt;The block hash&lt;/p&gt;
* $verbose **bool** - &lt;p&gt;True for an array, false for the hex encoded data&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::getBlockHash()

```
string Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::getBlockHash()(int $index)
```

Returns hash of block in best-block-chain at $index

Index 0 is the genesis block.

* Visibility: **public**

#### Arguments

* $index **int** - &lt;p&gt;The block index&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::getSinceBlock()

```
array Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::getSinceBlock()(string $hash, int $target_confirmations)
```

Get all transactions in blocks since block $hash

Returns all transactions if $hash is omitted.

The return value will be an mutlidimentional array with the following keys:
 "lastblock"             - (string)  The hash of the last block.
 "transactions"          - (array)   One or more transactions. Each transaction will contain the following keys:
     "account"           - (string)  The account name associated with the transaction, using "" to represent the default account.
     "address"           - (string)  The address of the transaction. Not present for move transactions (category = move).
     "category"          - (string)  The type of transaction, eg "send", "receive", or "move".
     "amount"            - (double)  The transaction amount. This is negative for the "send" category, and for the 'move' category for moves outbound, otherwise it's positive.
     "fee"               - (double)  The transaction fee. This is negative and only available for the 'send' category of transactions.
     "confirmations"     - (int)     The number of confirmations for the transaction. Available for 'send' and 'receive' category of transactions.
     "blockhash"         - (string)  The block hash containing the transaction. Available for 'send' and 'receive' category of transactions.
     "blockindex"        - (int)     The block index containing the transaction. Available for 'send' and 'receive' category of transactions.
     "blocktime"         - (int)     The block time in seconds since epoch (1 Jan 1970 GMT).
     "txid"              - (string)  The transaction id.
     "time"              - (int)     The transaction time in seconds since epoch (Jan 1 1970 GMT).
     "timereceived"      - (int)     The time received in seconds since epoch (Jan 1 1970 GMT). Available for 'send' and 'receive' category of transactions.
     "comment"           - (string)  If a comment is associated with the transaction.
     "to"                - (string)  If a comment to is associated with the transaction.

* Visibility: **public**

#### Arguments

* $hash **string** - &lt;p&gt;The block hash to list transactions since&lt;/p&gt;
* $target_confirmations **int** - &lt;p&gt;The confirmations required, must be 1 or more&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::getTransaction()

```
array Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::getTransaction()(string $txid)
```

Returns detailed information about in-wallet transaction

This method cannot be used to get information about non-wallet transactions. Use getRawTransaction() for
non-wallet transactions.

The returned array will contain the following keys:
 "amount"        - (double)  The transaction amount.
 "fee"           - (double)  The transaction fee.
 "confirmations" - (int)     The number of confirmations.
 "blockhash"     - (string)  The block hash.
 "blockindex"    - (int)     The block index.
 "blocktime"     - (int)     The time in seconds since epoch (1 Jan 1970 GMT).
 "txid"          - (string)  The transaction id.
 "time"          - (int)     The transaction time in seconds since epoch (1 Jan 1970 GMT).
 "timereceived"  - (int)     The time received in seconds since epoch (1 Jan 1970 GMT).
 "details"       - (array)   The transaction details. Each array contains the following keys:
     "account"   - (string)  The account name involved in the transaction, using "" to represent the default account.
     "address"   - (string)  The address involved in the transaction.
     "category"  - (string)  The category, either "send" or "receive".
     "amount"    - (double)  The amount.
     "fee"       - (double)  The transaction fee.

* Visibility: **public**

#### Arguments

* $txid **string** - &lt;p&gt;The transaction id&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::getTransactions()

```
array Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::getTransactions()(string $account, int $count, int $from)
```

Returns up to $count most recent transactions

The first $from transactions are skipped. If $account not provided will return recent transaction from all
accounts.

The return value will be an mutlidimentional array, with each sub-array containing the following keys:
 "account"           - (string)  The account name associated with the transaction, using "" to represent the default account.
 "address"           - (string)  The address of the transaction. Not present for move transactions (category = move).
 "category"          - (string)  The type of transaction, eg "send", "receive", or "move".
 "amount"            - (double)  The transaction amount. This is negative for the "send" category, and for the 'move' category for moves outbound, otherwise it's positive.
 "fee"               - (double)  The transaction fee. This is negative and only available for the 'send' category of transactions.
 "confirmations"     - (int)     The number of confirmations for the transaction. Available for 'send' and 'receive' category of transactions.
 "blockhash"         - (string)  The block hash containing the transaction. Available for 'send' and 'receive' category of transactions.
 "blockindex"        - (int)     The block index containing the transaction. Available for 'send' and 'receive' category of transactions.
 "blocktime"         - (int)     The block time in seconds since epoch (1 Jan 1970 GMT).
 "txid"              - (string)  The transaction id.
 "time"              - (int)     The transaction time in seconds since epoch (Jan 1 1970 GMT).
 "timereceived"      - (int)     The time received in seconds since epoch (Jan 1 1970 GMT). Available for 'send' and 'receive' category of transactions.
 "comment"           - (string)  If a comment is associated with the transaction.

* Visibility: **public**

#### Arguments

* $account **string** - &lt;p&gt;The name of the account&lt;/p&gt;
* $count **int** - &lt;p&gt;Number of transactions to return&lt;/p&gt;
* $from **int** - &lt;p&gt;Offset from the last transaction&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::getTransactionsFromMemoryPool()

```
array Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::getTransactionsFromMemoryPool()()
```

Returns an array of transaction ids in memory pool



* Visibility: **public**



### \Headzoo\CoinTalk\Wallet::getRawTransaction()

```
array Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::getRawTransaction()(string $txid, int $verbose)
```

Returns raw transaction representation for given transaction id

Returns the raw transaction data as a string when $verbose is 0. Use decodeRawTransaction() to convert the
transaction data into an array.

Returns an array with the following keys when $verbose is 1.
 "hex"               - (string)  The serialized, hex-encoded data.
 "txid"              - (string)  The transaction id.
 "version"           - (int)     The version.
 "locktime"          - (int)     The lock time.
 "vin"               - (array)   An array with the following keys:
     "txid"          - (string)  The transaction id.
     "vout"          - (int)     The vout index.
     "scriptSig"     - (array)   The script, an array with keys:
         "asm"       - (string)  Script in asm format.
         "hex"       - (string)  Script in hex format.
     "sequence"      - (int)     The script sequence number.
 "vout"              - (array)   An array with the following keys:
     "value"         - (double)  The amount sent.
     "n"             - (int)     The index.
     "scriptPubKey"  - (array)   An array with the following keys:
         "asm"       - (string)  The script in asm format.
         "hex"       - (string)  The script in hex format.
         "reqSigs"   - (int)     The number of required sigs.
         "type"      - (string)  The type, eg 'pubkeyhash'.
         "addresses" - (array)   An array of addresses.
 "blockhash"         - (string)  The block hash.
 "confirmations"     - (int)     The number of confirmations.
 "time"              - (int)     The transaction time in seconds since epoch (Jan 1 1970 GMT).
 "blocktime"         - (int)     The block time in seconds since epoch (Jan 1 1970 GMT).

* Visibility: **public**

#### Arguments

* $txid **string** - &lt;p&gt;The transaction id&lt;/p&gt;
* $verbose **int** - &lt;p&gt;If 0, return a string, other return a json object&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::getTransactionOut()

```
array Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::getTransactionOut()(string $txid, int $n, bool $include_mem_pool)
```

Returns details about an unspent transaction output

Returns an array with the following keys:
 "bestblock"         - (string)  The block hash.
 "confirmations"     - (int)     The number of confirmations.
 "value"             - (double)  The transaction value.
 "scriptPubKey"      - (array)   The script, an array with the following keys:
     "asm"           - (string)  The code in asm format.
     "hex"           - (string)  The code in hex format.
     "regSigs"       - (int)     Number of required signatures.
     "type"          - (string)  The type, eg "pubkeyhash".
     "addresses"     - (array)   An array of addresses.
 "version"           - (int)     The version.
 "coinbase"          - (bool)    Coinbase transaction or not.

* Visibility: **public**

#### Arguments

* $txid **string** - &lt;p&gt;The transaction id&lt;/p&gt;
* $n **int** - &lt;p&gt;The vout value&lt;/p&gt;
* $include_mem_pool **bool** - &lt;p&gt;Whether to included the mem pool&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::getTransactionOutSet()

```
array Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::getTransactionOutSet()()
```

Returns statistics about the unspent transaction output set

Note this call may take some time.

Returns an array with the following keys:
 "height"            - (int)     The current block height.
 "bestblock"         - (string)  The best block hash hex.
 "transactions"      - (int)     The number of transactions.
 "txouts"            - (int)     The number of output transactions.
 "bytes_serialized"  - (int)     The serialized size.
 "hash_serialized"   - (string)  The serialized hash.
 "total_amount"      - (double)  The total amount.

* Visibility: **public**



### \Headzoo\CoinTalk\Wallet::getUnspent()

```
array Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::getUnspent()(int $minconf, int $maxconf)
```

Returns array of unspent transaction inputs in the wallet between $minconf and $maxconf

The returned array will contain the following keys:
 "txid"          - (string)  The transaction id.
 "vout"          - (int)     The vout value.
 "address"       - (string)  The address.
 "account"       - (string)  The associated account, using "" to represent the default account.
 "scriptPubKey"  - (string)  The script key.
 "amount"        - (double)  The transaction amount.
 "confirmations" - (int)     The number of confirmations.

* Visibility: **public**

#### Arguments

* $minconf **int** - &lt;p&gt;The minimum confirmations to filter&lt;/p&gt;
* $maxconf **int** - &lt;p&gt;The maximum confirmations to filter&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::getLockUnspent()

```
array Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::getLockUnspent()()
```

Returns list of temporarily unspendable outputs

Use the setLockUnspent() method to lock and unlock transactions for spending.

* Visibility: **public**



### \Headzoo\CoinTalk\Wallet::setLockUnspent()

```
bool Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::setLockUnspent()(bool $unlock, array $objs)
```

Updates list of temporarily unspendable outputs

Temporarily lock (true) or unlock (false) specified transaction outputs.

* Visibility: **public**

#### Arguments

* $unlock **bool** - &lt;p&gt;Whether to unlock (true) or lock (false) the specified transactions&lt;/p&gt;
* $objs **array** - &lt;p&gt;An array of objects. Each object has &quot;txid&quot; (string) and &quot;vout&quot; (numeric)&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::getBlockTemplate()

```
array Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::getBlockTemplate()(array $capabilities, string|null $mode)
```

Returns data needed to construct a block to work on

If the $mode argument is set, that is used to explicitly select between the default "template"
request or a "proposal".

The returned array contains the following keys:
 "version"               - (int)     The block version.
 "previousblockhash"     - (string)  The hash of current highest block.
 "transactions"          - (array)   Array of non-coinbase transactions which should be included in the block. Each contains the following keys:
     "data"              - (string)  Transaction data encoded in hexadecimal (byte-for-byte).
     "hash"              - (string)  Hash/id encoded in little-endian hexadecimal.
     "depends"           - (array)   Array of numbers.
     "fee"               - (int)     Difference in value between transaction inputs and outputs (in Satoshis); for coinbase transactions, this is a negative Number of the total collected block fees (ie, not including the block subsidy); if key is not present, fee is unknown and clients MUST NOT assume there isn't one.
     "sigops"            - (int)     Total number of SigOps, as counted for purposes of block limits; if key is not present, sigop count is unknown and clients MUST NOT assume there aren't any.
     "required"          - (boolean) If provided and true, this transaction must be in the final block.
 "coinbaseaux"           - (array)   Array of data that should be included in the coinbase's scriptSig content. Contains the following key:
     "flags"             - (string)  The data to include.
 "coinbasevalue"         - (double)  Maximum allowable input to coinbase transaction, including the generation award and transaction fees (in Satoshis).
 "coinbasetxn"           - (array)   Information for coinbase transaction.
 "target"                - (string)  The hash target.
 "mintime"               - (int)     The minimum timestamp appropriate for next block time in seconds since epoch (Jan 1 1970 GMT).
 "mutable"               - (array)   List of ways the block template may be changed. Contains the following keys:
     "value"             - (string)  A way the block template may be changed, e.g. 'time', 'transactions', 'prevblock'.
 "noncerange"            - (string)  A range of valid nonces.
 "sigoplimit"            - (int)     Limit of sigops in blocks.
 "sizelimit"             - (int)     Limit of block size.
 "curtime"               - (int)     Current timestamp in seconds since epoch (Jan 1 1970 GMT).
 "bits"                  - (string)  Compressed target of next block.
 "height"                - (int)     The height of the next block.

* Visibility: **public**

#### Arguments

* $capabilities **array** - &lt;p&gt;An array of supported features, &quot;longpoll&quot;, &quot;coinbasetxn&quot;, &quot;coinbasevalue&quot;, &quot;proposal&quot;, &quot;serverlist&quot;, &quot;workid&quot;&lt;/p&gt;
* $mode **string|null** - &lt;p&gt;This must be set to &quot;template&quot; or omitted&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::getWork()

```
array|bool Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::getWork()(string $data)
```

Returns work data, or works on existing data

Returns formatted hash data to work on if $data is not specified. Tries to solve the block if $data is provided,
and returns a boolean value indicating success or failure.

When $data is not specified, the return value will be an array with the following keys:
 "midstate"  - (string) The precomputed hash state after hashing the first half of the data (DEPRECATED).
 "data"      - (string) The serialized block data.
 "hash1"     - (string) The formatted hash buffer for second hash (DEPRECATED).
 "target"    - (string) The little endian hash target.

* Visibility: **public**

#### Arguments

* $data **string** - &lt;p&gt;The hex-encoded data to solve&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::submitRawBlock()

```
array Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::submitRawBlock()(string $hex_data, array $params)
```

Submits a raw (serialized, hex-encoded) block to the network

The $params argument is currently ignored, but may contain the following keys:
 "workid"    - (string) If the server provided a work id, it MUST be included with the submission.

* Visibility: **public**

#### Arguments

* $hex_data **string** - &lt;p&gt;The hex string of the raw block&lt;/p&gt;
* $params **array** - &lt;p&gt;Optional parameters&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::submitRawTransaction()

```
array Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::submitRawTransaction()(string $hex_data)
```

Submits a raw (serialized, hex-encoded) transaction to the network



* Visibility: **public**

#### Arguments

* $hex_data **string** - &lt;p&gt;The hex string of the raw transaction&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::createRawTransaction()

```
array Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::createRawTransaction()(array $transactions, array $addresses)
```

Returns a hex-encoded raw transaction spending the given inputs and sending to the given addresses

The $transactions argument is a multidimensional array, which each value being an array with the following keys:
 "txid"  - (string) The transaction id.
 "vout"  - (int)    The output number.

The $addresses argument is an associative array using addresses for keys, and amounts to send to the address
as values. For example:
 [
     "1Headz2mYtpBRo6KFaaUEtcm5Kce6BZRJM" => 0.5,
     "1FVCaRTKQtpxeE4gypz69NvDkyZUd7Y3SJ" => 0.08
 ]

Note: This method only creates the raw transaction data. The transaction's inputs are not signed, and it is not
stored in the wallet or transmitted to the network.

Example:
<code>
 $transactions = [
     [
         "txid" => "7de4c9a1e715a9aaf6f8573ce16f8bc3c06f927826e2d0c39424e1524eccda89",
         "vout" => 1
     ],
     [
         "tdid" => "d2e611dcb3348c315dadeaa959cff662328f124e3a3e80fe8f33056bac95b9fe",
         "vout" => 2
     ]
 ];
 $addresses = [
     "1Headz2mYtpBRo6KFaaUEtcm5Kce6BZRJM" => 0.5,
     "13P4LpjYyBvWt283DffjsHpoFWFprr9dVq" => 0.08
 ];
 $raw = $api->createRawTransaction($transactions, $addresses);
</code>

* Visibility: **public**

#### Arguments

* $transactions **array** - &lt;p&gt;The transactions&lt;/p&gt;
* $addresses **array** - &lt;p&gt;Array using addresses for keys, and amounts for values&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::decodeRawTransaction()

```
array Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::decodeRawTransaction()(string $hex_string)
```

Decodes a raw serialized transaction

Given a serialized, hex-encoded transaction, the method decodes it, and returns an array of the transaction
information.

Returns an array with the following keys:
 "hex"               - (string)  The serialized, hex-encoded data.
 "txid"              - (string)  The transaction id.
 "version"           - (int)     The version.
 "locktime"          - (int)     The lock time.
 "vin"               - (array)   An array with the following keys:
     "txid"          - (string)  The transaction id.
     "vout"          - (int)     The vout index.
     "scriptSig"     - (array)   The script, an array with keys:
         "asm"       - (string)  Script in asm format.
         "hex"       - (string)  Script in hex format.
     "sequence"      - (int)     The script sequence number.
 "vout"              - (array)   An array with the following keys:
     "value"         - (double)  The amount sent.
     "n"             - (int)     The index.
     "scriptPubKey"  - (array)   An array with the following keys:
         "asm"       - (string)  The script in asm format.
         "hex"       - (string)  The script in hex format.
         "reqSigs"   - (int)     The number of required sigs.
         "type"      - (string)  The type, eg 'pubkeyhash'.
         "addresses" - (array)   An array of addresses.
 "blockhash"         - (string)  The block hash.
 "confirmations"     - (int)     The number of confirmations.
 "time"              - (int)     The transaction time in seconds since epoch (Jan 1 1970 GMT).
 "blocktime"         - (int)     The block time in seconds since epoch (Jan 1 1970 GMT).

* Visibility: **public**

#### Arguments

* $hex_string **string** - &lt;p&gt;The serialized, hex-encoded transaction data&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::encrypt()

```
bool Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::encrypt()(string $pass_phrase)
```

Encrypts the wallet with the given pass phrase

After this, any calls that interact with private keys such as sending or signing will require the passphrase to
be set prior the making these calls. Use the unlock() for this, and then lock().

Note: This will shutdown the server.

* Visibility: **public**

#### Arguments

* $pass_phrase **string** - &lt;p&gt;The pass phrase to encrypt the wallet with. It must be at least 1 character, but should be long&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::lock()

```
bool Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::lock()()
```

Removes the wallet encryption key from memory, locking the wallet

After calling this method, you will need to call unlock() again before being able to call any methods
which require the wallet to be unlocked.

* Visibility: **public**



### \Headzoo\CoinTalk\Wallet::unlock()

```
bool Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::unlock()(string $passphrase, int $timeout)
```

Stores the wallet decryption key in memory for $timeout seconds



* Visibility: **public**

#### Arguments

* $passphrase **string** - &lt;p&gt;The wallet pass phrase&lt;/p&gt;
* $timeout **int** - &lt;p&gt;Number of seconds to keep the pass phrase in memory&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::changePassPhrase()

```
array Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::changePassPhrase()(string $old_passphrase, string $new_passphrase)
```

Updates the wallet passphrase



* Visibility: **public**

#### Arguments

* $old_passphrase **string** - &lt;p&gt;The old pass phrase&lt;/p&gt;
* $new_passphrase **string** - &lt;p&gt;The new pass phrase&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::backup()

```
bool Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::backup()(string $destination)
```

Safely copies wallet.dat to $destination

The destination can be a directory or a path with filename.

* Visibility: **public**

#### Arguments

* $destination **string** - &lt;p&gt;The destination directory or file&lt;/p&gt;



### \Headzoo\CoinTalk\Wallet::stop()

```
string Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::stop()()
```

Shutdown the wallet



* Visibility: **public**



### \Headzoo\CoinTalk\Wallet::fillKeyPool()

```
bool Headzoo\CoinTalk\Wallet::\Headzoo\CoinTalk\Wallet::fillKeyPool()()
```

Fills the keypool



* Visibility: **public**


