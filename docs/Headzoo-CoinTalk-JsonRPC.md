Headzoo\CoinTalk\JsonRPC
===============

Used to query the coin rpc server.

Example:
```php
 $conf = [
     "user" => "test",
     "pass" => "pass",
     "host" => "localhost",
     "port" => 9332
 ];
 $rpc  = new JsonRPC($conf);
 $info = $rpc->query("getinfo");
```


* Class name: JsonRPC
* Namespace: Headzoo\CoinTalk
* This class implements: [Headzoo\CoinTalk\JsonRPCInterface](Headzoo-CoinTalk-JsonRPCInterface.md)




Properties
----------


### $conf
Configuration for the litecoind rpc


```php
private array $conf = array("user" => "test", "pass" => "test", "host" => "localhost", "port" => 9332)
```



### $http
Used to make http request to the wallet


```php
private Headzoo\CoinTalk\HTTPInterface $http
```



### $logger
Used to log messages


```php
private Psr\Log\LoggerInterface $logger
```



Methods
-------


### Headzoo\CoinTalk\JsonRPC::__construct
Constructor


```php
public mixed Headzoo\CoinTalk\JsonRPC::__construct(array $conf, Psr\Log\LoggerInterface $logger)
```


##### Arguments

* $conf **array** - See the setConf() method
* $logger **Psr\Log\LoggerInterface** - Log requests and errors with this instance



### Headzoo\CoinTalk\JsonRPC::setConf
Sets the configuration for the rpc

The configuration array should contain 4 items:
```
 "user" - The rpc username, default "test"
 "pass" - The rpc password, default "test"
 "host" - The rpc server host, default "localhost"
 "port" - The rpc server port, default 9332
```
```php
public Headzoo\CoinTalk\JsonRPC Headzoo\CoinTalk\JsonRPC::setConf(array $conf)
```


##### Arguments

* $conf **array** - Configuration for the rpc



### Headzoo\CoinTalk\JsonRPC::setLogger
Sets a logger instance

Once set, requests and errors will be logged using the instance.
```php
public Headzoo\CoinTalk\JsonRPC Headzoo\CoinTalk\JsonRPC::setLogger(Psr\Log\LoggerInterface $logger)
```


##### Arguments

* $logger **Psr\Log\LoggerInterface** - The logger



### Headzoo\CoinTalk\JsonRPC::setHTTP
Sets the HTTPInterface used to make requests to the wallet


```php
public Headzoo\CoinTalk\JsonRPC Headzoo\CoinTalk\JsonRPC::setHTTP(Headzoo\CoinTalk\HTTPInterface $http)
```


##### Arguments

* $http **[Headzoo\CoinTalk\HTTPInterface](Headzoo-CoinTalk-HTTPInterface.md)** - The HTTPInterface instance



### Headzoo\CoinTalk\JsonRPC::getHTTP
Returns the HTTPInterface instance used to make requests to the wallet

Automatically creates an instance if none has been set.
```php
public Headzoo\CoinTalk\HTTPInterface Headzoo\CoinTalk\JsonRPC::getHTTP()
```




### Headzoo\CoinTalk\JsonRPC::query
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
public mixed Headzoo\CoinTalk\JsonRPC::query($method, array $params)
```


##### Arguments

* $method **mixed**
* $params **array**



### Headzoo\CoinTalk\JsonRPC::exec
Sends the query string to the server and returns the response


```php
protected string Headzoo\CoinTalk\JsonRPC::exec(string $query)
```


##### Arguments

* $query **string** - The query string to send



### Headzoo\CoinTalk\JsonRPC::log
Logs a message with an arbitrary level when logging is enabled


```php
protected null Headzoo\CoinTalk\JsonRPC::log(mixed $level, string $message, array $context)
```


##### Arguments

* $level **mixed** - The logging level
* $message **string** - The message to log
* $context **array** - Values to place into the message



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
public array Headzoo\CoinTalk\JsonRPCInterface::query(string $method, array $params)
```

* This method is defined by [Headzoo\CoinTalk\JsonRPCInterface](Headzoo-CoinTalk-JsonRPCInterface.md)

##### Arguments

* $method **string** - The method to call
* $params **array** - The method parameters


