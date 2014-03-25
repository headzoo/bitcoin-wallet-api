<?php
use Headzoo\Bitcoin\Wallet\Api\HTTP;

class HTTPTest
    extends PHPUnit_Framework_TestCase
{
    /**
     * Wallet configuration
     * @var array
     */
    protected $conf = [];
    
    /**
     * The test fixture
     * @var HTTP
     */
    protected $http;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->conf = include(__DIR__ . "/conf.php");
        $this->http = new HTTP(HTTP::METHOD_POST);
        $this->http
            ->setContentType("application/json")
            ->setBasicAuth($this->conf["wallet1"]["user"], $this->conf["wallet1"]["pass"])
            ->setData("{\"method\":\"getinfo\",\"params\":[],\"id\":11532}");
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\HTTP::request
     */
    public function testRequest()
    {
        $info = $this->http->request($this->conf["wallet1"]["host"] . ":" . $this->conf["wallet1"]["port"]);
        $this->assertContains(
            "{\"result\":",
            $info
        );
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\HTTP::getStatusCode
     */
    public function testGetStatusCode()
    {
        $this->http->request($this->conf["wallet1"]["host"] . ":" . $this->conf["wallet1"]["port"]);
        $this->assertEquals(
            200,
            $this->http->getStatusCode()
        );
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\HTTP::request
     * @expectedException Headzoo\Bitcoin\Wallet\Api\Exceptions\HTTPException
     */
    public function testRequest_HTTPException()
    {
        $this->http->request("bad_host");
    }
}
