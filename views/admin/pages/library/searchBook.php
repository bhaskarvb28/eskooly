<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../../../../config/connectInstitutionDb.php';
header("Content-Type: application/json");

$conn = connectToInstitutionDB($_SESSION['institution']['database_name']);
if (!$conn) {
    echo json_encode(['error' => "Database connection failed."]);
    exit;
}

$searchTermRaw = $_GET['query'] ?? '';
$searchTerm = '%' . $searchTermRaw . '%';

$resultsPerPage = 8;
$page = isset($_GET['page']) ? max((int)$_GET['page'], 1) : 1;
$offset = ($page - 1) * $resultsPerPage;

// Count total
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM book WHERE title LIKE :searchTerm");
$stmt->execute(['searchTerm' => $searchTerm]);
$totalResults = (int) $stmt->fetch(PDO::FETCH_ASSOC)['total'];
$totalPages = max(1, ceil($totalResults / $resultsPerPage));

// IMPORTANT FIX HERE:
$sql = "SELECT * FROM book WHERE title LIKE :searchTerm LIMIT $resultsPerPage OFFSET $offset";
$stmt = $conn->prepare($sql);
$stmt->bindValue(':searchTerm', $searchTerm, PDO::PARAM_STR);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);


echo json_encode([
    'data' => $data,
    'page' => $page,
    'totalPages' => $totalPages,
    'totalResults' => $totalResults,
    'query' => $searchTermRaw
]);
