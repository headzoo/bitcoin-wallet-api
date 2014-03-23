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

```
private \Headzoo\CoinTalk\JsonRPCInterface[] $items = array()
```

The JsonRPCInterface instances in the pool



* Visibility: **private**


### $count

```
private int $count
```

Number of servers in the pool



* Visibility: **private**


### $index

```
private int $index
```

Index of the last server returned from the pool



* Visibility: **private**


Methods
-------


### \Headzoo\CoinTalk\RPCPool::add

```
\Headzoo\CoinTalk\RPCPool Headzoo\CoinTalk\RPCPool::\Headzoo\CoinTalk\RPCPool::add(\Headzoo\CoinTalk\JsonRPCInterface $rpc)
```

Adds an JsonRPCInterface instance to the pool



* Visibility: **public**

#### Arguments

* $rpc **[Headzoo\CoinTalk\JsonRPCInterface](Headzoo-CoinTalk-JsonRPCInterface.md)** - The JsonRPCInterface instance



### \Headzoo\CoinTalk\RPCPool::get

```
\Headzoo\CoinTalk\JsonRPCInterface|null Headzoo\CoinTalk\RPCPool::\Headzoo\CoinTalk\RPCPool::get()
```

Returns an JsonRPCInterface instance from the pool

Returns null when there are no servers in the pool.

* Visibility: **public**



### \Headzoo\CoinTalk\RPCPool::count

```
int Headzoo\CoinTalk\RPCPool::\Headzoo\CoinTalk\RPCPool::count()
```

Returns the number of JsonRPCInterface instances in the pool



* Visibility: **public**



### \Headzoo\CoinTalk\RPCPool::query

```
mixed Headzoo\CoinTalk\RPCPool::\Headzoo\CoinTalk\RPCPool::query($method, array $params)
```

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

* Visibility: **public**

#### Arguments

* $method **mixed**
* $params **array**



### \Headzoo\CoinTalk\JsonRPCInterface::query

```
array Headzoo\CoinTalk\JsonRPCInterface::\Headzoo\CoinTalk\JsonRPCInterface::query(string $method, array $params)
```

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

* Visibility: **public**
* This method is defined by [Headzoo\CoinTalk\JsonRPCInterface](Headzoo-CoinTalk-JsonRPCInterface.md)

#### Arguments

* $method **string** - The method to call
* $params **array** - The method parameters


