<?php
namespace Headzoo\Bitcoin\Wallet\Api;

/**
 * Used to make http post requests.
 * 
 * Example:
 * ```php
 *  $http = new HTTP("127.0.0.1:8333");
 *  $http
 *      ->setContentType("application/json")
 *      ->setAuthUser("testuser")
 *      ->setAuthPass("testpass")
 *      ->setPostData("{'method':'getinfo','params':[],'id':11532}");
 * $response = $http->request();
 * $status   = $http->getStatusCode();
 * ```
 */
class HTTP
    implements HTTPInterface
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
    public function __construct($url = null)
    {
        $this->setUrl($url);
    }

    /**
     * {@inheritDoc}
     */
    public function request()
    {
        if (!$this->url) {
            throw new HTTPException("Request URL has not been set.", 1);
        }
        
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
     * {@inheritDoc}
     */
    public function setUrl($url)
    {
        $this->url = (string)$url;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setPostData($post_data)
    {
        $this->post_data = $post_data;
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
    public function setAuthUser($auth_user)
    {
        $this->auth_user = (string)$auth_user;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setAuthPass($auth_pass)
    {
        $this->auth_pass = (string)$auth_pass;
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