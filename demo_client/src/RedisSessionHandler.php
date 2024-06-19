<?php
namespace GuruSessionHandler;

class RedisSessionHandler implements \SessionHandlerInterface
{
    private $redis;
    private $ttl;

    public function __construct($host, $port, $ttl = 3600)
    {
        $this->ttl = $ttl;

        $this->redis = new Redis();
        $this->redis->connect($host, $port);
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
        // Redis handles expiration automatically, no action necessary
        return true;
    }
}
