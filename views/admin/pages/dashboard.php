<?php
require_once '../../../core/adminAuth.php';
require_once '../../../controllers/AdminController.php';

$controller = new AdminController($_SESSION['institution']['database_name']);
$profile = $controller->getProfile();

$pageTitle = "Dashboard";
ob_start(); // Start output buffering
?>

<!-- Dashboard UI -->
<div class="dashboard-container">
        <h2>Admin Dashboard</h2>
        <div class="stats">
                <p><strong>name:</strong> <?= htmlspecialchars($profile['name']) ?></p>
                <p><strong>role:</strong> <?= htmlspecialchars($profile['role']) ?></p>
                <p><strong>email:</strong> <?= htmlspecialchars($profile['email']) ?></p>

                <?php
                echo '<pre>';
                print_r($_SESSION);
                echo '</pre>';
                ?>
                <!-- Add more dashboard metrics here -->
        </div>
</div>

<?php
$pageContent = ob_get_clean(); // Store the buffered content
include '../layout.php'; // Wrap it with layout