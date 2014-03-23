Headzoo\CoinTalk\HTTPInterface
===============

Interface for classes which make http post requests.




* Interface name: HTTPInterface
* Namespace: Headzoo\CoinTalk
* This is an **interface**






Methods
-------


### Headzoo\CoinTalk\HTTPInterface::request
Sends the request and returns the response


```php
public string Headzoo\CoinTalk\HTTPInterface::request()
```




### Headzoo\CoinTalk\HTTPInterface::setUrl
Sets the url to request


```php
public Headzoo\CoinTalk\HTTPInterface Headzoo\CoinTalk\HTTPInterface::setUrl(string $url)
```


##### Arguments

* **string** $url - The request url



### Headzoo\CoinTalk\HTTPInterface::setPostData
Sets the post data


```php
public Headzoo\CoinTalk\HTTPInterface Headzoo\CoinTalk\HTTPInterface::setPostData(mixed $post_data)
```


##### Arguments

* **mixed** $post_data - The post data



### Headzoo\CoinTalk\HTTPInterface::setContentType
Sets the content type


```php
public Headzoo\CoinTalk\HTTPInterface Headzoo\CoinTalk\HTTPInterface::setContentType(string $content_type)
```


##### Arguments

* **string** $content_type - The content type



### Headzoo\CoinTalk\HTTPInterface::setAuthUser
Sets the basic auth username


```php
public Headzoo\CoinTalk\HTTPInterface Headzoo\CoinTalk\HTTPInterface::setAuthUser(string $auth_user)
```


##### Arguments

* **string** $auth_user - The username



### Headzoo\CoinTalk\HTTPInterface::setAuthPass
Sets the basic auth password


```php
public Headzoo\CoinTalk\HTTPInterface Headzoo\CoinTalk\HTTPInterface::setAuthPass(string $auth_pass)
```


##### Arguments

* **string** $auth_pass - The password



### Headzoo\CoinTalk\HTTPInterface::getStatusCode
Returns the status code returned by the server


```php
public int Headzoo\CoinTalk\HTTPInterface::getStatusCode()
```



