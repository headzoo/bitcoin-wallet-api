<?php
namespace Headzoo\CoinTalk;

/**
 * Used to make http post requests.
 */
class HTTP
{
    /**
     * The url to request
     * @var string
     */
    protected $url;

    /**
     * The http status code returned by the requested server
     * @var int
     */
    protected $status_code = 200;

    /**
     * The post data
     * @var mixed
     */
    protected $post_data;

    /**
     * The content type
     * @var string
     */
    protected $content_type = "text/html";

    /**
     * The basic auth username
     * @var string
     */
    protected $auth_user;

    /**
     * The basic auth password
     * @var string
     */
    protected $auth_pass;

    /**
     * Constructor
     * 
     * @param string $url The url to request
     */
    public function __construct($url)
    {
        $this->setUrl($url);
    }

    /**
     * Sends the request and returns the response
     * 
     * @return string
     * @throws HTTPException If the request generates an error
     */
    public function request()
    {
        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,    1);
        curl_setopt($ch, CURLOPT_POST,              1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,        $this->post_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER,        ["Content-Type: {$this->content_type}"]);
        if ($this->auth_user && $this->auth_pass) {
            curl_setopt($ch, CURLOPT_USERPWD, "{$this->auth_user}:{$this->auth_pass}");
        }
        
        $response = curl_exec($ch);
        $this->status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (false === $response) {
            $error = curl_error($ch);
            $code  = curl_errno($ch);
            curl_close($ch);
            throw new HTTPException($error, $code);
        }
        curl_close($ch);
        
        return $response;
    }

    /**
     * Sets the url to request
     * 
     * @param  string $url The request url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = (string)$url;
        return $this;
    }
    
    /**
     * Sets the post data
     * 
     * @param  mixed $post_data The post data
     * @return $this
     */
    public function setPostData($post_data)
    {
        $this->post_data = $post_data;
        return $this;
    }

    /**
     * Sets the content type
     * 
     * @param  string $content_type The content type
     * @return $this
     */
    public function setContentType($content_type)
    {
        $this->content_type = (string)$content_type;
        return $this;
    }

    /**
     * Sets the basic auth username
     * 
     * @param  string $auth_user The username
     * @return $this
     */
    public function setAuthUser($auth_user)
    {
        $this->auth_user = (string)$auth_user;
        return $this;
    }

    /**
     * Sets the basic auth password
     * 
     * @param  string $auth_pass The password
     * @return $this
     */
    public function setAuthPass($auth_pass)
    {
        $this->auth_pass = (string)$auth_pass;
        return $this;
    }

    /**
     * Returns the status code returned by the server
     * 
     * @return int
     */
    public function getStatusCode()
    {
        return $this->status_code;
    }
} 