<?php
function createInstitutionDatabase($dbName, $adminName, $adminEmail, $adminPassword)
{
    $host = 'localhost';
    $user = 'root';
    $pass = '';

    // Connect to MySQL server
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create the database

    $pdo->exec("CREATE DATABASE `$dbName`");

    // Connect to the new institution database
    $institutionPDO = new PDO("mysql:host=$host;dbname=$dbName", $user, $pass);
    $institutionPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Load and execute schema
    $schema = file_get_contents(__DIR__ . '/../schema/base_schema.sql');
    $institutionPDO->exec($schema);

    // Get the ID of the 'admin' role
    $stmt = $institutionPDO->prepare("SELECT id FROM roles WHERE name = 'super admin'");
    $stmt->execute();
    $adminRoleId = $stmt->fetchColumn();

    // Insert the super admin
    $insertAdmin = $institutionPDO->prepare("
        INSERT INTO root_user (name, email, password)
        VALUES (?, ?, ?)
    ");
    $insertAdmin->execute([$adminName, $adminEmail, $adminPassword]);
}
