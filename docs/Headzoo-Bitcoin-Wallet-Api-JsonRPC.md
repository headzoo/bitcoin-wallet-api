Headzoo\Bitcoin\Wallet\Api\JsonRPC
===============

Core class which directly communicates with Bitcoin wallets supporting the JSON-RPC API.

This class provides a single `query($method, array $params = [])` method via the
`Headzoo\Bitcoin\Wallet\Api\JsonRPCInterface` interface. Although you may use this class directly to query a wallet,
it's best to use an instance of `Headzoo\Bitcoin\Wallet\Api\Wallet` instead.

Example:
```php
 $conf = [
     "user" => "test",
     "pass" => "pass",
     "host" => "localhost",
     "port" => 9332
 ];
 $rpc  = new JsonRPC($conf);

 $info      = $rpc->query("getInfo");
 $balance   = $rpc->query("getBalance", ["headz", 1]);
 $signature = $rpc->query(
     "signMessage",
     [
         "1Headz2mYtpBRo6KFaaUEtcm5Kce6BZRJM",
         "Mary had a little lamb."
     ]
 );
```


* Class name: JsonRPC
* Namespace: Headzoo\Bitcoin\Wallet\Api
* This class implements: [Headzoo\Bitcoin\Wallet\Api\JsonRPCInterface](Headzoo-Bitcoin-Wallet-Api-JsonRPCInterface.md)




Properties
----------


### $conf
Configuration for the litecoind rpc


```php
private array $conf = array("user" => "test", "pass" => "test", "host" => "localhost", "port" => 9332)
```



### $web
Used to make http request to the wallet


```php
private Headzoo\Web\Tools\WebClientInterface $web
```



### $nonce
Used to generate request ids


```php
private Headzoo\Bitcoin\Wallet\Api\Nonce $nonce
```



### $exceptions
Map of http status codes to exceptions that should be thrown


```php
private array $exceptions = array(\Headzoo\Bitcoin\Wallet\Api\HTTPStatusCodes::UNAUTHORIZED => \Headzoo\Bitcoin\Wallet\Api\Exceptions\AuthenticationException::class, \Headzoo\Bitcoin\Wallet\Api\HTTPStatusCodes::NOT_FOUND => \Headzoo\Bitcoin\Wallet\Api\Exceptions\MethodNotFoundException::class, \Headzoo\Bitcoin\Wallet\Api\HTTPStatusCodes::BAD_REQUEST => \Headzoo\Bitcoin\Wallet\Api\Exceptions\BadRequestException::class, \Headzoo\Bitcoin\Wallet\Api\HTTPStatusCodes::FORBIDDEN => \Headzoo\Bitcoin\Wallet\Api\Exceptions\ForbiddenException::class, \Headzoo\Bitcoin\Wallet\Api\HTTPStatusCodes::INTERNAL_SERVER_ERROR => \Headzoo\Bitcoin\Wallet\Api\Exceptions\InternalServerErrorException::class)
```

* This property is **static**.


Methods
-------


### Headzoo\Bitcoin\Wallet\Api\JsonRPC::__construct
Constructor


```php
public mixed Headzoo\Bitcoin\Wallet\Api\JsonRPC::__construct(array $conf, Headzoo\Web\Tools\WebClientInterface $web, Headzoo\Bitcoin\Wallet\Api\NonceInterface $nonce)
```


##### Arguments

* $conf **array** - See the setConf() method
* $web **Headzoo\Web\Tools\WebClientInterface** - Used to make http post requests
* $nonce **[Headzoo\Bitcoin\Wallet\Api\NonceInterface](Headzoo-Bitcoin-Wallet-Api-NonceInterface.md)** - Any instance of NonceInterface



### Headzoo\Bitcoin\Wallet\Api\JsonRPC::setConf
Sets the configuration for the rpc

The configuration array should contain 4 items:
```
 "user" - The rpc username, default "test"
 "pass" - The rpc password, default "test"
 "host" - The rpc server host, default "localhost"
 "port" - The rpc server port, default 9332
```
```php
public Headzoo\Bitcoin\Wallet\Api\JsonRPC Headzoo\Bitcoin\Wallet\Api\JsonRPC::setConf(array $conf)
```


##### Arguments

* $conf **array** - Configuration for the rpc



### Headzoo\Bitcoin\Wallet\Api\JsonRPC::setWebClient
Sets the WebClientInterface used to make requests to the wallet


```php
public Headzoo\Bitcoin\Wallet\Api\JsonRPC Headzoo\Bitcoin\Wallet\Api\JsonRPC::setWebClient(Headzoo\Web\Tools\WebClientInterface $web)
```


##### Arguments

* $web **Headzoo\Web\Tools\WebClientInterface** - The WebClientInterface instance



### Headzoo\Bitcoin\Wallet\Api\JsonRPC::getWebClient
Returns the WebClientInterface instance used to make requests to the wallet

Automatically creates an instance if none has been set.
```php
public Headzoo\Web\Tools\WebClientInterface Headzoo\Bitcoin\Wallet\Api\JsonRPC::getWebClient()
```




### Headzoo\Bitcoin\Wallet\Api\JsonRPC::setNonce
Sets the object used to create request ids


```php
public Headzoo\Bitcoin\Wallet\Api\JsonRPC Headzoo\Bitcoin\Wallet\Api\JsonRPC::setNonce(Headzoo\Bitcoin\Wallet\Api\NonceInterface $nonce)
```


##### Arguments

* $nonce **[Headzoo\Bitcoin\Wallet\Api\NonceInterface](Headzoo-Bitcoin-Wallet-Api-NonceInterface.md)** - Any instance of NonceInterface



### Headzoo\Bitcoin\Wallet\Api\JsonRPC::query
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
public mixed Headzoo\Bitcoin\Wallet\Api\JsonRPC::query($method, array $params)
```


##### Arguments

* $method **mixed**
* $params **array**



### Headzoo\Bitcoin\Wallet\Api\JsonRPC::exec
Sends the query string to the server and returns the response


```php
protected Headzoo\Web\Tools\WebResponse Headzoo\Bitcoin\Wallet\Api\JsonRPC::exec(string $query)
```


##### Arguments

* $query **string** - The query string to send



### Headzoo\Bitcoin\Wallet\Api\JsonRPC::getResponseError
Creates an array of error information based on the server response

The Bitcoin api is a real mess. For some errors the server responds with a json encoded string.
For other errors an html string is returned, but the format of the html varies depending on
the error. Some of the html is well formatted, and can be parsed with SimpleXML, and other html
strings are not well formatted.

This method attempts to parse the various error responses, and returns an array with the keys:
```
 "message"   - (string)  A message describing the error
 "code"      - (int)     An error code
```

Returns `["message" => "", "code" => 0]` when there is no error.
```php
protected array Headzoo\Bitcoin\Wallet\Api\JsonRPC::getResponseError(Headzoo\Web\Tools\WebResponse $response)
```


##### Arguments

* $response **Headzoo\Web\Tools\WebResponse** - The server response



### Headzoo\Bitcoin\Wallet\Api\JsonRPC::getNonceValue
Generates and returns a nonce value for use as a request id


```php
protected string Headzoo\Bitcoin\Wallet\Api\JsonRPC::getNonceValue()
```




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


