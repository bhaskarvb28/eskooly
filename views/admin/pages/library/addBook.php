<?php
require '../../../../controllers/AdminController.php';

session_start();

$institutionDb = $_SESSION['institution']['database_name'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $adminController = new AdminController($institutionDb);

    $bookData = [
        'title' => $_POST['title'],
        'category_id' => $_POST['category_id'],
        'subject_id' => $_POST['subject_id'],
        'book_no' => $_POST['book_no'],
        'isbn' => $_POST['isbn'],
        'publisher' => $_POST['publisher'],
        'author' => $_POST['author'],
        'rack_no' => $_POST['rack_no'],
        'quantity' => $_POST['quantity'],
        'price' => $_POST['price'],
        'description' => $_POST['description']
    ];

    $response = $adminController->saveBook($bookData);

    if ($response['success']) {
        echo "<p style='color: green;'>✅ Book added successfully!</p>";
    } else {
        echo "<p style='color: red;'>❌ Error: " . htmlspecialchars($response['error']) . "</p>";
    }
}
