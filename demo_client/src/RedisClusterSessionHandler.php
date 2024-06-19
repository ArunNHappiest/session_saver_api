<?php

class RedisClusterSessionHandler implements \SessionHandlerInterface
{
    private $redis;
    private $ttl;

    public function __construct(array $clusterNodes, $ttl = 3600)
    {
        $this->ttl = $ttl;

        // Create a RedisCluster instance
        $this->redis = new RedisCluster(NULL, $clusterNodes);
        if (!$this->redis) {
            throw new Exception("Could not connect to Redis cluster.");
        }
    }

    public function open($savePath, $sessionName)
    {
        return true;
    }

    public function close()
    {
        return true;
    }

    public function read($sessionId)
    {
        $data = $this->redis->get($sessionId);
        return $data ? $data : '';
    }

    public function write($sessionId, $data)
    {
        return $this->redis->setex($sessionId, $this->ttl, $data);
    }

    public function destroy($sessionId)
    {
        $this->redis->del($sessionId);
        return true;
    }

    public function gc($maxLifetime)
    {
        // Redis handles expiration automatically
        return true;
    }

    public function create_sid()
    {
        $sid = bin2hex(random_bytes(32)); // Create a secure session ID
        return $sid;
    }
}
