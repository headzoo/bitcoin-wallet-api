Headzoo\CoinTalk\JsonRPC
===============

Used to query the coin rpc server.

Example:
<code>
 $conf = [
     "user" => "test",
     "pass" => "pass",
     "host" => "localhost",
     "port" => 9332
 ];
 $rpc  = new JsonRPC($conf);
 $info = $rpc->query("getinfo");
</code>


* Class name: JsonRPC
* Namespace: Headzoo\CoinTalk
* This class implements: [Headzoo\CoinTalk\JsonRPCInterface](Headzoo-CoinTalk-JsonRPCInterface.md)




Properties
----------


### $conf
Configuration for the litecoind rpc



```
private array $conf = array("user" => "test", "pass" => "test", "host" => "localhost", "port" => 9332)
```



### $http
Used to make http request to the wallet



```
private Headzoo\CoinTalk\HTTPInterface $http
```



### $logger
Used to log messages



```
private Psr\Log\LoggerInterface $logger
```



Methods
-------


### Headzoo\CoinTalk\JsonRPC::__construct
Constructor



```
public mixed Headzoo\CoinTalk\JsonRPC::Headzoo\CoinTalk\JsonRPC::__construct(array $conf, Psr\Log\LoggerInterface $logger)
```


##### Arguments

* **array** $conf - See the setConf() method
* **Psr\Log\LoggerInterface** $logger - Log requests and errors with this instance



### Headzoo\CoinTalk\JsonRPC::setConf
Sets the configuration for the rpc

The configuration array should contain 4 items:
 "user" - The rpc username, default "test"
 "pass" - The rpc password, default "test"
 "host" - The rpc server host, default "localhost"
 "port" - The rpc server port, default 9332

```
public Headzoo\CoinTalk\JsonRPC Headzoo\CoinTalk\JsonRPC::Headzoo\CoinTalk\JsonRPC::setConf(array $conf)
```


##### Arguments

* **array** $conf - Configuration for the rpc



### Headzoo\CoinTalk\JsonRPC::setLogger
Sets a logger instance

Once set, requests and errors will be logged using the instance.

```
public Headzoo\CoinTalk\JsonRPC Headzoo\CoinTalk\JsonRPC::Headzoo\CoinTalk\JsonRPC::setLogger(Psr\Log\LoggerInterface $logger)
```


##### Arguments

* **Psr\Log\LoggerInterface** $logger - The logger



### Headzoo\CoinTalk\JsonRPC::setHTTP
Sets the HTTPInterface used to make requests to the wallet



```
public Headzoo\CoinTalk\JsonRPC Headzoo\CoinTalk\JsonRPC::Headzoo\CoinTalk\JsonRPC::setHTTP(Headzoo\CoinTalk\HTTPInterface $http)
```


##### Arguments

* **[Headzoo\CoinTalk\HTTPInterface](Headzoo-CoinTalk-HTTPInterface.md)** $http - The HTTPInterface instance



### Headzoo\CoinTalk\JsonRPC::getHTTP
Returns the HTTPInterface instance used to make requests to the wallet

Automatically creates an instance if none has been set.

```
public Headzoo\CoinTalk\HTTPInterface Headzoo\CoinTalk\JsonRPC::Headzoo\CoinTalk\JsonRPC::getHTTP()
```




### Headzoo\CoinTalk\JsonRPC::query
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
public mixed Headzoo\CoinTalk\JsonRPC::Headzoo\CoinTalk\JsonRPC::query($method, array $params)
```


##### Arguments

* **mixed** $method
* **array** $params



### Headzoo\CoinTalk\JsonRPC::exec
Sends the query string to the server and returns the response



```
protected string Headzoo\CoinTalk\JsonRPC::Headzoo\CoinTalk\JsonRPC::exec(string $query)
```


##### Arguments

* **string** $query - The query string to send



### Headzoo\CoinTalk\JsonRPC::log
Logs a message with an arbitrary level when logging is enabled



```
protected null Headzoo\CoinTalk\JsonRPC::Headzoo\CoinTalk\JsonRPC::log(mixed $level, string $message, array $context)
```


##### Arguments

* **mixed** $level - The logging level
* **string** $message - The message to log
* **array** $context - Values to place into the message



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
public array Headzoo\CoinTalk\JsonRPCInterface::Headzoo\CoinTalk\JsonRPCInterface::query(string $method, array $params)
```

* This method is defined by [Headzoo\CoinTalk\JsonRPCInterface](Headzoo-CoinTalk-JsonRPCInterface.md)

##### Arguments

* **string** $method - The method to call
* **array** $params - The method parameters


