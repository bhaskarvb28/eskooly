<?php
function connectToInstitutionDB($institutionDb)
{
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    return new PDO("mysql:host=$host;dbname=$institutionDb", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
}
