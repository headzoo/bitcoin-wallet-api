<?php
use Headzoo\CoinTalk\HTTP;

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
        $this->http = new HTTP($this->conf["wallet1"]["host"] . ":" . $this->conf["wallet1"]["port"]);
        $this->http
            ->setContentType("application/json")
            ->setAuthUser($this->conf["wallet1"]["user"])
            ->setAuthPass($this->conf["wallet1"]["pass"])
            ->setPostData("{\"method\":\"getinfo\",\"params\":[],\"id\":11532}");
    }

    /**
     * @covers Headzoo\CoinTalk\HTTP::request
     */
    public function testRequest()
    {
        $info = $this->http->request();
        $this->assertContains(
            "{\"result\":",
            $info
        );
    }

    /**
     * @covers Headzoo\CoinTalk\HTTP::getStatusCode
     */
    public function testGetStatusCode()
    {
        $this->http->request();
        $this->assertEquals(
            200,
            $this->http->getStatusCode()
        );
    }

    /**
     * @covers Headzoo\CoinTalk\HTTP::request
     * @expectedException Headzoo\CoinTalk\HTTPException
     */
    public function testRequest_HTTPException()
    {
        $this->http->setUrl("badhost");
        $this->http->request();
    }
}
