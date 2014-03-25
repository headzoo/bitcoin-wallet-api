Headzoo\Bitcoin\Wallet\Api\JsonRPCInterface
===============

Core interface for communicating with a Bitcoin wallet supporting the JSON-RPC API.




* Interface name: JsonRPCInterface
* Namespace: Headzoo\Bitcoin\Wallet\Api
* This is an **interface**






Methods
-------


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


##### Arguments

* $method **string** - The name of the api method to call
* $params **array** - Optional method parameters


