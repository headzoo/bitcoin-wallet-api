Coin Talk
=========
PHP library which facilitates communication with the Bitcoin JSON-RPC API. The rest of this documentation refers
to the Bitcoin wallet, but this library works with any Bitcoin wallet descendant. Including wallets for Litecoin and
Dogecoin. 

- [Overview](#overview)
- [Requirements](#requirements)
- [Installing](#installing)
    - [Git](#git)
    - [Composer](#composer)
    - [Wallet](#wallet)
- [Getting Started](#getting-started)
- [Class Documentation](#class-documentation)
    - [Headzoo\CoinTalk\JsonRPC](#headzoocointalkjsonrpc)
    - [Headzoo\CoinTalk\Wallet](#headzoocointalkwallet)
    - [Headzoo\CoinTalk\RPCPool](#headzoocointalkrpcpool)
- [Change Log](#change-log)
- [TODO](#todo)
- [License](#license)

Overview
--------
The goal of this project is to provide more than a thin PHP wrapper to the Bitcoin JSON-RPC API; there are plenty
of PHP libraries for that purpose. This library is meant to be more powerful than other libraries by offering the
following features:

* Concrete methods are defined for each API call, which means modern IDEs can provide auto-complete and argument documentation.
* Arguments for each API call are checked for correct type and format, which is useful during development and debugging.
* Abstracts away some of the Bitcoin API complications and inconsistencies, while tyring to stay close to the original.
* RPCPool management so that wallets may be clustered, with queries are evenly distributed to the cluster.
* Solid documentation for each API call. Often taken directly from the Bitcoin source code.
* PSR compliance.

See the [Bitcoin API wiki](https://en.bitcoin.it/wiki/Original_Bitcoin_client/API_Calls_list) for information on each method.

**Please notify me of API changes by submitting an issue.**

Requirements
------------
* PHP 5.4 or greater.
* cURL PHP extension.
* A logger library which supports PSR-3, if you want to log requests.
* A Bitcoin wallet which supports the JSON-API API.

Installing
----------
The library may be installed using either git or composer. Additionally you will need to install a Bitcoin wallet, and
configure the wallet to act as a RPC server.

##### Git
Simply clone the project with the following command.

```
git clone git@github.com:headzoo/coin-talk.git
```

##### Composer
Add the project to your composer.json as a dependency.

```
"require": {
    "headzoo/coin-talk" : "dev-master"
}
```

##### Wallet
You will need to configure you wallet to act as a server before using this library. This is done by adding a few
configuration values to the `bitcoin.conf` file. Shut down your wallet if it's running, and find your Bitcoin data
directory. By default the data directory is located at `/home/[user]/.bitcoin` on Linux systems,
and `/Users/[user]/AppData/Roaming/Bitcoin` on Windows systems. Create the `bitcoin.conf` file in the data directory
if it does not already exist.

Add the following lines:

```
rpcuser=testuser
rpcpassword=testpass
rpcallowip=127.0.0.1
rpcport=9335
server=1
```

You will of course want to choose a strong username and password combination. Non-Bitcoin wallets are configured in the
same way. For example the Litecoin data directory is located at `/home/[user]/.litecoin` on Linux systems,
and `/Users/[user]/AppData/Roaming/Litecoin` on Windows systems, and the configuration file is named litecoin.conf.

**Note**: You will also need to add `txindex=1` to your configuration if you want to query the wallet for non-wallet
transactions. You may need to start your wallet with the `-rescan` switch for the first time after adding this
configuration directive.

Getting Started
---------------
```php
<?php
use Headzoo\CoinTalk\JsonRPC;
use Headzoo\CoinTalk\Wallet;
use Headzoo\CoinTalk\RPCException;

// These configuration settings must match those from the bitcoin.conf file.
$conf = [
    "user" => "testuser",
    "pass" => "testpass",
    "host" => "127.0.0.1",
    "port" => 9332
];

// Begin by creating a Wallet instance, which needs an instance of JsonRPC passed to it's constructor.
$wallet = new Wallet(new JsonRPC($conf));

try {
    // Get some basic information from the wallet.
    $info = $wallet->getInfo();
    print_r($info);
} catch (RPCException $e) {
    echo $e->getTraceAsString();
    die();
}

// Example output:
// [
//     "version"         => 90000,
//     "protocolversion" => 70002,
//     "walletversion"   => 60000,
//     "balance"         => 6.02730425,
//     "blocks"          => 292075,
//     "timeoffset"      => -1,
//     "connections"     => 65,
//     "proxy"           => "",
//     "difficulty"      => 4250217919.86953540,
//     "testnet"         => false,
//     "keypoololdest"   => 1387569300,
//     "keypoolsize"     => 101,
//     "paytxfee"        => 0,
//     "mininput"        => 0.00100000,
//     "unlocked_until"  => 0,
//     "errors"          => ""
// ]

try {
    // Get information about a specific block from the block chain.
    $block = $wallet->getBlock("00000000000000005242ff2ddc9a407d67632ae7ee97f8c472358931b8bfc679");
    print_r($block);
} catch (RPCException $e) {
    echo $e->getTraceAsString();
    die();
}

// Example output:
// [
//     "hash"               => "00000000000000005242ff2ddc9a407d67632ae7ee97f8c472358931b8bfc679",
//     "confirmations"      => 6,
//     "size"               => 76575,
//     "height"             => 292068,
//     "version"            => 2,
//     "merkleroot"         => "2520dd58da8b7e8d9f416db0c2d6669e63eb722a6bc6c344abfcfe64ac0ab024",
//     "tx"                 => [
//          "38c78866705c623615c502f13dff5da60cdfee74ec77025bbc0cd419b215bf5d",
//          "46f551c0ba5822410c2349c6114dfb668adab827180eb5489a289b940e996682"
//     ],
//     "time"               => 1395587882,
//     "nonce"              => 1796742204,
//     "bits"               => "190102b1",
//     "difficulty"         => 4250217919.86953540,
//     "chainwork"          => "000000000000000000000000000000000000000000002c6e31ad55d7fe8c8665",
//     "previousblockhash"  => "0000000000000000fa0424195c23ca1078d04011796f382778f211bde0a08ae5",
//     "nextblockhash"      => "0000000000000000c965941f8821c858c882414f0819aeccf1593076f97cb150"
// ]

// Signing a message using an address from the wallet, and then verifying the signature.
$address = "16sycWcsHDM1iedeLs11jDmryqHwsz8Bfd";
$message = "Mary had a little lamb.";
try {
    // Encrypted wallets must be unlocked first.
    $wallet->unlock("asd3sd945DS3a8D");
    $signature = $wallet->signMessage($address, $message);
    var_dump($signature);
} catch (RPCException $e) {
    echo $e->getTraceAsString();
    die();
}

// Example output:
// "IEE8F4Idkqt/q4qN4dXrMQBwrpetyrbAtPYptw+PM8As+XhSjo3qedsrlCccjaX7W+Gm9uXFz/MfLonwObgJkYw="

try {
    $is_valid = $wallet->isSignedMessageValid($address, $signature, $message);
    var_dump($is_valid);
} catch (RPCException $e) {
    echo $e->getTraceAsString();
    die();
}

// Example output:
// bool(true)
```

Class Documentation
-------------------
The full class API documentation is available in the `/docs` directory.

##### Headzoo\CoinTalk\JsonRPC
Core class which directly communicates with Bitcoin wallets supporting the JSON-RPC API. This class provides a single
`query($method, array $params = [])` method via the `Headzoo\CoinTalk\JsonRPCInterface` interface. Although you may
use this class directly to query a wallet, it's best to use an instance of `Headzoo\CoinTalk\Wallet` instead.

```php
<?php
use Headzoo\CoinTalk\JsonRPC;
use Headzoo\CoinTalk\RPCException;

$conf = [
    "user" => "testuser",
    "pass" => "testpass",
    "host" => "127.0.0.1",
    "port" => 9332
];
$rpc = new JsonRPC($conf);

try {
    $info = $rpc->query("getinfo");
} catch (RPCException $e) {
    echo $e->getTraceAsString();
    die();
}
```

##### Headzoo\CoinTalk\Wallet
Wraps an instance of `Headzoo\CoinTalk\JsonRPCInterface` to provide a higher level interface to the wallet API. This
class has methods for every single API call, eg `Headzoo\CoinTalk\Wallet::getInfo()`, `Headzoo\CoinTalk\Wallet::backup($destination)`,
`Headzoo\CoinTalk\Wallet::getAccount($account)`, etc. Using this class instead of directly using `Headzoo\CoinTalk\JsonRPC`
makes it easier to catch programming errors, and allows IDEs to provide auto-complete and type hinting.

```php
<?php
use Headzoo\CoinTalk\JsonRPC;
use Headzoo\CoinTalk\Wallet;
use Headzoo\CoinTalk\RPCException;

$conf = [
    "user" => "testnet",
    "pass" => "testnet",
    "host" => "localhost",
    "port" => 9332
];

try {
    $wallet  = new Wallet(JsonRPC($conf));
    $info    = $wallet->getInfo();
    $account = $wallet->getAccount("personal");
    $count   = $wallet->getBlockCount();
} catch (RPCException $e) {
    echo $e->getTraceAsString();
    die();
}
```

##### Headzoo\CoinTalk\RPCPool
Wallet servers may be clustered and queried randomly using the `Headzoo\CoinTalk\RPCPool` class.
Both `Headzoo\CoinTalk\JsonRPC` and `Headzoo\CoinTalk\RPCPool` implement `Headzoo\CoinTalk\JsonRPCInterface`, which
means either may be passed to the `Headzoo\CoinTalk\Wallet` constructor.

```php
<?php
use Headzoo\CoinTalk\RPCPool;
use Headzoo\CoinTalk\JsonRPC;
use Headzoo\CoinTalk\RPCException;

// Start by creating a new pool, adding JsonRPCInterface instances to it, and then pass the pool
// to the Wallet constructor.
$conf = [
    "wallet1" => [
        "user" => "testnet",
        "pass" => "testnet",
        "host" => "localhost",
        "port" => 9332
    ],
    "wallet2" => [
        "user" => "testnet",
        "pass" => "testnet",
        "host" => "localhost",
        "port" => 9333
    ]
];

$pool = new RPCPool();
$pool->add(new JsonRPC($conf["wallet1"]));
$pool->add(new JsonRPC($conf["wallet2"]));
$wallet = new Wallet($pool);

// A different server will be chosen by the pool for each method call.
try {
    $info     = $wallet->getInfo();
    $balance  = $wallet->getBalance();
    $accounts = $wallet->getAccounts();
} catch (Headzoo\CoinTalk\RPCException $e) {
    echo $e->getTraceAsString();
    die();
}
```

Change Log
----------
##### v0.3 - 2014-03-23
* Renamed class `Headzoo\CoinTalk\Api` to `Headzoo\CoinTalk\Wallet`.
* Renamed class `Headzoo\CoinTalk\Server` to `Headzoo\CoinTalk\JsonRPC`.
* Renamed class `Headzoo\CoinTalk\IServer` to `Headzoo\CoinTalk\JsonRPCInterface`.
* Renamed class `Headzoo\CoinTalk\Pool` to `Headzoo\CoinTalk\RPCPool`.
* Renamed methods starting with `list` in the `Headzoo\CoinTalk\Wallet` class with `get`, eg `listAccounts()` was renamed to `getAccounts()`.
* Renamed the following methods to make the method names more consistent, and so they conform to my naming standards:
    * `Headzoo\CoinTalk\Wallet::sendRawTransaction()`      to `Headzoo\CoinTalk\Wallet::submitRawTransaction()`.
    * `Headzoo\CoinTalk\Wallet::submitBlock()`             to `Headzoo\CoinTalk\Wallet::submitRawBlock()`.
    * `Headzoo\CoinTalk\Wallet::getRawMemPool()`           to `Headzoo\CoinTalk\Wallet::getTransactionsFromMemoryPool()`.
    * `Headzoo\CoinTalk\Wallet::dumpPrivKey()`             to `Headzoo\CoinTalk\Wallet::getPrivateKeyByAddress()`.
    * `Headzoo\CoinTalk\Wallet::importPrivKey()`           to `Headzoo\CoinTalk\Wallet::addPrivateKey()`.
    * `Headzoo\CoinTalk\Wallet::lockUnspent()`             to `Headzoo\CoinTalk\Wallet::setLockUnspent()`.
    * `Headzoo\CoinTalk\Wallet::sendToAddress()`           to `Headzoo\CoinTalk\Wallet::send()`.
    * `Headzoo\CoinTalk\Wallet::sendFrom()`                to `Headzoo\CoinTalk\Wallet::sendFromAccount()`.
    * `Headzoo\CoinTalk\Wallet::sendMany()`                to `Headzoo\CoinTalk\Wallet::sendManyFromAccount()`.
    * `Headzoo\CoinTalk\Wallet::verifyMessage()`           to `Headzoo\CoinTalk\Wallet::isSignedMessageValid()`.
    * `Headzoo\CoinTalk\Wallet::validateAddress()`         to `Headzoo\CoinTalk\Wallet::getAddressInfo()`.
    * `Headzoo\CoinTalk\Wallet::encryptWallet()`           to `Headzoo\CoinTalk\Wallet::encrypt()`.
    * `Headzoo\CoinTalk\Wallet::walletLock()`              to `Headzoo\CoinTalk\Wallet::lock()`.
    * `Headzoo\CoinTalk\Wallet::walletPassPhrase()`        to `Headzoo\CoinTalk\Wallet::unlock()`.
    * `Headzoo\CoinTalk\Wallet::walletPassPhraseChange()`  to `Headzoo\CoinTalk\Wallet::changePassPhrase()`.
    * `Headzoo\CoinTalk\Wallet::keyPoolRefill()`           to `Headzoo\CoinTalk\Wallet::fillKeyPool()`.
    * `Headzoo\CoinTalk\Wallet::stop()`                    to `Headzoo\CoinTalk\Wallet::stop()`.
    * `Headzoo\CoinTalk\Wallet::setTxFee()`                to `Headzoo\CoinTalk\Wallet::setTransactionFee()`.
    * `Headzoo\CoinTalk\Wallet::getReceivedByAddress()`    to `Headzoo\CoinTalk\Wallet::getBalanceByAddress()`.
    * `Headzoo\CoinTalk\Wallet::getAccount()`              to `Headzoo\CoinTalk\Wallet::getAccountByAddress()`.
    * `Headzoo\CoinTalk\Wallet::getAccountAddress()`       to `Headzoo\CoinTalk\Wallet::getAddressByAccount()`.
    * `Headzoo\CoinTalk\Wallet::createMultiSig()`          to `Headzoo\CoinTalk\Wallet::getNewMultiSignatureAddress()`.
    * `Headzoo\CoinTalk\Wallet::addMultiSigAddress()`      to `Headzoo\CoinTalk\Wallet::addMultiSignatureAddress()`.
    * `Headzoo\CoinTalk\Wallet::getTxOut()`                to `Headzoo\CoinTalk\Wallet::getTransactionOut()`.
    * `Headzoo\CoinTalk\Wallet::getTxOutSetInfo()`         to `Headzoo\CoinTalk\Wallet::getTransactionOutSet()`.
    * `Headzoo\CoinTalk\Wallet::getAddedNodeInfo()`        to `Headzoo\CoinTalk\Wallet::getNodeInfo()`.
* Removed the following methods:
    * `Headzoo\CoinTalk\Wallet::getReceivedByAccount()`.
    * `Headzoo\CoinTalk\Wallet::listReceivedByAccount()`.
    
##### v0.2 - 2013-12-31
* Minor tweaks.

##### v0.1 - 2013-12-18
* Genesis import!

TODO
----
* Ensure the wallet server version supports specific calls.
* Document which methods need an unlocked wallet.
* Create classes which represent:
    * Blocks
    * Keys (public/private)
    * Transactions
    * etc
    
License
-------
This content is released under the MIT License. See the included LICENSE for more information.

I write code because I like writing code, and writing code is a reward in itself, but donations are always welcome.

Bitcoin: 1Headz2mYtpBRo6KFaaUEtcm5Kce6BZRJM  
Litecoin: LheadzBgTNAitxYxUTUTTQ3RT7zR5jnkfq