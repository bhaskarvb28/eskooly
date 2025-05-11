<?php
session_start();
require '../../../core/adminAuth.php';
require_once '../../../controllers/AdminController.php';

$controller = new AdminController($_SESSION['institution']['database_name']);
$profile = $controller->getProfile();
?>

<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
</head>

<body>
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
</body>

</html>