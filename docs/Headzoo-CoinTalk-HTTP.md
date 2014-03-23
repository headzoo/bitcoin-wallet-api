Headzoo\CoinTalk\HTTP
===============

Used to make http post requests.




* Class name: HTTP
* Namespace: Headzoo\CoinTalk
* This class implements: [Headzoo\CoinTalk\HTTPInterface](Headzoo-CoinTalk-HTTPInterface.md)




Properties
----------


### $url

```
protected string $url
```

The url to request



* Visibility: **protected**


### $status_code

```
protected int $status_code = 200
```

The http status code returned by the requested server



* Visibility: **protected**


### $post_data

```
protected mixed $post_data
```

The post data



* Visibility: **protected**


### $content_type

```
protected string $content_type = "text/html"
```

The content type



* Visibility: **protected**


### $auth_user

```
protected string $auth_user
```

The basic auth username



* Visibility: **protected**


### $auth_pass

```
protected string $auth_pass
```

The basic auth password



* Visibility: **protected**


Methods
-------


### \Headzoo\CoinTalk\HTTP::__construct

```
mixed Headzoo\CoinTalk\HTTP::\Headzoo\CoinTalk\HTTP::__construct(string $url)
```

Constructor



* Visibility: **public**

#### Arguments

* $url **string** - The url to request



### \Headzoo\CoinTalk\HTTP::request

```
mixed Headzoo\CoinTalk\HTTP::\Headzoo\CoinTalk\HTTP::request()
```

Sends the request and returns the response



* Visibility: **public**



### \Headzoo\CoinTalk\HTTP::setUrl

```
mixed Headzoo\CoinTalk\HTTP::\Headzoo\CoinTalk\HTTP::setUrl($url)
```

Sets the url to request



* Visibility: **public**

#### Arguments

* $url **mixed**



### \Headzoo\CoinTalk\HTTP::setPostData

```
mixed Headzoo\CoinTalk\HTTP::\Headzoo\CoinTalk\HTTP::setPostData($post_data)
```

Sets the post data



* Visibility: **public**

#### Arguments

* $post_data **mixed**



### \Headzoo\CoinTalk\HTTP::setContentType

```
mixed Headzoo\CoinTalk\HTTP::\Headzoo\CoinTalk\HTTP::setContentType($content_type)
```

Sets the content type



* Visibility: **public**

#### Arguments

* $content_type **mixed**



### \Headzoo\CoinTalk\HTTP::setAuthUser

```
mixed Headzoo\CoinTalk\HTTP::\Headzoo\CoinTalk\HTTP::setAuthUser($auth_user)
```

Sets the basic auth username



* Visibility: **public**

#### Arguments

* $auth_user **mixed**



### \Headzoo\CoinTalk\HTTP::setAuthPass

```
mixed Headzoo\CoinTalk\HTTP::\Headzoo\CoinTalk\HTTP::setAuthPass($auth_pass)
```

Sets the basic auth password



* Visibility: **public**

#### Arguments

* $auth_pass **mixed**



### \Headzoo\CoinTalk\HTTP::getStatusCode

```
mixed Headzoo\CoinTalk\HTTP::\Headzoo\CoinTalk\HTTP::getStatusCode()
```

Returns the status code returned by the server



* Visibility: **public**



### \Headzoo\CoinTalk\HTTPInterface::request

```
string Headzoo\CoinTalk\HTTPInterface::\Headzoo\CoinTalk\HTTPInterface::request()
```

Sends the request and returns the response



* Visibility: **public**
* This method is defined by [Headzoo\CoinTalk\HTTPInterface](Headzoo-CoinTalk-HTTPInterface.md)



### \Headzoo\CoinTalk\HTTPInterface::setUrl

```
\Headzoo\CoinTalk\HTTPInterface Headzoo\CoinTalk\HTTPInterface::\Headzoo\CoinTalk\HTTPInterface::setUrl(string $url)
```

Sets the url to request



* Visibility: **public**
* This method is defined by [Headzoo\CoinTalk\HTTPInterface](Headzoo-CoinTalk-HTTPInterface.md)

#### Arguments

* $url **string** - The request url



### \Headzoo\CoinTalk\HTTPInterface::setPostData

```
\Headzoo\CoinTalk\HTTPInterface Headzoo\CoinTalk\HTTPInterface::\Headzoo\CoinTalk\HTTPInterface::setPostData(mixed $post_data)
```

Sets the post data



* Visibility: **public**
* This method is defined by [Headzoo\CoinTalk\HTTPInterface](Headzoo-CoinTalk-HTTPInterface.md)

#### Arguments

* $post_data **mixed** - The post data



### \Headzoo\CoinTalk\HTTPInterface::setContentType

```
\Headzoo\CoinTalk\HTTPInterface Headzoo\CoinTalk\HTTPInterface::\Headzoo\CoinTalk\HTTPInterface::setContentType(string $content_type)
```

Sets the content type



* Visibility: **public**
* This method is defined by [Headzoo\CoinTalk\HTTPInterface](Headzoo-CoinTalk-HTTPInterface.md)

#### Arguments

* $content_type **string** - The content type



### \Headzoo\CoinTalk\HTTPInterface::setAuthUser

```
\Headzoo\CoinTalk\HTTPInterface Headzoo\CoinTalk\HTTPInterface::\Headzoo\CoinTalk\HTTPInterface::setAuthUser(string $auth_user)
```

Sets the basic auth username



* Visibility: **public**
* This method is defined by [Headzoo\CoinTalk\HTTPInterface](Headzoo-CoinTalk-HTTPInterface.md)

#### Arguments

* $auth_user **string** - The username



### \Headzoo\CoinTalk\HTTPInterface::setAuthPass

```
\Headzoo\CoinTalk\HTTPInterface Headzoo\CoinTalk\HTTPInterface::\Headzoo\CoinTalk\HTTPInterface::setAuthPass(string $auth_pass)
```

Sets the basic auth password



* Visibility: **public**
* This method is defined by [Headzoo\CoinTalk\HTTPInterface](Headzoo-CoinTalk-HTTPInterface.md)

#### Arguments

* $auth_pass **string** - The password



### \Headzoo\CoinTalk\HTTPInterface::getStatusCode

```
int Headzoo\CoinTalk\HTTPInterface::\Headzoo\CoinTalk\HTTPInterface::getStatusCode()
```

Returns the status code returned by the server



* Visibility: **public**
* This method is defined by [Headzoo\CoinTalk\HTTPInterface](Headzoo-CoinTalk-HTTPInterface.md)


