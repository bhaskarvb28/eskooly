<?php
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

require '../../../../config/connectInstitutionDb.php';
session_start();

$institutionDb = $_SESSION['institution']['database_name'];
$conn = connectToInstitutionDB($institutionDb);

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Optional: Check if category exists
    $checkStmt = $conn->prepare("SELECT id FROM book_categories WHERE id = ?");
    $checkStmt->execute([$id]);
    if ($checkStmt->rowCount() === 0) {
        echo json_encode(["status" => "error", "message" => "Category not found."]);
        exit;
    }

    // Delete the category
    $deleteStmt = $conn->prepare("DELETE FROM book_categories WHERE id = ?");
    if ($deleteStmt->execute([$id])) {
        echo json_encode(["status" => "success", "message" => "Category deleted successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to delete category."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
}

$conn = null;
