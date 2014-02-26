Coin Talk
---------

Provides PHP classes to communicate with cryptocurrency wallets, such as bitcoind, bitcoin-qt, litecoind, etc. With the classes you may:

* Get information about the accounts held in the wallet
* Get information about the network, such as block information, transactions, and more.
* Send coins to other people.
* Backup a wallet, encrypt a wallet, and lock a wallet.

And much more. See the [Bitcoin API wiki](https://en.bitcoin.it/wiki/Original_Bitcoin_client/API_Calls_list) for information on each method.

Examples
--------

Using the `Headzoo\CoinTalk\Server` class, which provides a low level means of communicating with the rpc server.

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

Using the `Headzoo\CoinTalk\Api` class, which is slightly higher level, but requires a `Headzoo\CoinTalk\Server` instance.

```php
$conf = [
    "user" => "testnet",
    "pass" => "testnet",
    "host" => "localhost",
    "port" => 9332
];
$server = new Headzoo\CoinTalk\Server($conf);
$api    = new Headzoo\CoinTalk\Api($server);

$info = $api->getInfo();
$account = $api->getAccount("personal");
$count = $api->getBlockCount();
```

The Api class is providing because it has concrete methods for each of the available methods on the RPC, which makes testing easier, and makes writing code in an IDE easier.

Requirements
------------
* PHP 5.4 or greater
* cURL PHP extension

Installing
----------
Add the classes to your project using git.

`git clone git@github.com:headzoo/coin-talk.git`

Adding the project to your composer.json.

`"headzoo/coin-talk" : "dev-master"`




License
-------
This content is released under the MIT License. See the included LICENSE for more information.
