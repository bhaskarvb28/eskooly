<?php
session_start();
require '../../../core/adminAuth.php';
require_once '../../../controllers/AdminController.php';

$controller = new AdminController($_SESSION['institution']['database_name']);
$profile = $controller->getProfile();

$totalTeachers = $controller->getTeachers();

?>

<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Admin Dashboard</title>
        <link rel="stylesheet" href="dashboard.css"> <!-- Ensure this path is correct -->
</head>

<body>
        <div class="dashboard-wrapper">
                <!-- Dashboard Title -->
                <h2>Admin Dashboard</h2>

                <!-- Summary Cards -->
                <div class="dashboard-cards">
                        <div class="dashboard-card">
                                <h3>Total Students</h3>
                                <p>180</p>
                        </div>
                        <div class="dashboard-card">
                                <h3>Total Teachers</h3>
                                <p><?php echo $totalTeachers ?></p>

                        </div>
                        <div class="dashboard-card">
                                <h3>Total Parents</h3>
                                <p>180</p>
                        </div>
                        <div class="dashboard-card">
                                <h3>Total Staffs</h3>
                                <p>58</p>
                        </div>
                </div>

                <!-- Income/Expense Section -->
                <div class="dashboard-chart">
                        <h3>Income and Expenses for May 2019</h3>
                        <div class="dashboard-cards">
                                <div class="dashboard-card">
                                        <h3>Total Income</h3>
                                        <p>$16,200</p>
                                </div>
                                <div class="dashboard-card">
                                        <h3>Total Expenses</h3>
                                        <p>$5,000</p>
                                </div>
                                <div class="dashboard-card">
                                        <h3>Total Profit</h3>
                                        <p>$0</p>
                                </div>
                                <div class="dashboard-card">
                                        <h3>Total Revenue</h3>
                                        <p>$16,200</p>
                                </div>
                        </div>
                        <canvas id="incomeChart" width="600" height="300"></canvas>
                </div>

        </div>
</body>

</html>