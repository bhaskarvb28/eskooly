<?php

// Ensure user is logged in
if (!isset($_SESSION['institution'])) {
    header("Location: ../../../public/login.php");
    exit();
}



// echo '<pre>';
// print_r($_SESSION);
// echo '</pre>';


// echo "User role_id: " . $_SESSION['user']['role_id'];

//exit;

// Optional: Restrict to admin role only



if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role']) || ($_SESSION['user']['role'] !== 1 && $_SESSION['user']['role'] !== "root")) {
    die("Unauthorized access.");
}


// if (!isset($_SESSION['user']) || !isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== 'admin') {
//     die("Unauthorized access.");
// }
