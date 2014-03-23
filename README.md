Coin Talk
=========

Provides PHP classes to communicate with any crypto wallet which supports the JSON-RPC protocol defined in the Bitcoin
wallet. The rest of this documentation will refer to the Bitcoin wallet, but this library will work with any wallet
which is a decentest of the Bitcoin wallet.

- [Overview](#overview)
- [Requirements](#requirements)
- [Installing](#installing)
    - [Git](#git)
    - [Composer](#composer)
- [Examples](#examples)
    - [Headzoo\CoinTalk\JsonRPC](#headzoocointalkserver)
    - [Headzoo\CoinTalk\Wallet](#headzoocointalkapi)
    - [Headzoo\CoinTalk\Pool](#headzoocointalkpool)
- [Change Log](#changelog)
- [TODO](#todo)
- [License](#license)

Overview
--------
The goal of this project is to provide more than a thin PHP wrapper to the Bitcoin JSON-RPC; there are plenty
of PHP libraries for that purpose. This library is meant to be more powerful than other libraries by offering the
following features:

* Concrete methods are defined for each API call, which means modern IDEs can provide auto-complete and argument documentation.
* Arguments for each API call are checked for correct type and format, which is useful during development and debugging.
* Abstracts away some of the Bitcoin API complications and inconsistencies, while tyring to stay close to the original.
* Pool management so that wallets may be clustered, with queries are evenly distributed to the cluster.
* Solid documentation for each API call. Often taken directly from the Bitcoin source code.

See the [Bitcoin API wiki](https://en.bitcoin.it/wiki/Original_Bitcoin_client/API_Calls_list) for information on each method.

**Please notify me of API changes by submitting an issue.**

Requirements
------------
* PHP 5.4 or greater.
* cURL PHP extension.
* A wallet server supporting the Bitcoin JSON-API protocol for Bitcoin wallet version 0.9 or greater.

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

Examples
--------

##### Headzoo\CoinTalk\JsonRPC
Core class which talks to Bitcoin wallets using JSON-RPC. Provides a single `query($method, array $params = [])` method
via the `Headzoo\CoinTalk\JsonRPCInterface` interface, which is used to call any of the wallet API methods.

Although you may use this class directly, it does not provide concrete methods for each API call, and does not error
check the arguments. It's recommended that you use the `Headzoo\CoinTalk\Wallet` class instead.

```php
/**
 * These settings represent the following bitcoin.conf settings:
 *     rpcuser=testuser
 *     rpcpassword=testpass
 *     rpcallowip=127.0.0.1
 *     rpcport=9332
 *     server=1
 */
$conf = [
    "user" => "testuser",
    "pass" => "testpass",
    "host" => "127.0.0.1",
    "port" => 9332
];

// Create the JsonRPC instance, and query the wallet for info.
try {
    $server = new Headzoo\CoinTalk\JsonRPC($conf);
    $info = $server->query("getinfo");
    print_r($info);
} catch (Headzoo\CoinTalk\ServerException $e) {
    echo $e->getTraceAsString();
    die();
}

// Example output:
// array
// (
//     [version] => 60401
//     [protocolversion] => 60011
//     [walletversion] => 60000
//     [balance] => 556.02730425
//     [blocks] => 396154
//     [connections] => 65
//     [proxy] => 
//     [difficulty] => 5.58278089
//     [testnet] => 
//     [keypoololdest] => 1386112779
//     [keypoolsize] => 101
//     [paytxfee] => 0
//     [mininput] => 0.0001
//     [errors] => 
)
```

##### Headzoo\CoinTalk\Wallet
Wraps an instance of `Headzoo\CoinTalk\JsonRPCInterface` to provide a higher level interface. This class has a method for every
single wallet method, eg `Wallet::getInfo()`, `Wallet::backup($destination)`, `Wallet::getAccount($account)`, etc. Using
this class instead of using `Headzoo\CoinTalk\JsonRPC` directly makes it easier to catch programming errors, and allows
IDEs to provide type hinting.

```php
$conf = [
    "user" => "testnet",
    "pass" => "testnet",
    "host" => "localhost",
    "port" => 9332
];

try {
    $server = new Headzoo\CoinTalk\JsonRPC($conf);
    $api    = new Headzoo\CoinTalk\Wallet($server);
    $info    = $api->getInfo();
    $account = $api->getAccount("personal");
    $count   = $api->getBlockCount();
} catch (Headzoo\CoinTalk\ServerException $e) {
    echo $e->getTraceAsString();
    die();
}
```

##### Headzoo\CoinTalk\Pool
Manages a pool of `Headzoo\CoinTalk\JsonRPC` instances, which allows clustering of wallets. Like the `Headzoo\CoinTalk\JsonRPC`
class, the `Headzoo\CoinTalk\Pool` class implements `Headzoo\CoinTalk\JsonRPCInterface`. Each call to `Headzoo\CoinTalk\Pool::query()`
chooses one of the pooled server instances, and sends the query through that server. Instances of this class may be passed
to an `Headzoo\CoinTalk\Wallet` instance to get the pooling and the higher level interface.

```php
$pool = new Headzoo\CoinTalk\Pool()
$conf = [
    "user" => "testnet",
    "pass" => "testnet",
    "host" => "localhost",
    "port" => 9332
];
$server = new Headzoo\CoinTalk\JsonRPC($conf);
$pool->add($server);

$conf = [
    "user" => "testnet",
    "pass" => "testnet",
    "host" => "localhost",
    "port" => 9333
];
$server = new Headzoo\CoinTalk\JsonRPC($conf);
$pool->add($server);

// The query will be sent using one of the JsonRPC instances in the pool.
try {
    $info = $pool->query("getinfo");
} catch (Headzoo\CoinTalk\ServerException $e) {
    echo $e->getTraceAsString();
    die();
}

// Using the pool with the Wallet class.
try {
    $api  = new Wallet($pool);
    $info = $api->getInfo();
} catch (Headzoo\CoinTalk\ServerException $e) {
    echo $e->getTraceAsString();
    die();
}
```

Change Log
----------
##### v0.2 - 2014-03-23
* Renamed class `Headzoo\CoinTalk\Api` to `Headzoo\CoinTalk\Wallet`.
* Renamed class `Headzoo\CoinTalk\Server` to `Headzoo\CoinTalk\JsonRPC`.
* Renamed class `Headzoo\CoinTalk\IServer` to `Headzoo\CoinTalk\JsonRPCInterface`.
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
    
##### v0.1 - 2013-12-18
* Genesis import!

TODO
----
* Ensure the wallet is the right version for the API call.
* Document which methods need an unlocked wallet.
* Create classes for:
    * Blocks
    * Keys (public/private)
    * Addresses
    * Transactions
    * etc
    
License
-------
This content is released under the MIT License. See the included LICENSE for more information.

I write code because I like writing code, and writing code is a reward in itself, but donations are always welcome.

Bitcoin: 1Headz2mYtpBRo6KFaaUEtcm5Kce6BZRJM  
Litecoin: LheadzBgTNAitxYxUTUTTQ3RT7zR5jnkfq