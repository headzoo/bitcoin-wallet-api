Headzoo\CoinTalk\RPCPool
===============

Manages a pool of JsonRPCInterface instances

Acts as an instance of JsonRPCInterface, which transparently uses a pool of JsonRPCInterface
instances to query wallets.

Example:
<code>
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

* Visibility: **private**


### $count
Number of servers in the pool



```
private int $count
```

* Visibility: **private**


### $index
Index of the last server returned from the pool



```
private int $index
```

* Visibility: **private**


Methods
-------


### Headzoo\CoinTalk\RPCPool::add
Adds an JsonRPCInterface instance to the pool



```
Headzoo\CoinTalk\RPCPool Headzoo\CoinTalk\RPCPool::Headzoo\CoinTalk\RPCPool::add(Headzoo\CoinTalk\JsonRPCInterface $rpc)
```

* Visibility: **public**

#### Arguments

* $rpc **[Headzoo\CoinTalk\JsonRPCInterface](Headzoo-CoinTalk-JsonRPCInterface.md)** - The JsonRPCInterface instance



### Headzoo\CoinTalk\RPCPool::get
Returns an JsonRPCInterface instance from the pool

Returns null when there are no servers in the pool.

```
Headzoo\CoinTalk\JsonRPCInterface|null Headzoo\CoinTalk\RPCPool::Headzoo\CoinTalk\RPCPool::get()
```

* Visibility: **public**



### Headzoo\CoinTalk\RPCPool::count
Returns the number of JsonRPCInterface instances in the pool



```
int Headzoo\CoinTalk\RPCPool::Headzoo\CoinTalk\RPCPool::count()
```

* Visibility: **public**



### Headzoo\CoinTalk\RPCPool::query
Sends a raw query the litecoind rpc

Returns an array which contains the server response.

Example:
<code>
 $rpc  = new JsonRPC();
 $info = $rpc->query("getinfo");
 echo $info["version"];
 echo $info["balance"];
 echo $info["difficulty"];
</code>

```
mixed Headzoo\CoinTalk\RPCPool::Headzoo\CoinTalk\RPCPool::query($method, array $params)
```

* Visibility: **public**

#### Arguments

* $method **mixed**
* $params **array**



### Headzoo\CoinTalk\JsonRPCInterface::query
Sends a raw query the litecoind rpc

Returns an array which contains the server response.

Example:
<code>
 $rpc  = new JsonRPC();
 $info = $rpc->query("getinfo");
 echo $info["version"];
 echo $info["balance"];
 echo $info["difficulty"];
</code>

```
array Headzoo\CoinTalk\JsonRPCInterface::Headzoo\CoinTalk\JsonRPCInterface::query(string $method, array $params)
```

* Visibility: **public**
* This method is defined by [Headzoo\CoinTalk\JsonRPCInterface](Headzoo-CoinTalk-JsonRPCInterface.md)

#### Arguments

* $method **string** - The method to call
* $params **array** - The method parameters


