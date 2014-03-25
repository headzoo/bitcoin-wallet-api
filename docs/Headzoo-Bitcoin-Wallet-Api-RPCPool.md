Headzoo\Bitcoin\Wallet\Api\RPCPool
===============

Manages a pool of JsonRPCInterface instances

Acts as an instance of JsonRPCInterface, which transparently uses a pool of JsonRPCInterface
instances to query wallets.

Example:
```php
 $pool = new RPCPool();
 $conf = [
     "user" => "test",
     "pass" => "pass",
     "host" => "localhost",
     "port" => 9332
 ];
 $rpc = new JsonRPC($conf);
 $pool->add($rpc);

 $conf = [
     "user" => "test",
     "pass" => "pass",
     "host" => "localhost",
     "port" => 9333
 ];
 $rpc = new JsonRPC($conf);
 $pool->add($rpc);

 $info = $pool->query("getinfo");
```


* Class name: RPCPool
* Namespace: Headzoo\Bitcoin\Wallet\Api
* This class implements: [Headzoo\Bitcoin\Wallet\Api\JsonRPCInterface](Headzoo-Bitcoin-Wallet-Api-JsonRPCInterface.md)




Properties
----------


### $items
The JsonRPCInterface instances in the pool


```php
private Headzoo\Bitcoin\Wallet\Api\JsonRPCInterface[] $items = array()
```



### $count
Number of servers in the pool


```php
private int $count
```



### $index
Index of the last server returned from the pool


```php
private int $index
```



Methods
-------


### Headzoo\Bitcoin\Wallet\Api\RPCPool::add
Adds an JsonRPCInterface instance to the pool


```php
public Headzoo\Bitcoin\Wallet\Api\RPCPool Headzoo\Bitcoin\Wallet\Api\RPCPool::add(Headzoo\Bitcoin\Wallet\Api\JsonRPCInterface $rpc)
```


##### Arguments

* $rpc **[Headzoo\Bitcoin\Wallet\Api\JsonRPCInterface](Headzoo-Bitcoin-Wallet-Api-JsonRPCInterface.md)** - The JsonRPCInterface instance



### Headzoo\Bitcoin\Wallet\Api\RPCPool::get
Returns an JsonRPCInterface instance from the pool

Returns null when there are no servers in the pool.
```php
public Headzoo\Bitcoin\Wallet\Api\JsonRPCInterface|null Headzoo\Bitcoin\Wallet\Api\RPCPool::get()
```




### Headzoo\Bitcoin\Wallet\Api\RPCPool::count
Returns the number of JsonRPCInterface instances in the pool


```php
public int Headzoo\Bitcoin\Wallet\Api\RPCPool::count()
```




### Headzoo\Bitcoin\Wallet\Api\RPCPool::query
Sends a raw query the litecoind rpc

Returns an array which contains the server response.

Example:
```php
 $rpc  = new JsonRPC();
 $info = $rpc->query("getInfo");
 echo $info["version"];
 echo $info["balance"];
 echo $info["difficulty"];

$signature = $rpc->query(
     "signMessage",
     [
         "1Headz2mYtpBRo6KFaaUEtcm5Kce6BZRJM",
         "Mary had a little lamb."
     ]
);
```
```php
public mixed Headzoo\Bitcoin\Wallet\Api\RPCPool::query($method, array $params)
```


##### Arguments

* $method **mixed**
* $params **array**



### Headzoo\Bitcoin\Wallet\Api\JsonRPCInterface::query
Sends a raw query the litecoind rpc

Returns an array which contains the server response.

Example:
```php
 $rpc  = new JsonRPC();
 $info = $rpc->query("getInfo");
 echo $info["version"];
 echo $info["balance"];
 echo $info["difficulty"];

$signature = $rpc->query(
     "signMessage",
     [
         "1Headz2mYtpBRo6KFaaUEtcm5Kce6BZRJM",
         "Mary had a little lamb."
     ]
);
```
```php
public array Headzoo\Bitcoin\Wallet\Api\JsonRPCInterface::query(string $method, array $params)
```

* This method is defined by [Headzoo\Bitcoin\Wallet\Api\JsonRPCInterface](Headzoo-Bitcoin-Wallet-Api-JsonRPCInterface.md)

##### Arguments

* $method **string** - The name of the api method to call
* $params **array** - Optional method parameters


