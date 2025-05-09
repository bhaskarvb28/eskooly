<?php
require_once '../../../core/adminAuth.php';
require_once '../../../controllers/AdminController.php';

$controller = new AdminController($_SESSION['institution']['database_name']);
$dashboardData = $controller->getDashboardData();

$pageTitle = "Dashboard";
ob_start(); // Start output buffering
?>

<!-- Dashboard UI -->
<div class="dashboard-container">
        <h2>Admin Dashboard</h2>
        <div class="stats">
                <p><strong>Total Users:</strong> <?= htmlspecialchars($dashboardData['total_users']) ?></p>
                <!-- Add more dashboard metrics here -->
        </div>
</div>

<?php
$pageContent = ob_get_clean(); // Store the buffered content
include '../layout.php'; // Wrap it with layout