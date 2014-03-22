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
    - [Headzoo\CoinTalk\Server](#headzoocointalkserver)
    - [Headzoo\CoinTalk\Api](#headzoocointalkapi)
    - [Headzoo\CoinTalk\Pool](#headzoocointalkpool)
- [License](#license)

Overview
--------
The goal of this project is to provide more than a thin PHP wrapper to the Bitcoin JSON-RPC; there are plenty
of PHP libraries for that purpose. This library is meant to be more powerful by offering the following features:

* Concrete methods are defined for each API call, which means modern IDEs can provide auto-complete and argument documentation.
* Arguments for each API call are checked for correct type and format, which is useful during development and debugging.
* Offers wallet pool management so that wallets may be clustered, with queries being evenly distributed to the wallets.

See the [Bitcoin API wiki](https://en.bitcoin.it/wiki/Original_Bitcoin_client/API_Calls_list) for information on each method.

Requirements
------------
* PHP 5.4 or greater
* cURL PHP extension

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

##### Headzoo\CoinTalk\Server
Core class which talks to Bitcoin wallets using JSON-RPC. Provides a single `query($method, array $params = [])` method
via the `Headzoo\CoinTalk\IServer` interface, which is used to call any of the wallet API methods.

Although you may use this class directly, it does not provide concrete methods for each API call, and does not error
check the arguments. It's recommended that you use the `Headzoo\CoinTalk\Api` class instead.

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

// Create the Server instance, and query the wallet for info.
try {
    $server = new Headzoo\CoinTalk\Server($conf);
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

##### Headzoo\CoinTalk\Api
Wraps an instance of `Headzoo\CoinTalk\Server` to provide a higher level interface. This class has a method for every
single wallet method, eg `Api::getInfo()`, `Api::backupWallet($destination)`, `Api::getAccount($address)`, etc. Using
this class instead of using `Headzoo\CoinTalk\Server` directly makes it easier to catch programming errors, and allows
IDEs to provide type hinting.

```php
$conf = [
    "user" => "testnet",
    "pass" => "testnet",
    "host" => "localhost",
    "port" => 9332
];

try {
    $server = new Headzoo\CoinTalk\Server($conf);
    $api    = new Headzoo\CoinTalk\Api($server);
    $info    = $api->getInfo();
    $account = $api->getAccount("personal");
    $count   = $api->getBlockCount();
} catch (Headzoo\CoinTalk\ServerException $e) {
    echo $e->getTraceAsString();
    die();
}
```

##### Headzoo\CoinTalk\Pool
Manages a pool of `Headzoo\CoinTalk\Server` instances, which allows clustering of wallets. Like the `Headzoo\CoinTalk\Server`
class, the `Headzoo\CoinTalk\Pool` class implements `Headzoo\CoinTalk\IServer`. Each call to `Headzoo\CoinTalk\Pool::query()`
chooses one of the pooled server instances, and sends the query through that server. Instances of this class may be passed
to an `Headzoo\CoinTalk\Api` instance to get the pooling and the higher level interface.

```php
$pool = new Headzoo\CoinTalk\Pool()
$conf = [
    "user" => "testnet",
    "pass" => "testnet",
    "host" => "localhost",
    "port" => 9332
];
$server = new Headzoo\CoinTalk\Server($conf);
$pool->add($server);

$conf = [
    "user" => "testnet",
    "pass" => "testnet",
    "host" => "localhost",
    "port" => 9333
];
$server = new Headzoo\CoinTalk\Server($conf);
$pool->add($server);

// The query will be sent using one of the Server instances in the pool.
try {
    $info = $pool->query("getinfo");
} catch (Headzoo\CoinTalk\ServerException $e) {
    echo $e->getTraceAsString();
    die();
}

// Using the pool with the Api class.
try {
    $api = new Api($pool);
    $info = $api->getInfo();
} catch (Headzoo\CoinTalk\ServerException $e) {
    echo $e->getTraceAsString();
    die();
}
```

License
-------
This content is released under the MIT License. See the included LICENSE for more information.

I write code because I like writing code, and writing code is a reward in itself, but donations are always welcome.

Bitcoin: 1Headz2mYtpBRo6KFaaUEtcm5Kce6BZRJM  
Litecoin: LheadzBgTNAitxYxUTUTTQ3RT7zR5jnkfq


TODO
----
Handle errors caused by encrypted wallets.