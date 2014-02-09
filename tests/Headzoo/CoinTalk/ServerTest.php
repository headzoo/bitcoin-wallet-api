<?php
use Headzoo\CoinTalk\Server;

/**
 * Test needs a running instance of bitcoind/bitcoin-qt or any other coin server.
 */
class ServerTest
    extends PHPUnit_Framework_TestCase
{
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
        $this->fixture = new Server();
    }

    /**
     * @covers Headzoo\CoinTalk\Server::query
     */
    public function testQuery()
    {
        $conf = [
            "user" => "test",
            "pass" => "test",
            "host" => "localhost",
            "port" => 9352
        ];
        $this->fixture->setConf($conf);
        $response = $this->fixture->query("getinfo");
        $this->assertTrue(isset($response["version"]));
    }

    /**
     * @covers Headzoo\CoinTalk\Server::query
     * @expectedException Headzoo\CoinTalk\AuthenticationException
     */
    public function testQuery_AuthenticationException()
    {
        $conf = [
            "user" => "wrong",
            "pass" => "wrong",
            "host" => "localhost",
            "port" => 9352
        ];
        $this->fixture->setConf($conf);
        $this->fixture->query("getinfo");
    }

    /**
     * @covers Headzoo\CoinTalk\Server::query
     * @expectedException Headzoo\CoinTalk\HttpException
     */
    public function testQuery_HttpException_Path()
    {
        $conf = [
            "user" => "test",
            "pass" => "test",
            "host" => "localhost/wrong",
            "port" => 9352
        ];
        $this->fixture->setConf($conf);
        $this->fixture->query("getinfo");
    }

    /**
     * @covers Headzoo\CoinTalk\Server::query
     * @expectedException Headzoo\CoinTalk\HttpException
     */
    public function testQuery_HttpException_Port()
    {
        $conf = [
            "user" => "test",
            "pass" => "test",
            "host" => "localhost",
            "port" => 9352
        ];
        $this->fixture->setConf($conf);
        $this->fixture->query("getinfo");
    }
}
