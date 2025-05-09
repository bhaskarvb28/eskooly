<?php
$host = 'localhost';
$db = 'eskooly';
$user = 'root';
$pass = '';
try {
    $central = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $central->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
