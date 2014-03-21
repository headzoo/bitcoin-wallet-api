<?php
namespace Headzoo\CoinTalk;

/**
 * Manages a pool of Server instances
 */
class Pool
{
    /**
     * The Server instances in the pool
     * @var Server[]
     */
    private $servers = [];

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
     * Adds an Server instance to the pool
     *
     * @param Server $server The Server instance
     * @return $this
     */
    public function add(Server $server)
    {
        $this->servers[] = $server;
        $this->count++;
        return $this;
    }

    /**
     * Returns an Server instance from the pool
     *
     * Returns null when there are no servers in the pool.
     *
     * @return Server|null
     */
    public function get()
    {
        $server = null;
        if ($this->count > 0) {
            $server = $this->servers[$this->index];
            if (++$this->index > $this->count - 1) {
                $this->index = 0;
            }
        }

        return $server;
    }

    /**
     * Returns the number of Server instances in the pool
     *
     * @return int
     */
    public function count()
    {
        return $this->count;
    }
} 