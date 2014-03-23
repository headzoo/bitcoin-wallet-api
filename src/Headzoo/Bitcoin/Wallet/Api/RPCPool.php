<?php
namespace Headzoo\Bitcoin\Wallet\Api;

/**
 * Manages a pool of JsonRPCInterface instances
 *
 * Acts as an instance of JsonRPCInterface, which transparently uses a pool of JsonRPCInterface
 * instances to query wallets.
 *
 * Example:
 * ```php
 *  $pool = new RPCPool();
 *  $conf = [
 *      "user" => "test",
 *      "pass" => "pass",
 *      "host" => "localhost",
 *      "port" => 9332
 *  ];
 *  $rpc = new JsonRPC($conf);
 *  $pool->add($rpc);
 *
 *  $conf = [
 *      "user" => "test",
 *      "pass" => "pass",
 *      "host" => "localhost",
 *      "port" => 9333
 *  ];
 *  $rpc = new JsonRPC($conf);
 *  $pool->add($rpc);
 *
 *  $info = $pool->query("getinfo");
 * ```
 */
class RPCPool
    implements JsonRPCInterface
{
    /**
     * The JsonRPCInterface instances in the pool
     * @var JsonRPCInterface[]
     */
    private $items = [];

    /**
     * Number of servers in the pool
     * @var int
     */
    private $count = 0;

    /**
     * Index of the last server returned from the pool
     * @var int
     */
    private $index = 0;

    /**
     * Adds an JsonRPCInterface instance to the pool
     *
     * @param JsonRPCInterface $rpc The JsonRPCInterface instance
     * @return $this
     */
    public function add(JsonRPCInterface $rpc)
    {
        $this->items[] = $rpc;
        $this->count++;
        return $this;
    }

    /**
     * Returns an JsonRPCInterface instance from the pool
     *
     * Returns null when there are no servers in the pool.
     *
     * @return JsonRPCInterface|null
     */
    public function get()
    {
        $rpc = null;
        if ($this->count > 0) {
            $rpc = $this->items[$this->index];
            if (++$this->index > $this->count - 1) {
                $this->index = 0;
            }
        }

        return $rpc;
    }

    /**
     * Returns the number of JsonRPCInterface instances in the pool
     *
     * @return int
     */
    public function count()
    {
        return $this->count;
    }

    /**
     * {@inheritDoc}
     *
     * @throws RPCException When the pool has no available JsonRPCInterface instances
     */
    public function query($method, array $params = [])
    {
        $rpc = $this->get();
        if (null === $rpc) {
            throw new RPCException(
                "No JsonRPCInterface instances available in the pool."
            );
        }

        return $rpc->query($method, $params);
    }
}