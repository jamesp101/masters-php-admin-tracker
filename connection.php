
<?php
require_once 'config.php';
$conn;
try {
    $conn = new  mysqli(
        $host,
        $user,
        $password,
        $database
    );
} catch (exception $e) {
    die('Cannot Connect to db');
}
