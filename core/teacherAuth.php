<?php

// Ensure user is logged in
if (!isset($_SESSION['institution'])) {
    header("Location: ../../../public/login.php");
    exit();
}

if (!isset($_SESSION['user']) || ($_SESSION['user']['role_id'] !== 2)) {
    die("Unauthorized access.");
}
