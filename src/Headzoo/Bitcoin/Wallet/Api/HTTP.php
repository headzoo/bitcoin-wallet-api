<?php
namespace Headzoo\Bitcoin\Wallet\Api;
use InvalidArgumentException;

/**
 * Used to make http requests.
 * 
 * Example:
 * ```php
 *  $http = new HTTP("127.0.0.1:8333");
 *  $http
 *      ->setMethod(HTTP::METHOD_POST)
 *      ->setContentType("application/json")
 *      ->setBasicAuth("test_user", "test_pass")
 *      ->setData("{'method':'getinfo','params':[],'id':11532}");
 * $response = $http->request();
 * $status   = $http->getStatusCode();
 * ```
 */
class HTTP
    implements HTTPInterface
{
    /**
     * The http status code returned by the requested server
     * @var int
     */
    protected $status_code = 200;

    /**
     * The request method
     * @var string
     */
    protected $method = self::METHOD_GET;
    
    /**
     * The get/post data
     * @var mixed
     */
    protected $data;

    /**
     * The content type
     * @var string
     */
    protected $content_type = "text/html";

    /**
     * The basic auth username and password
     * @var array
     */
    protected $auth = [];

    /**
     * Constructor
     * 
     * @param string $method The request method, one of HTTP::METHOD_GET or HTTP::METHOD_POST
     */
    public function __construct($method = self::METHOD_GET)
    {
        $this->setMethod($method);
    }
    
    /**
     * {@inheritDoc}
     */
    public function request($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER,     ["Content-Type: {$this->content_type}"]);
        
        if ($this->method === self::METHOD_POST) {
            curl_setopt($ch, CURLOPT_POST, true);
        }
        if (!empty($this->auth)) {
            curl_setopt(
                $ch,
                CURLOPT_USERPWD,
                sprintf("%s:%s", $this->auth["user"], $this->auth["pass"])
            );
        }
        
        $query = $this->prepareData($url);
        if ($query) {
            if ($this->method === self::METHOD_POST) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
            } else {
                $url = "{$url}{$query}";
            }
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        
        $response = curl_exec($ch);
        $this->status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (false === $response) {
            $error = curl_error($ch);
            $code  = curl_errno($ch);
            curl_close($ch);
            throw new Exceptions\HTTPException($error, $code);
        }
        curl_close($ch);
        
        return $response;
    }

    /**
     * Prepares the GET/POST data for use with the specified url
     * 
     * When the request method is GET, the return value has "?" or "&" prepended to it, depending on whether
     * or not the url already has request parameters.
     * 
     * @param  string $url The request url
     * @return string
     */
    protected function prepareData($url)
    {
        $params = null;
        if (!empty($this->data)) {
            if ($this->method === self::METHOD_GET) {
                if (is_array($this->data)) {
                    $query = http_build_query($this->data);
                } else {
                    $query = $this->data;
                }
                $combine = (strpos($url, "?") === false) ? "?" : "&";
                $params  = "{$combine}{$query}";
            }
        }
        
        return $params;
    }

    /**
     * {@inheritDoc}
     */
    public function setMethod($method)
    {
        if ($method !== self::METHOD_GET && $method !== self::METHOD_POST) {
            throw new InvalidArgumentException(
                "Method must be either 'GET' or 'POST'."
            );
        }
        $this->method = $method;
        
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setContentType($content_type)
    {
        $this->content_type = (string)$content_type;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setBasicAuth($user, $pass)
    {
        $this->auth["user"] = (string)$user;
        $this->auth["pass"] = (string)$pass;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getStatusCode()
    {
        return $this->status_code;
    }
} 