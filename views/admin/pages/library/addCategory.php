<?php
require '../../../../controllers/AdminController.php';

session_start();

$institutionDb = $_SESSION['institution']['database_name'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $adminController = new AdminController($institutionDb);

    $name = $_POST['category_name'];

    $response = $adminController->saveCategory($name);

    if ($response['success']) {
        echo "<p style='color: green;'>✅ Category added successfully!</p>";
    } else {
        echo "<p style='color: red;'>❌ Error: " . htmlspecialchars($response['error']) . "</p>";
    }
}
