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
```php
 $rpc  = new JsonRPC();
 $info = $rpc->query("getinfo");
 echo $info["version"];
 echo $info["balance"];
 echo $info["difficulty"];
```
```php
public array Headzoo\CoinTalk\JsonRPCInterface::Headzoo\CoinTalk\JsonRPCInterface::query(string $method, array $params)
```


##### Arguments

* **string** $method - The method to call
* **array** $params - The method parameters


