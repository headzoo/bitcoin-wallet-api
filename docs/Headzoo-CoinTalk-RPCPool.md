Headzoo\CoinTalk\RPCPool
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
* Namespace: Headzoo\CoinTalk
* This class implements: [Headzoo\CoinTalk\JsonRPCInterface](Headzoo-CoinTalk-JsonRPCInterface.md)




Properties
----------


### $items
The JsonRPCInterface instances in the pool


```
private Headzoo\CoinTalk\JsonRPCInterface[] $items = array()
```



### $count
Number of servers in the pool


```
private int $count
```



### $index
Index of the last server returned from the pool


```
private int $index
```



Methods
-------


### Headzoo\CoinTalk\RPCPool::add
Adds an JsonRPCInterface instance to the pool


```
public Headzoo\CoinTalk\RPCPool Headzoo\CoinTalk\RPCPool::Headzoo\CoinTalk\RPCPool::add(Headzoo\CoinTalk\JsonRPCInterface $rpc)
```


##### Arguments

* **[Headzoo\CoinTalk\JsonRPCInterface](Headzoo-CoinTalk-JsonRPCInterface.md)** $rpc - The JsonRPCInterface instance



### Headzoo\CoinTalk\RPCPool::get
Returns an JsonRPCInterface instance from the pool

Returns null when there are no servers in the pool.
```
public Headzoo\CoinTalk\JsonRPCInterface|null Headzoo\CoinTalk\RPCPool::Headzoo\CoinTalk\RPCPool::get()
```




### Headzoo\CoinTalk\RPCPool::count
Returns the number of JsonRPCInterface instances in the pool


```
public int Headzoo\CoinTalk\RPCPool::Headzoo\CoinTalk\RPCPool::count()
```




### Headzoo\CoinTalk\RPCPool::query
Sends a raw query the litecoind rpc

Returns an array which contains the server response.

Example:
```php
 $rpc  = new JsonRPC();
 $info = $rpc->query("getinfo");
 echo $info["version"];
 echo $info["balance"];
 echo $info["difficulty"];
```
```
public mixed Headzoo\CoinTalk\RPCPool::Headzoo\CoinTalk\RPCPool::query($method, array $params)
```


##### Arguments

* **mixed** $method
* **array** $params



### Headzoo\CoinTalk\JsonRPCInterface::query
Sends a raw query the litecoind rpc

Returns an array which contains the server response.

Example:
```php
 $rpc  = new JsonRPC();
 $info = $rpc->query("getinfo");
 echo $info["version"];
 echo $info["balance"];
 echo $info["difficulty"];
```
```
public array Headzoo\CoinTalk\JsonRPCInterface::Headzoo\CoinTalk\JsonRPCInterface::query(string $method, array $params)
```

* This method is defined by [Headzoo\CoinTalk\JsonRPCInterface](Headzoo-CoinTalk-JsonRPCInterface.md)

##### Arguments

* **string** $method - The method to call
* **array** $params - The method parameters


