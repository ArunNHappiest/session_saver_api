# Session Saver API - PHP

This is the application save the session data into MySQL Database

## Database Config

Update the database access details at SessionSaveHandlerModel.php

```bash
        $dsn = 'mysql:host=localhost;dbname=app_sessions_saver;charset=utf8';
        $username = 'app_sessions_saver';
        $password = 'vnun4oDGnup5';
```
## Host Session application in your server, container or hosting
if you host this application in in domain name like
https://session.commonstatesaver.com/index.php

## Usage

```php
ob_start();
require 'ApiSessionHandler.php';

$apiBaseUrl = 'https://session.commonstatesaver.com/index.php';
$handler = new ApiSessionHandler($apiBaseUrl);
session_set_save_handler($handler, true);
session_start();
```

## API files Files
```php
\session_saver_api\index.php
\session_saver_api\SessionSaveHandlerModel.php

```
## Demo Client
```php
\session_saver_api\demo_client\index.php
\session_saver_api\demo_client\data.php
```
## Demo Links
[[http://localhost/demo_client/index.php]](http://localhost/demo_client/index.php)

[[http://localhost/demo_client/data.php]](http://localhost/demo_client/data.php)
