<?php

class SessionSaveHandlerModel
{
    private $pdo;

    public function __construct()
    {

        $dsn = 'mysql:host=localhost;dbname=app_sessions_saver;charset=utf8';
        $username = 'app_sessions_saver';
        $password = 'vnun4oDGnup5';

        try {
            $this->pdo = new \PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Connection failed: ' . $e->getMessage());
        }
    }

    public function createSessionId($input)
    {
        $sessionId = $this->generateSessionId();
        $ipAddress = $input['ip_address'] ?? null;
        $deviceInfo = $input['device_info'] ?? null;

        $stmt = $this->pdo->prepare("INSERT INTO sessions (id, data, ip_address, device_info) VALUES (:id, :data, :ip_address, :device_info)");
        $stmt->execute([
            'id' => $sessionId,
            'data' => '',
            'ip_address' => $ipAddress,
            'device_info' => $deviceInfo
        ]);

        return ['id' => $sessionId];
    }

    public function readSession($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM sessions WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $session = $stmt->fetch(PDO::FETCH_ASSOC);

        return $session ? $session : ['message' => 'Session not found'];
    }

    public function writeSession($id, $data)
    {

        $stmt = $this->pdo->prepare("UPDATE sessions SET data = :data WHERE id = :id");
        $stmt->execute(['id' => $id, 'data' => $data]);

        return ['message' => 'Session updated'];
    }

    public function destroySession($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM sessions WHERE id = :id");
        $stmt->execute(['id' => $id]);

        return ['message' => 'Session destroyed'];
    }

    private function generateSessionId()
    {
        return bin2hex(random_bytes(16));
    }
}
