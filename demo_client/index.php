<?php
include_once "inc.php";

// Example usage
$_SESSION['user_id'] = '1';
$_SESSION['user_name'] = 'arunncn';
$_SESSION['access_token'] = 'access token value';

$userLoggedIn = false;
// To regenerate session ID after login or signup
if ($userLoggedIn) {
    session_regenerate_id(true);
}

echo "Assigned the session variable here";
echo "<br>user_id,user_name,access_token";

echo "<br>";
echo "<a href='data.php' target='_blank'>View Session Data</a>";
