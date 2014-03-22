<?php
use Headzoo\CoinTalk\Server;

/**
 * Test needs a running instance of bitcoind/bitcoin-qt or any other coin server.
 */
class ServerTest
    extends PHPUnit_Framework_TestCase
{
    /**
     * Wallet configuration
     * @var array
     */
    protected $conf = [];
    
    /**
     * The test fixture
     * @var Server
     */
    protected $fixture;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->conf = include(__DIR__ . "/conf.php");
        $this->fixture = new Server();
    }

    /**
     * @covers Headzoo\CoinTalk\Server::query
     */
    public function testQuery()
    {
        $this->fixture->setConf($this->conf["wallet1"]);
        $response = $this->fixture->query("getinfo");
        $this->assertTrue(isset($response["version"]));
    }

    /**
     * @covers Headzoo\CoinTalk\Server::query
     * @expectedException Headzoo\CoinTalk\MethodNotFoundException
     */
    public function testQuery_MethodNotFoundException()
    {
        $this->fixture->setConf($this->conf["wallet1"]);
        $this->fixture->query("badmethod");
    }
    
    /**
     * @covers Headzoo\CoinTalk\Server::query
     * @expectedException Headzoo\CoinTalk\AuthenticationException
     */
    public function testQuery_AuthenticationException()
    {
        $this->conf["wallet1"]["user"] = "wrong";
        $this->fixture->setConf($this->conf["wallet1"]);
        $this->fixture->query("getinfo");
    }

    /**
     * @covers Headzoo\CoinTalk\Server::query
     * @expectedException Headzoo\CoinTalk\HttpException
     */
    public function testQuery_HttpException_Path()
    {
        $this->conf["wallet1"]["host"] = "localhost/wrong";
        $this->fixture->setConf($this->conf["wallet1"]);
        $this->fixture->query("getinfo");
    }

    /**
     * @covers Headzoo\CoinTalk\Server::query
     * @expectedException Headzoo\CoinTalk\HttpException
     */
    public function testQuery_HttpException_Port()
    {
        $this->conf["wallet1"]["port"] = 6545;
        $this->fixture->setConf($this->conf["wallet1"]);
        $this->fixture->query("getinfo");
    }
}
