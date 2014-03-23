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

* Visibility: **protected**


### $status_code
The http status code returned by the requested server



```
protected int $status_code = 200
```

* Visibility: **protected**


### $post_data
The post data



```
protected mixed $post_data
```

* Visibility: **protected**


### $content_type
The content type



```
protected string $content_type = "text/html"
```

* Visibility: **protected**


### $auth_user
The basic auth username



```
protected string $auth_user
```

* Visibility: **protected**


### $auth_pass
The basic auth password



```
protected string $auth_pass
```

* Visibility: **protected**


Methods
-------


### Headzoo\CoinTalk\HTTP::__construct
Constructor



```
mixed Headzoo\CoinTalk\HTTP::Headzoo\CoinTalk\HTTP::__construct(string $url)
```

* Visibility: **public**

#### Arguments

* $url **string** - The url to request



### Headzoo\CoinTalk\HTTP::request
Sends the request and returns the response



```
mixed Headzoo\CoinTalk\HTTP::Headzoo\CoinTalk\HTTP::request()
```

* Visibility: **public**



### Headzoo\CoinTalk\HTTP::setUrl
Sets the url to request



```
mixed Headzoo\CoinTalk\HTTP::Headzoo\CoinTalk\HTTP::setUrl($url)
```

* Visibility: **public**

#### Arguments

* $url **mixed**



### Headzoo\CoinTalk\HTTP::setPostData
Sets the post data



```
mixed Headzoo\CoinTalk\HTTP::Headzoo\CoinTalk\HTTP::setPostData($post_data)
```

* Visibility: **public**

#### Arguments

* $post_data **mixed**



### Headzoo\CoinTalk\HTTP::setContentType
Sets the content type



```
mixed Headzoo\CoinTalk\HTTP::Headzoo\CoinTalk\HTTP::setContentType($content_type)
```

* Visibility: **public**

#### Arguments

* $content_type **mixed**



### Headzoo\CoinTalk\HTTP::setAuthUser
Sets the basic auth username



```
mixed Headzoo\CoinTalk\HTTP::Headzoo\CoinTalk\HTTP::setAuthUser($auth_user)
```

* Visibility: **public**

#### Arguments

* $auth_user **mixed**



### Headzoo\CoinTalk\HTTP::setAuthPass
Sets the basic auth password



```
mixed Headzoo\CoinTalk\HTTP::Headzoo\CoinTalk\HTTP::setAuthPass($auth_pass)
```

* Visibility: **public**

#### Arguments

* $auth_pass **mixed**



### Headzoo\CoinTalk\HTTP::getStatusCode
Returns the status code returned by the server



```
mixed Headzoo\CoinTalk\HTTP::Headzoo\CoinTalk\HTTP::getStatusCode()
```

* Visibility: **public**



### Headzoo\CoinTalk\HTTPInterface::request
Sends the request and returns the response



```
string Headzoo\CoinTalk\HTTPInterface::Headzoo\CoinTalk\HTTPInterface::request()
```

* Visibility: **public**
* This method is defined by [Headzoo\CoinTalk\HTTPInterface](Headzoo-CoinTalk-HTTPInterface.md)



### Headzoo\CoinTalk\HTTPInterface::setUrl
Sets the url to request



```
Headzoo\CoinTalk\HTTPInterface Headzoo\CoinTalk\HTTPInterface::Headzoo\CoinTalk\HTTPInterface::setUrl(string $url)
```

* Visibility: **public**
* This method is defined by [Headzoo\CoinTalk\HTTPInterface](Headzoo-CoinTalk-HTTPInterface.md)

#### Arguments

* $url **string** - The request url



### Headzoo\CoinTalk\HTTPInterface::setPostData
Sets the post data



```
Headzoo\CoinTalk\HTTPInterface Headzoo\CoinTalk\HTTPInterface::Headzoo\CoinTalk\HTTPInterface::setPostData(mixed $post_data)
```

* Visibility: **public**
* This method is defined by [Headzoo\CoinTalk\HTTPInterface](Headzoo-CoinTalk-HTTPInterface.md)

#### Arguments

* $post_data **mixed** - The post data



### Headzoo\CoinTalk\HTTPInterface::setContentType
Sets the content type



```
Headzoo\CoinTalk\HTTPInterface Headzoo\CoinTalk\HTTPInterface::Headzoo\CoinTalk\HTTPInterface::setContentType(string $content_type)
```

* Visibility: **public**
* This method is defined by [Headzoo\CoinTalk\HTTPInterface](Headzoo-CoinTalk-HTTPInterface.md)

#### Arguments

* $content_type **string** - The content type



### Headzoo\CoinTalk\HTTPInterface::setAuthUser
Sets the basic auth username



```
Headzoo\CoinTalk\HTTPInterface Headzoo\CoinTalk\HTTPInterface::Headzoo\CoinTalk\HTTPInterface::setAuthUser(string $auth_user)
```

* Visibility: **public**
* This method is defined by [Headzoo\CoinTalk\HTTPInterface](Headzoo-CoinTalk-HTTPInterface.md)

#### Arguments

* $auth_user **string** - The username



### Headzoo\CoinTalk\HTTPInterface::setAuthPass
Sets the basic auth password



```
Headzoo\CoinTalk\HTTPInterface Headzoo\CoinTalk\HTTPInterface::Headzoo\CoinTalk\HTTPInterface::setAuthPass(string $auth_pass)
```

* Visibility: **public**
* This method is defined by [Headzoo\CoinTalk\HTTPInterface](Headzoo-CoinTalk-HTTPInterface.md)

#### Arguments

* $auth_pass **string** - The password



### Headzoo\CoinTalk\HTTPInterface::getStatusCode
Returns the status code returned by the server



```
int Headzoo\CoinTalk\HTTPInterface::Headzoo\CoinTalk\HTTPInterface::getStatusCode()
```

* Visibility: **public**
* This method is defined by [Headzoo\CoinTalk\HTTPInterface](Headzoo-CoinTalk-HTTPInterface.md)


