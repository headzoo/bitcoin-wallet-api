<?php
use Headzoo\CoinTalk\Api,
    Headzoo\CoinTalk\Server;

/**
 * Test needs a running instance of bitcoind/bitcoin-qt or any other coin server.
 */
class ApiTest
    extends PHPUnit_Framework_TestCase
{
    /**
     * The test fixture
     * @var Api
     */
    protected $fixture;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $conf = [
            "user" => "test",
            "pass" => "test",
            "host" => "localhost",
            "port" => 9352
        ];
        $server = new Server($conf);
        $this->fixture = new Api($server);
    }

    /**
     * @covers Headzoo\CoinTalk\Api::getInfo
     */
    public function testGetInfo()
    {
        $info = $this->fixture->getInfo();
        $this->assertTrue(isset($info["version"]));
    }

    /**
     * @covers Headzoo\CoinTalk\Api::getBlockCount
     */
    public function testGetBlockCount()
    {
        $count = $this->fixture->getBlockCount();
        $this->assertGreaterThan(0, $count);
    }

    /**
     * @covers Headzoo\CoinTalk\Api::getBlockHash
     */
    public function testGetBlockHash()
    {
        $hash = $this->fixture->getBlockHash(1);
        $this->assertNotEmpty($hash);
    }

    /**
     * @covers Headzoo\CoinTalk\Api::listAccounts
     */
    public function testListAccounts()
    {
        $accounts = $this->fixture->listAccounts();
        $this->assertNotEmpty($accounts);
    }
} 