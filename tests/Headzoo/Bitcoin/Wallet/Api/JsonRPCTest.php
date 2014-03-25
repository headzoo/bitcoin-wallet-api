<?php
use Headzoo\Bitcoin\Wallet\Api\JsonRPC;
use Headzoo\Web\Tools\WebClient;
use Headzoo\Web\Tools\WebResponse;
use Headzoo\Web\Tools\HttpMethods;
use Headzoo\Bitcoin\Wallet\Api\HTTPStatusCodes;
use Headzoo\Bitcoin\Wallet\Api\RPCErrorCodes;
use Headzoo\Bitcoin\Wallet\Api\Exceptions;


class WebClientTester
    extends  WebClient
{
    private $conf;
    protected $data = [];
    
    public function __construct(array $conf)
    {
        parent::__construct();
        $this->conf = $conf;
    }
    
    public function request($url)
    {
        $this->data["url"] = $url;
        if ($this->data["auth_user"] != $this->conf["user"] || $this->data["auth_pass"] != $this->conf["pass"]) {
            throw new Exceptions\AuthenticationException(
                "Error",
                RPCErrorCodes::WALLET_PASSPHRASE_INCORRECT
            );
        } else if (strpos($this->data["post_data"], "badmethod") !== false) {
            throw new Exceptions\MethodNotFoundException(
                "Error",
                RPCErrorCodes::METHOD_NOT_FOUND
            );
        } else if (strpos($this->data["url"], "localhost/wrong") !== false) {
            throw new Exceptions\ForbiddenException(
                "Error",
                HTTPStatusCodes::FORBIDDEN
            );
        } else if (strpos($this->data["post_data"], "invalid_param") !== false) {
            throw new Exceptions\InternalServerErrorException(
                "Error",
                HTTPStatusCodes::INTERNAL_SERVER_ERROR
            );
        } else if (strpos($this->data["post_data"], "bad_id") !== false) {
            throw new Exceptions\IdentityException(
                "Error"
            );
        }

        $data = [
            "time"    => time(),
            "method"  => HttpMethods::POST,
            "version" => "HTTP/1.1",
            "code"    => 200,
            "info"    => [
                "url"       => $url,
                "http_code" => 200
            ]
        ];
        $data["body"] = json_encode([
            "result"          => [
                "version"         => 90000,
                "protocolversion" => 70002,
                "walletversion"   => 60000,
                "balance"         => 6.02730425,
                "blocks"          => 292075,
                "timeoffset"      => -1,
                "connections"     => 65,
                "proxy"           => "",
                "difficulty"      => 4250217919.86953540,
                "testnet"         => false,
                "keypoololdest"   => 1387569300,
                "keypoolsize"     => 101,
                "paytxfee"        => 0,
                "mininput"        => 0.00100000,
                "unlocked_until"  => 0,
                "errors"          => ""
            ],
            "error"               => null,
            "id"                  => "unit_testing"
        ]);
        
        return new WebResponse($data);
    }

    public function setData($post_data)
    {
        $this->data["post_data"] = $post_data;
        return $this;
    }

    public function setBasicAuth($user, $pass)
    {
        $this->data["auth_user"] = $user;
        $this->data["auth_pass"] = $pass;
        return $this;
    }
}

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
        $this->rpc  = new JsonRPC($this->conf["wallet1"], new WebClientTester($this->conf["wallet1"]));
        
        $nonce = $this->getMock('Headzoo\Bitcoin\Wallet\Api\NonceInterface');
        $nonce->expects($this->any())
            ->method("generate")
            ->will($this->returnValue("unit_testing"));
        $this->rpc->setNonce($nonce);
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\JsonRPC::query
     */
    public function testQuery()
    {
        $actual = $this->rpc->query("getInfo");
        $this->assertArrayHasKey(
            "version",
            $actual
        );
        $this->assertEquals(
            "90000",
            $actual["version"]
        );
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\JsonRPC::query
     * @expectedException Headzoo\Bitcoin\Wallet\Api\Exceptions\MethodNotFoundException
     */
    public function testQuery_MethodNotFoundException()
    {
        $this->rpc->setConf($this->conf["wallet1"]);
        $this->rpc->query("badmethod");
    }
    
    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\JsonRPC::query
     * @expectedException Headzoo\Bitcoin\Wallet\Api\Exceptions\AuthenticationException
     */
    public function testQuery_AuthenticationException()
    {
        $this->conf["wallet1"]["user"] = "wrong";
        $this->rpc->setConf($this->conf["wallet1"]);
        $this->rpc->query("getInfo");
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\JsonRPC::query
     * @expectedException Headzoo\Bitcoin\Wallet\Api\Exceptions\ForbiddenException
     */
    public function testQuery_ForbiddenException()
    {
        $this->conf["wallet1"]["host"] = "localhost/wrong";
        $this->rpc->setConf($this->conf["wallet1"]);
        $this->rpc->query("getInfo");
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\JsonRPC::query
     * @expectedException Headzoo\Bitcoin\Wallet\Api\Exceptions\InternalServerErrorException
     */
    public function testQuery_InternalServerErrorException()
    {
        $this->rpc->query("getInfo", ["invalid_param"]);
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\JsonRPC::query
     * @expectedException Headzoo\Bitcoin\Wallet\Api\Exceptions\IdentityException
     */
    public function testQuery_IdentityException()
    {
        $nonce = $this->getMock('Headzoo\Bitcoin\Wallet\Api\NonceInterface');
        $nonce->expects($this->any())
            ->method("generate")
            ->will($this->returnValue("bad_id"));
        $this->rpc->setNonce($nonce);
        $this->rpc->query("getInfo");
    }
}
