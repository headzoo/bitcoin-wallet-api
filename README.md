Coin Talk
=========

Provides PHP classes to communicate with cryptocurrency wallets, such as bitcoind, bitcoin-qt, litecoind, etc. With the
classes you may:

* Get information about the accounts held in the wallet
* Get information about the network, such as block information, transactions, and more.
* Send coins to other people.
* Backup a wallet, encrypt a wallet, and lock a wallet.
* Pool connections to wallets.

See the [Bitcoin API wiki](https://en.bitcoin.it/wiki/Original_Bitcoin_client/API_Calls_list) for information on each method.

Overview
--------
The library is comprised of three primary classes: `Headzoo\CoinTalk\Server`, `Headzoo\CoinTalk\Api`, and `Headzoo\CoinTalk\Pool`.

##### Headzoo\CoinTalk\Server
Core class which talks to Bitcoin wallets using JSON-RPC. Provides a single `query($method, array $params = [])` method
via the `Headzoo\CoinTalk\IServer` interface, which is used to call any of the wallet API methods.

##### Headzoo\CoinTalk\Api
Wraps an instance of `Headzoo\CoinTalk\Server` to provide a higher level interface. This class has a method for every
single wallet method, eg `Api::getInfo()`, `Api::backupWallet($destination)`, `Api::getAccount($address)`, etc. Using
this class instead of using `Headzoo\CoinTalk\Server` directly makes it easier to catch programming errors, and allows
IDEs to provide type hinting.

##### Headzoo\CoinTalk\Pool
Manages a pool of `Headzoo\CoinTalk\Server` instances, which allows clustering of wallets. Like the `Headzoo\CoinTalk\Server`
class, the `Headzoo\CoinTalk\Pool` class implements `Headzoo\CoinTalk\IServer`. Each call to `Headzoo\CoinTalk\Pool::query()`
chooses one of the pooled server instances, and sends the query through that server. Instances of this class may be passed
to an `Headzoo\CoinTalk\Api` instance to get the pooling and the higher level interface.

Examples
--------
Using the `Headzoo\CoinTalk\Server` class.

```php
$conf = [
    "user" => "testnet",
    "pass" => "testnet",
    "host" => "localhost",
    "port" => 9332
];
$server = new Headzoo\CoinTalk\Server($conf);

$info = $server->query("getinfo");
print_r($info);

// Outputs
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

Using the `Headzoo\CoinTalk\Api` class.

```php
$conf = [
    "user" => "testnet",
    "pass" => "testnet",
    "host" => "localhost",
    "port" => 9332
];
$server = new Headzoo\CoinTalk\Server($conf);
$api    = new Headzoo\CoinTalk\Api($server);

$info    = $api->getInfo();
$account = $api->getAccount("personal");
$count   = $api->getBlockCount();
```

Using the `Headzoo\CoinTalk\Pool` class.

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
$info = $pool->query("getinfo");

// Using the pool with the Api class.
$api = new Api($pool);
$info = $api->getInfo();
```

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

License
-------
This content is released under the MIT License. See the included LICENSE for more information.
