<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
require_once 'SessionSaveHandlerModel.php';


$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);
$uri = str_replace("/index.php", "", $uri);


// Simple router
switch ($uri) {
    case '/create-session-id':
        if ($method === 'POST') {
            $sessionHandler = new SessionSaveHandlerModel();
            echo json_encode($sessionHandler->createSessionId($input));
        }
        break;
    case '/read-session':
        if ($method === 'GET') {
            $sessionHandler = new SessionSaveHandlerModel();
            $sessionId = $_GET['id'] ?? '';
            echo json_encode($sessionHandler->readSession($sessionId));
        }
        break;
    case '/write-session':
        if ($method === 'POST') {
            $sessionHandler = new SessionSaveHandlerModel();
            $sessionId = $input['id'] ?? '';
            $data = $input['data'] ?? '';
            echo json_encode($sessionHandler->writeSession($sessionId, $data));
        }
        break;
    case '/destroy-session':

        if ($method === 'POST') {
            $sessionHandler = new SessionSaveHandlerModel();
            $sessionId = $input['id'] ?? '';
            echo json_encode($sessionHandler->destroySession($sessionId));
        }
        break;
    default:
        http_response_code(404);
        echo json_encode(['message' => 'Not Found']);
        break;
}
