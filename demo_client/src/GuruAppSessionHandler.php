<?php
namespace GuruSessionHandler;

class GuruAppSessionHandler implements \SessionHandlerInterface
{
    private $handler;

    public function __construct(SessionHandlerInterface $handler)
    {
        $this->handler = $handler;
    }

    public function open($savePath, $sessionName)
    {
        return $this->handler->open($savePath, $sessionName);
    }

    public function close()
    {
        return $this->handler->close();
    }

    public function read($sessionId)
    {
        return $this->handler->read($sessionId);
    }

    public function write($sessionId, $data)
    {
        return $this->handler->write($sessionId, $data);
    }

    public function destroy($sessionId)
    {
        return $this->handler->destroy($sessionId);
    }

    public function gc($maxLifetime)
    {
        return $this->handler->gc($maxLifetime);
    }

    public function create_sid()
    {
        if (method_exists($this->handler, 'create_sid')) {
            return $this->handler->create_sid();
        }
        return session_create_id();
    }
}
