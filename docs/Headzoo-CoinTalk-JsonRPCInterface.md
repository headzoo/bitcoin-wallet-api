Headzoo\CoinTalk\JsonRPCInterface
===============

Interface for the Bitcoin json-rpc.




* Interface name: JsonRPCInterface
* Namespace: Headzoo\CoinTalk
* This is an **interface**






Methods
-------


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

#### Arguments

* $method **string** - The method to call
* $params **array** - The method parameters


