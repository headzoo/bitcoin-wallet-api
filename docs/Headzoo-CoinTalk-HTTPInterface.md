Headzoo\CoinTalk\HTTPInterface
===============

Interface for classes which make http post requests.




* Interface name: HTTPInterface
* Namespace: Headzoo\CoinTalk
* This is an **interface**






Methods
-------


### \Headzoo\CoinTalk\HTTPInterface::request

```
string Headzoo\CoinTalk\HTTPInterface::\Headzoo\CoinTalk\HTTPInterface::request()
```

Sends the request and returns the response



* Visibility: **public**



### \Headzoo\CoinTalk\HTTPInterface::setUrl

```
\Headzoo\CoinTalk\HTTPInterface Headzoo\CoinTalk\HTTPInterface::\Headzoo\CoinTalk\HTTPInterface::setUrl(string $url)
```

Sets the url to request



* Visibility: **public**

#### Arguments

* $url **string** - The request url



### \Headzoo\CoinTalk\HTTPInterface::setPostData

```
\Headzoo\CoinTalk\HTTPInterface Headzoo\CoinTalk\HTTPInterface::\Headzoo\CoinTalk\HTTPInterface::setPostData(mixed $post_data)
```

Sets the post data



* Visibility: **public**

#### Arguments

* $post_data **mixed** - The post data



### \Headzoo\CoinTalk\HTTPInterface::setContentType

```
\Headzoo\CoinTalk\HTTPInterface Headzoo\CoinTalk\HTTPInterface::\Headzoo\CoinTalk\HTTPInterface::setContentType(string $content_type)
```

Sets the content type



* Visibility: **public**

#### Arguments

* $content_type **string** - The content type



### \Headzoo\CoinTalk\HTTPInterface::setAuthUser

```
\Headzoo\CoinTalk\HTTPInterface Headzoo\CoinTalk\HTTPInterface::\Headzoo\CoinTalk\HTTPInterface::setAuthUser(string $auth_user)
```

Sets the basic auth username



* Visibility: **public**

#### Arguments

* $auth_user **string** - The username



### \Headzoo\CoinTalk\HTTPInterface::setAuthPass

```
\Headzoo\CoinTalk\HTTPInterface Headzoo\CoinTalk\HTTPInterface::\Headzoo\CoinTalk\HTTPInterface::setAuthPass(string $auth_pass)
```

Sets the basic auth password



* Visibility: **public**

#### Arguments

* $auth_pass **string** - The password



### \Headzoo\CoinTalk\HTTPInterface::getStatusCode

```
int Headzoo\CoinTalk\HTTPInterface::\Headzoo\CoinTalk\HTTPInterface::getStatusCode()
```

Returns the status code returned by the server



* Visibility: **public**


