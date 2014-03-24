<?php
namespace Headzoo\Bitcoin\Wallet\Api;

/**
 * Interface for classes which make http post requests.
 */
interface HTTPInterface
{
    /**
     * Sends the request and returns the response
     *
     * @return string
     * @throws Exceptions\HTTPException If the request generates an error
     */
    public function request();

    /**
     * Sets the url to request
     *
     * @param  string $url The request url
     * @return $this
     */
    public function setUrl($url);

    /**
     * Sets the post data
     *
     * @param  mixed $post_data The post data
     * @return $this
     */
    public function setPostData($post_data);

    /**
     * Sets the content type
     *
     * @param  string $content_type The content type
     * @return $this
     */
    public function setContentType($content_type);

    /**
     * Sets the basic auth username
     *
     * @param  string $auth_user The username
     * @return $this
     */
    public function setAuthUser($auth_user);

    /**
     * Sets the basic auth password
     *
     * @param  string $auth_pass The password
     * @return $this
     */
    public function setAuthPass($auth_pass);

    /**
     * Returns the status code returned by the server
     *
     * @return int
     */
    public function getStatusCode();
} 