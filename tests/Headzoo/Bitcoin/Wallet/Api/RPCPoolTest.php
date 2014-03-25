<?php
use Headzoo\Bitcoin\Wallet\Api\RPCPool,
    Headzoo\Bitcoin\Wallet\Api\JsonRPC;

class RPCPoolTest
    extends PHPUnit_Framework_TestCase
{
    /**
     * The test fixture
     * @var RPCPool
     */
    protected $pool;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->pool = new RPCPool();
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\RPCPool::add
     */
    public function testAdd()
    {
        $server = $this->getMockBuilder(JsonRPC::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->pool->add($server);
        $this->assertEquals(1, $this->pool->count());
        $this->pool->add($server);
        $this->assertEquals(2, $this->pool->count());
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\RPCPool::get
     */
    public function testGet()
    {
        $server1 = $this->getMockBuilder(JsonRPC::class)
            ->disableOriginalConstructor()
            ->getMock();
        $server2 = $this->getMockBuilder(JsonRPC::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->pool->add($server1);
        $this->pool->add($server2);

        $this->assertSame(
            $server1,
            $this->pool->get()
        );
        $this->assertSame(
            $server2,
            $this->pool->get()
        );
        $this->assertSame(
            $server1,
            $this->pool->get()
        );
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\RPCPool::query
     */
    public function testQuery()
    {
        $conf = include(__DIR__ . "/conf.php");
        $server = new JsonRPC($conf["wallet1"]);
        $this->pool->add($server);

        $server = new JsonRPC($conf["wallet2"]);
        $this->pool->add($server);

        $info = $this->pool->query("getinfo");
        $this->assertArrayHasKey(
            "version",
            $info
        );

        $info = $this->pool->query("getinfo");
        $this->assertArrayHasKey(
            "version",
            $info
        );
    }
}
