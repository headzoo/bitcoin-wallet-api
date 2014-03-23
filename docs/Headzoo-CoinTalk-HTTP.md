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



```
protected string $url
```



### $status_code
The http status code returned by the requested server



```
protected int $status_code = 200
```



### $post_data
The post data



```
protected mixed $post_data
```



### $content_type
The content type



```
protected string $content_type = "text/html"
```



### $auth_user
The basic auth username



```
protected string $auth_user
```



### $auth_pass
The basic auth password



```
protected string $auth_pass
```



Methods
-------


### Headzoo\CoinTalk\HTTP::__construct
Constructor



```
public mixed Headzoo\CoinTalk\HTTP::Headzoo\CoinTalk\HTTP::__construct(string $url)
```


#### Arguments

* $url **string** - The url to request



### Headzoo\CoinTalk\HTTP::request
Sends the request and returns the response



```
public mixed Headzoo\CoinTalk\HTTP::Headzoo\CoinTalk\HTTP::request()
```




### Headzoo\CoinTalk\HTTP::setUrl
Sets the url to request



```
public mixed Headzoo\CoinTalk\HTTP::Headzoo\CoinTalk\HTTP::setUrl($url)
```


#### Arguments

* $url **mixed**



### Headzoo\CoinTalk\HTTP::setPostData
Sets the post data



```
public mixed Headzoo\CoinTalk\HTTP::Headzoo\CoinTalk\HTTP::setPostData($post_data)
```


#### Arguments

* $post_data **mixed**



### Headzoo\CoinTalk\HTTP::setContentType
Sets the content type



```
public mixed Headzoo\CoinTalk\HTTP::Headzoo\CoinTalk\HTTP::setContentType($content_type)
```


#### Arguments

* $content_type **mixed**



### Headzoo\CoinTalk\HTTP::setAuthUser
Sets the basic auth username



```
public mixed Headzoo\CoinTalk\HTTP::Headzoo\CoinTalk\HTTP::setAuthUser($auth_user)
```


#### Arguments

* $auth_user **mixed**



### Headzoo\CoinTalk\HTTP::setAuthPass
Sets the basic auth password



```
public mixed Headzoo\CoinTalk\HTTP::Headzoo\CoinTalk\HTTP::setAuthPass($auth_pass)
```


#### Arguments

* $auth_pass **mixed**



### Headzoo\CoinTalk\HTTP::getStatusCode
Returns the status code returned by the server



```
public mixed Headzoo\CoinTalk\HTTP::Headzoo\CoinTalk\HTTP::getStatusCode()
```




### Headzoo\CoinTalk\HTTPInterface::request
Sends the request and returns the response



```
public string Headzoo\CoinTalk\HTTPInterface::Headzoo\CoinTalk\HTTPInterface::request()
```

* This method is defined by [Headzoo\CoinTalk\HTTPInterface](Headzoo-CoinTalk-HTTPInterface.md)



### Headzoo\CoinTalk\HTTPInterface::setUrl
Sets the url to request



```
public Headzoo\CoinTalk\HTTPInterface Headzoo\CoinTalk\HTTPInterface::Headzoo\CoinTalk\HTTPInterface::setUrl(string $url)
```

* This method is defined by [Headzoo\CoinTalk\HTTPInterface](Headzoo-CoinTalk-HTTPInterface.md)

#### Arguments

* $url **string** - The request url



### Headzoo\CoinTalk\HTTPInterface::setPostData
Sets the post data



```
public Headzoo\CoinTalk\HTTPInterface Headzoo\CoinTalk\HTTPInterface::Headzoo\CoinTalk\HTTPInterface::setPostData(mixed $post_data)
```

* This method is defined by [Headzoo\CoinTalk\HTTPInterface](Headzoo-CoinTalk-HTTPInterface.md)

#### Arguments

* $post_data **mixed** - The post data



### Headzoo\CoinTalk\HTTPInterface::setContentType
Sets the content type



```
public Headzoo\CoinTalk\HTTPInterface Headzoo\CoinTalk\HTTPInterface::Headzoo\CoinTalk\HTTPInterface::setContentType(string $content_type)
```

* This method is defined by [Headzoo\CoinTalk\HTTPInterface](Headzoo-CoinTalk-HTTPInterface.md)

#### Arguments

* $content_type **string** - The content type



### Headzoo\CoinTalk\HTTPInterface::setAuthUser
Sets the basic auth username



```
public Headzoo\CoinTalk\HTTPInterface Headzoo\CoinTalk\HTTPInterface::Headzoo\CoinTalk\HTTPInterface::setAuthUser(string $auth_user)
```

* This method is defined by [Headzoo\CoinTalk\HTTPInterface](Headzoo-CoinTalk-HTTPInterface.md)

#### Arguments

* $auth_user **string** - The username



### Headzoo\CoinTalk\HTTPInterface::setAuthPass
Sets the basic auth password



```
public Headzoo\CoinTalk\HTTPInterface Headzoo\CoinTalk\HTTPInterface::Headzoo\CoinTalk\HTTPInterface::setAuthPass(string $auth_pass)
```

* This method is defined by [Headzoo\CoinTalk\HTTPInterface](Headzoo-CoinTalk-HTTPInterface.md)

#### Arguments

* $auth_pass **string** - The password



### Headzoo\CoinTalk\HTTPInterface::getStatusCode
Returns the status code returned by the server



```
public int Headzoo\CoinTalk\HTTPInterface::Headzoo\CoinTalk\HTTPInterface::getStatusCode()
```

* This method is defined by [Headzoo\CoinTalk\HTTPInterface](Headzoo-CoinTalk-HTTPInterface.md)


