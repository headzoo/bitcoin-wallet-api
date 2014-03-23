<?php
use Headzoo\Bitcoin\Wallet\Api\Wallet;
use Headzoo\Bitcoin\Wallet\Api\JsonRPC;

class WalletTest
    extends PHPUnit_Framework_TestCase
{
    /**
     * Wallet configuration
     * @var array
     */
    protected $conf = [];

    
    /**
     * The test fixture
     * @var Wallet
     */
    protected $wallet;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->conf = include(__DIR__ . "/conf.php");
        $rpc  = new JsonRPC($this->conf["wallet1"]);
        $this->wallet = new Wallet($rpc);
        $this->wallet->unlock("Fatty7Boom6Boom", 5);
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\Wallet::getInfo
     */
    public function testGetInfo()
    {
        $this->assertArrayHasKey(
            "version",
            $this->wallet->getInfo()
        );
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\Wallet::getConnectionCount
     */
    public function testGetConnectionCount()
    {
        $this->assertGreaterThan(0, $this->wallet->getConnectionCount());
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\Wallet::getDifficulty
     */
    public function testGetDifficulty()
    {
        $this->assertGreaterThan(0, $this->wallet->getDifficulty());
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\Wallet::getGenerate
     */
    public function testGetGenerate()
    {
        $this->assertFalse($this->wallet->getGenerate());
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\Wallet::getHashesPerSec
     */
    public function testGetHashesPerSec()
    {
        $this->assertEquals(0, $this->wallet->getHashesPerSec());
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\Wallet::getMiningInfo
     */
    public function testGetMiningInfo()
    {
        $this->assertArrayHasKey(
            "blocks",
            $this->wallet->getInfo()
        );
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\Wallet::getPeerInfo
     */
    public function testGetPeerInfo()
    {
        $this->assertArrayHasKey(
            "addr",
            $this->wallet->getPeerInfo()[0]
        );
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\Wallet::getBestBlockHash
     */
    public function testGetBestBlockHash()
    {
        $this->assertNotEmpty($this->wallet->getBestBlockHash());
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\Wallet::getBlockCount
     */
    public function testGetBlockCount()
    {
        $this->assertGreaterThan(0, $this->wallet->getBlockCount());
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\Wallet::setTransactionFee
     */
    public function testSetTransactionFee()
    {
        $this->assertTrue($this->wallet->setTransactionFee(0.001));
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\Wallet::setGenerate
     */
    public function testSetGenerate()
    {
        $this->assertTrue($this->wallet->setGenerate(false));
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\Wallet::addNode
     * @covers Headzoo\Bitcoin\Wallet\Api\Wallet::getNodeInfo
     */
    public function testAddNode()
    {
        $this->assertTrue($this->wallet->addNode("127.0.0.1:8333", "add"));
        $this->assertArrayHasKey(
            "addednode",
            $this->wallet->getNodeInfo(true, "127.0.0.1:8333")[0]
        );
        $this->assertTrue($this->wallet->addNode("127.0.0.1:8333", "remove"));
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\Wallet::signMessage
     */
    public function testSignMessage()
    {
        $this->assertNotEmpty(
            $this->wallet->signMessage(
                "1Headz2mYtpBRo6KFaaUEtcm5Kce6BZRJM", 
                "Mary had a little lamb."
            )
        );
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\Wallet::signRawTransaction
     */
    public function testSignRawTransaction()
    {
        $raw = "0100000001c7e319d1b6e125d7be6b995760d02b5824a9c1b76ea88082768e343bcba3d475000000008a47304402201866903fdaed93e75d1ada2680128bf48daea3f9fb1c681881dd0f3db4587e1602206dadd99061866ee9a654da0b963380bb5be4a2a248a6d4bf8bb0422e537f46bb0141040683ab781ddb83f9ba6328def8d718ee122883ab1dfb094a66dc9ea5f05f54b691c69357eb22c9eb3d4de49167da040ef1a9991b4bf14a74ecf193847ad392b8ffffffff02804f1200000000001976a914b95d01e0785092de71b80f68a43f0d2d55b81ca788ac30852700000000001976a91494537b703662474c26412f0d00aed590aebc9fe588ac00000000";
        $this->assertArrayHasKey(
            "hex",
            $this->wallet->signRawTransaction($raw)
        );
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\Wallet::isSignedMessageValid
     */
    public function testIsSignedMessageValid()
    {
        $sig = $this->wallet->signMessage(
            "1Headz2mYtpBRo6KFaaUEtcm5Kce6BZRJM",
            "Mary had a little lamb."
        );

        $this->assertTrue(
            $this->wallet->isSignedMessageValid(
                "1Headz2mYtpBRo6KFaaUEtcm5Kce6BZRJM",
                $sig,
                "Mary had a little lamb."
            )
        );
        $this->assertFalse(
            $this->wallet->isSignedMessageValid(
                "1Headz2mYtpBRo6KFaaUEtcm5Kce6BZRJM",
                $sig,
                "Mary had a little horse."
            )
        );
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\Wallet::getBalance
     */
    public function testGetBalance()
    {
        $this->assertNotEquals(0.0, $this->wallet->getBalance());
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\Wallet::getBalances
     */
    public function testGetBalances()
    {
        $this->assertArrayHasKey(
            "address",
            $this->wallet->getBalances()[0]
        );
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\Wallet::getBalanceByAccount
     */
    public function testGetBalanceByAccount()
    {
        $this->assertGreaterThan(0, $this->wallet->getBalanceByAccount("Personal"));
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\Wallet::getBalanceByAddress
     */
    public function testGetBalanceByAddress()
    {
        $this->assertGreaterThan(0, $this->wallet->getBalanceByAddress("1JBKAM8W9jEnuGNvPRFjtpmeDGvfQx6PLU"));
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\Wallet::getAccounts
     */
    public function testGetAccounts()
    {
        $this->assertContains(
            "Personal",
            $this->wallet->getAccounts()
        );
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\Wallet::setAccount
     */
    public function testSetAccount()
    {
        $this->assertTrue(
            $this->wallet->setAccount("19tjsa4nBeAtn48kcmW9Gg2wRFtm24GRG2", "Personal")
        );
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\Wallet::getAccountByAddress
     */
    public function testGetAccountByAddress()
    {
        $this->assertEquals(
            "Personal",
            $this->wallet->getAccountByAddress("1JBKAM8W9jEnuGNvPRFjtpmeDGvfQx6PLU")
        );
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\Wallet::getAddresses
     */
    public function testGetAddresses()
    {
        $this->assertNotEmpty(
            $this->wallet->getAddresses()
        );
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\Wallet::getAddressByAccount
     */
    public function testGetAddressByAccount()
    {
        $this->assertNotEmpty(
            $this->wallet->getAddressByAccount("Personal")
        );
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\Wallet::getAddressesByAccount
     */
    public function testGetAddressesByAccount()
    {
        $this->assertNotEmpty(
            $this->wallet->getAddressesByAccount("Personal")
        );
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\Wallet::getRawChangeAddress
     */
    public function testGetRawChangeAddress()
    {
        $this->assertNotEmpty(
            $this->wallet->getRawChangeAddress("Personal")
        );
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\Wallet::getNewAddress
     */
    public function testGetNewAddress()
    {
        $this->assertNotEmpty(
            $this->wallet->getNewAddress("Personal")
        );
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\Wallet::getAddressInfo
     */
    public function testGetAddressInfo()
    {
        $this->assertTrue($this->wallet->getAddressInfo("1Headz2mYtpBRo6KFaaUEtcm5Kce6BZRJM")["isvalid"]);
        $this->assertFalse($this->wallet->getAddressInfo("1eadz2mYtpBRo6KFaaUEtcm5Kce6BZRJM")["isvalid"]);
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\Wallet::getPrivateKeyByAddress
     */
    public function testGetPrivateKeyByAddress()
    {
        $this->assertNotEmpty(
            $this->wallet->getPrivateKeyByAddress("1Headz2mYtpBRo6KFaaUEtcm5Kce6BZRJM")
        );
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\Wallet::getBlock
     */
    public function testGetBlock()
    {
        $this->assertArrayHasKey(
            "hash",
            $this->wallet->getBlock("000000006a625f06636b8bb6ac7b960a8d03705d1ace08b1a19da3fdcc99ddbd")
        );
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\Wallet::getBlockHash
     */
    public function testGetBlockHash()
    {
        $this->assertEquals(
            "000000006a625f06636b8bb6ac7b960a8d03705d1ace08b1a19da3fdcc99ddbd",
            $this->wallet->getBlockHash(2)
        );
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\Wallet::getTransaction
     */
    public function testGetTransaction()
    {
        $this->assertArrayHasKey(
            "amount",
            $this->wallet->getTransaction("b8a4c517709f0724a6d14115712f055b54225d9be9c889c0e141939153d97f38")
        );
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\Wallet::getTransactions
     */
    public function testGetTransactions()
    {
        $this->assertNotEmpty(
            $this->wallet->getTransactions("Personal")
        );
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\Wallet::getTransactionsFromMemoryPool
     */
    public function testGetTransactionsFromMemoryPool()
    {
        $this->assertNotEmpty(
            $this->wallet->getTransactionsFromMemoryPool("Personal")
        );
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\Wallet::getBlockTemplate
     */
    public function testGetBlockTemplate()
    {
        $this->assertArrayHasKey(
            "previousblockhash",
            $this->wallet->getBlockTemplate(["longpoll"])
        );
    }

    /**
     * @covers Headzoo\Bitcoin\Wallet\Api\Wallet::getWork
     */
    public function testGetWork()
    {
        $this->assertArrayHasKey(
            "midstate",
            $this->wallet->getWork()
        );
    }
}
