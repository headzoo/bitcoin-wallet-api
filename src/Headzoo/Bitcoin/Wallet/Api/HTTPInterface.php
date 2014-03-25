<?php
namespace Headzoo\Bitcoin\Wallet\Api;
use InvalidArgumentException;

/**
 * Interface for classes which make http post requests.
 */
interface HTTPInterface
{
    /**
     * Get request method
     */
    const METHOD_GET = "GET";

    /**
     * Post request method
     */
    const METHOD_POST = "POST";
    
    /**
     * Sends the request and returns the response
     *
     * @param  string $url The url to request
     * @return string
     * @throws Exceptions\HTTPException If the request generates an error
     */
    public function request($url);

    /**
     * Sets the request method
     * 
     * Should be one of HTTPInterface::METHOD_GET or HTTPInterface::METHOD_POST.
     * 
     * @param  string $method The request method
     * @return mixed
     * @throws InvalidArgumentException If $method is not one of the METHOD constants
     */
    public function setMethod($method);

    /**
     * Sets the get/post data
     *
     * How the data is handled depends on the request method, and the data type.
     * If data is an array, it will be passed through the http_build_query() function, and the return value will be
     * appended to the request url for GET request, and set as raw data for POST request. If data is a string, it will
     * be appended as-is to the request url for GET requests, and used as-is for POST requests.
     * 
     * The request content type will be automatically set to "multipart/form-data" if $data is an array, and the
     * request method is POST.
     * 
     * To post a file, prepend a filename with @ and use the full path, eg "@/home/headz/image.jpg".
     * 
     * Example:
     * ```php
     * $http = new HTTP(HTTP::METHOD_GET);
     * $http->setData("name=headz&job=programmer");
     * $http->request("http://example.com");
     * 
     * // The request will be made using the url "http://example.com?name=headz&job=programmer".
     *
     * $http = new HTTP(HTTP::METHOD_GET);
     * $http->setData(["name" => "headz", "job" => "programmer"]);
     * $http->request("http://example.com");
     *
     * // The request will be made using the url "http://example.com?name=headz&job=programmer".
     * 
     * $http = new HTTP(HTTP::METHOD_POST);
     * $http->setData("{'name':'headz', 'job':'programmer'}");
     * $http->request("http://example.com");
     *
     * // The request will be made using the url "http://example.com" with the raw post
     * // data "{'name':'headz', 'job':'programmer'}".
     * 
     * $http = new HTTP(HTTP::METHOD_POST);
     * $http->setData(["name" => "headz", "job" => "programmer"]);
     * $http->request("http://example.com");
     * 
     * // The request will be made using the url "http://example.com", the content type "multipart/form-data", and
     * // the POST data "name=headz&job=programmer".
     * ```
     * 
     * @param  string|array $data The get/post data
     * @return $this
     */
    public function setData($data);

    /**
     * Sets the content type
     *
     * @param  string $content_type The content type
     * @return $this
     */
    public function setContentType($content_type);

    /**
     * Sets the basic auth username and password
     *
     * @param  string $user The username
     * @param  string $pass The password
     * @return $this
     */
    public function setBasicAuth($user, $pass);

    /**
     * Returns the status code returned by the server
     *
     * @return int
     */
    public function getStatusCode();
} 