<?php
use Headzoo\CoinTalk\JsonRPC;

/**
 * Test needs a running instance of bitcoind/bitcoin-qt or any other coin server.
 */
class JsonRPCTest
    extends PHPUnit_Framework_TestCase
{
    /**
     * Wallet configuration
     * @var array
     */
    protected $conf = [];
    
    /**
     * The test fixture
     * @var JsonRPC
     */
    protected $rpc;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->conf = include(__DIR__ . "/conf.php");
        $this->rpc  = new JsonRPC();
    }

    /**
     * @covers Headzoo\CoinTalk\JsonRPC::query
     */
    public function testQuery()
    {
        $this->rpc->setConf($this->conf["wallet1"]);
        $response = $this->rpc->query("getinfo");
        $this->assertTrue(isset($response["version"]));
    }

    /**
     * @covers Headzoo\CoinTalk\JsonRPC::query
     * @expectedException Headzoo\CoinTalk\MethodNotFoundException
     */
    public function testQuery_MethodNotFoundException()
    {
        $this->rpc->setConf($this->conf["wallet1"]);
        $this->rpc->query("badmethod");
    }
    
    /**
     * @covers Headzoo\CoinTalk\JsonRPC::query
     * @expectedException Headzoo\CoinTalk\AuthenticationException
     */
    public function testQuery_AuthenticationException()
    {
        $this->conf["wallet1"]["user"] = "wrong";
        $this->rpc->setConf($this->conf["wallet1"]);
        $this->rpc->query("getinfo");
    }

    /**
     * @covers Headzoo\CoinTalk\JsonRPC::query
     * @expectedException Headzoo\CoinTalk\RPCException
     */
    public function testQuery_RPCException_Path()
    {
        $this->conf["wallet1"]["host"] = "localhost/wrong";
        $this->rpc->setConf($this->conf["wallet1"]);
        $this->rpc->query("getinfo");
    }

    /**
     * @covers Headzoo\CoinTalk\JsonRPC::query
     * @expectedException Headzoo\CoinTalk\HTTPException
     */
    public function testQuery_HttpException_Port()
    {
        $this->conf["wallet1"]["port"] = 6545;
        $this->rpc->setConf($this->conf["wallet1"]);
        $this->rpc->query("getinfo");
    }
}
