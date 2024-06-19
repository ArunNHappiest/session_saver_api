<?php

class ApiSessionHandler implements \SessionHandlerInterface
{
    private $apiBaseUrl;

    public function __construct($apiBaseUrl)
    {
        $this->apiBaseUrl = rtrim($apiBaseUrl, '/');
    }

    public function open($savePath, $sessionName)
    {
        $session_id = session_id();
        if (empty($session_id)) {
            $new_session_id = $this->generateSessionId();
            session_commit();
            session_id($new_session_id);
        }
        // No action necessary
        return true;
    }

    public function close()
    {
        // No action necessary
        return true;
    }

    public function read($id)
    {
        $url = $this->apiBaseUrl . '/read-session?id=' . urlencode($id);
        $response = $this->sendRequest('GET', $url);

        return $response['data'] ?? '';
    }

    public function write($id, $data)
    {
        $url = $this->apiBaseUrl . '/write-session';
        $postData = ['id' => $id, 'data' => $data];

        $this->sendRequest('POST', $url, $postData);

        return true;
    }

    public function destroy($id)
    {
        $url = $this->apiBaseUrl . '/destroy-session';
        $postData = ['id' => $id];

        $this->sendRequest('POST', $url, $postData);

        return true;
    }

    public function gc($maxlifetime)
    {
        // No action necessary as expiration is handled by the API
        return true;
    }

    private function generateSessionId()
    {
        $url = $this->apiBaseUrl . '/create-session-id';
        $postData = [
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'device_info' => $_SERVER['HTTP_USER_AGENT']
        ];

        $response = $this->sendRequest('POST', $url, $postData);

        return $response['id'] ?? session_id();
    }

    private function sendRequest($method, $url, $data = [])
    {
        $ch = curl_init();

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        } elseif ($method === 'GET' && !empty($data)) {
            $url .= '?' . http_build_query($data);
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);

        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            throw new Exception('cURL error: ' . $error_msg);
        }

        curl_close($ch);

        return json_decode($result, true);
    }
}
