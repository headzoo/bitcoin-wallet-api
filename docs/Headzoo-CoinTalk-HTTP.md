Headzoo\CoinTalk\HTTP
===============

Used to make http post requests.




* Class name: HTTP
* Namespace: Headzoo\CoinTalk
* This class implements: [Headzoo\CoinTalk\HTTPInterface](Headzoo-CoinTalk-HTTPInterface.md)




Properties
----------


### $url
The url to request


```php
protected string $url
```



### $status_code
The http status code returned by the requested server


```php
protected int $status_code = 200
```



### $post_data
The post data


```php
protected mixed $post_data
```



### $content_type
The content type


```php
protected string $content_type = "text/html"
```



### $auth_user
The basic auth username


```php
protected string $auth_user
```



### $auth_pass
The basic auth password


```php
protected string $auth_pass
```



Methods
-------


### Headzoo\CoinTalk\HTTP::__construct
Constructor


```php
public mixed Headzoo\CoinTalk\HTTP::__construct(string $url)
```


##### Arguments

* $url **string** - The url to request



### Headzoo\CoinTalk\HTTP::request
Sends the request and returns the response


```php
public mixed Headzoo\CoinTalk\HTTP::request()
```




### Headzoo\CoinTalk\HTTP::setUrl
Sets the url to request


```php
public mixed Headzoo\CoinTalk\HTTP::setUrl($url)
```


##### Arguments

* $url **mixed**



### Headzoo\CoinTalk\HTTP::setPostData
Sets the post data


```php
public mixed Headzoo\CoinTalk\HTTP::setPostData($post_data)
```


##### Arguments

* $post_data **mixed**



### Headzoo\CoinTalk\HTTP::setContentType
Sets the content type


```php
public mixed Headzoo\CoinTalk\HTTP::setContentType($content_type)
```


##### Arguments

* $content_type **mixed**



### Headzoo\CoinTalk\HTTP::setAuthUser
Sets the basic auth username


```php
public mixed Headzoo\CoinTalk\HTTP::setAuthUser($auth_user)
```


##### Arguments

* $auth_user **mixed**



### Headzoo\CoinTalk\HTTP::setAuthPass
Sets the basic auth password


```php
public mixed Headzoo\CoinTalk\HTTP::setAuthPass($auth_pass)
```


##### Arguments

* $auth_pass **mixed**



### Headzoo\CoinTalk\HTTP::getStatusCode
Returns the status code returned by the server


```php
public mixed Headzoo\CoinTalk\HTTP::getStatusCode()
```




### Headzoo\CoinTalk\HTTPInterface::request
Sends the request and returns the response


```php
public string Headzoo\CoinTalk\HTTPInterface::request()
```

* This method is defined by [Headzoo\CoinTalk\HTTPInterface](Headzoo-CoinTalk-HTTPInterface.md)



### Headzoo\CoinTalk\HTTPInterface::setUrl
Sets the url to request


```php
public Headzoo\CoinTalk\HTTPInterface Headzoo\CoinTalk\HTTPInterface::setUrl(string $url)
```

* This method is defined by [Headzoo\CoinTalk\HTTPInterface](Headzoo-CoinTalk-HTTPInterface.md)

##### Arguments

* $url **string** - The request url



### Headzoo\CoinTalk\HTTPInterface::setPostData
Sets the post data


```php
public Headzoo\CoinTalk\HTTPInterface Headzoo\CoinTalk\HTTPInterface::setPostData(mixed $post_data)
```

* This method is defined by [Headzoo\CoinTalk\HTTPInterface](Headzoo-CoinTalk-HTTPInterface.md)

##### Arguments

* $post_data **mixed** - The post data



### Headzoo\CoinTalk\HTTPInterface::setContentType
Sets the content type


```php
public Headzoo\CoinTalk\HTTPInterface Headzoo\CoinTalk\HTTPInterface::setContentType(string $content_type)
```

* This method is defined by [Headzoo\CoinTalk\HTTPInterface](Headzoo-CoinTalk-HTTPInterface.md)

##### Arguments

* $content_type **string** - The content type



### Headzoo\CoinTalk\HTTPInterface::setAuthUser
Sets the basic auth username


```php
public Headzoo\CoinTalk\HTTPInterface Headzoo\CoinTalk\HTTPInterface::setAuthUser(string $auth_user)
```

* This method is defined by [Headzoo\CoinTalk\HTTPInterface](Headzoo-CoinTalk-HTTPInterface.md)

##### Arguments

* $auth_user **string** - The username



### Headzoo\CoinTalk\HTTPInterface::setAuthPass
Sets the basic auth password


```php
public Headzoo\CoinTalk\HTTPInterface Headzoo\CoinTalk\HTTPInterface::setAuthPass(string $auth_pass)
```

* This method is defined by [Headzoo\CoinTalk\HTTPInterface](Headzoo-CoinTalk-HTTPInterface.md)

##### Arguments

* $auth_pass **string** - The password



### Headzoo\CoinTalk\HTTPInterface::getStatusCode
Returns the status code returned by the server


```php
public int Headzoo\CoinTalk\HTTPInterface::getStatusCode()
```

* This method is defined by [Headzoo\CoinTalk\HTTPInterface](Headzoo-CoinTalk-HTTPInterface.md)


