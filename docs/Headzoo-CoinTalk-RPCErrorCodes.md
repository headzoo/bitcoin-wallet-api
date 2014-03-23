Headzoo\CoinTalk\RPCErrorCodes
===============

Codes for various errors returned by the api.




* Class name: RPCErrorCodes
* Namespace: Headzoo\CoinTalk



Constants
----------


### INVALID_REQUEST
Standard error


```php
const INVALID_REQUEST = -32600
```





### METHOD_NOT_FOUND
The rpc method does not exist


```php
const METHOD_NOT_FOUND = -32601
```





### INVALID_PARAMS
The rpc parameters are invalid


```php
const INVALID_PARAMS = -32602
```





### INTERNAL_ERROR
Internal error


```php
const INTERNAL_ERROR = -32603
```





### PARSE_ERROR
An rpc request parsing error


```php
const PARSE_ERROR = -32700
```





### MISC_ERROR
std::exception thrown in command handling


```php
const MISC_ERROR = -1
```





### FORBIDDEN_BY_SAFE_MODE
Server is in safe mode, and command is not allowed in safe mode


```php
const FORBIDDEN_BY_SAFE_MODE = -2
```





### TYPE_ERROR
Unexpected type was passed as parameter


```php
const TYPE_ERROR = -3
```





### INVALID_ADDRESS_OR_KEY
Invalid address or key


```php
const INVALID_ADDRESS_OR_KEY = -5
```





### OUT_OF_MEMORY
Ran out of memory during operation


```php
const OUT_OF_MEMORY = -7
```





### INVALID_PARAMETER
Invalid, missing or duplicate parameter


```php
const INVALID_PARAMETER = -8
```





### DATABASE_ERROR
Database error


```php
const DATABASE_ERROR = -20
```





### DESERIALIZATION_ERROR
Error parsing or validating structure in raw format


```php
const DESERIALIZATION_ERROR = -22
```





### CLIENT_NOT_CONNECTED
Bitcoin is not connected


```php
const CLIENT_NOT_CONNECTED = -9
```





### CLIENT_IN_INITIAL_DOWNLOAD
Still downloading initial blocks


```php
const CLIENT_IN_INITIAL_DOWNLOAD = -10
```





### CLIENT_NODE_ALREADY_ADDED
Node is already added


```php
const CLIENT_NODE_ALREADY_ADDED = -23
```





### CLIENT_NODE_NOT_ADDED
Node has not been added before


```php
const CLIENT_NODE_NOT_ADDED = -24
```





### WALLET_ERROR
Unspecified problem with wallet (key not found etc.)


```php
const WALLET_ERROR = -4
```





### WALLET_INSUFFICIENT_FUNDS
Not enough funds in wallet or account


```php
const WALLET_INSUFFICIENT_FUNDS = -6
```





### WALLET_INVALID_ACCOUNT_NAME
Invalid account name


```php
const WALLET_INVALID_ACCOUNT_NAME = -11
```





### WALLET_KEYPOOL_RAN_OUT
Keypool ran out, call fillKeyPool() first


```php
const WALLET_KEYPOOL_RAN_OUT = -12
```





### WALLET_UNLOCK_NEEDED
Enter the wallet passphrase with unlock() first


```php
const WALLET_UNLOCK_NEEDED = -13
```





### WALLET_PASSPHRASE_INCORRECT
The wallet passphrase entered was incorrect


```php
const WALLET_PASSPHRASE_INCORRECT = -14
```





### WALLET_WRONG_ENC_STATE
Command given in wrong wallet encryption state (encrypting an encrypted wallet etc.)


```php
const WALLET_WRONG_ENC_STATE = -15
```





### WALLET_ENCRYPTION_FAILED
Failed to encrypt the wallet


```php
const WALLET_ENCRYPTION_FAILED = -16
```





### WALLET_ALREADY_UNLOCKED
Wallet is already unlocked


```php
const WALLET_ALREADY_UNLOCKED = -17
```








