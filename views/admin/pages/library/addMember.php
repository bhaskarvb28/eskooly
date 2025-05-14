<?php
require '../../../../controllers/AdminController.php';
require_once '../../../../config/connectInstitutionDb.php';

session_start();

$institutionDb = $_SESSION['institution']['database_name'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $adminController = new AdminController($institutionDb);

    $memberData = [
        'memberType' => $_POST['role_id'],
        'memberEmail' => $_POST['email'],
    ];

    $conn = connectToInstitutionDB($institutionDb);

    // Step 1: Check if already in libraryMembers
    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM libraryMembers WHERE memberEmail = :email");
    $stmt->execute(['email' => $memberData['memberEmail']]);
    $existingCount = (int) $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    if ($existingCount > 0) {
        echo "<p style='color: orange;'>⚠️ Member already exists in library records!</p>";
        exit;
    }

    // Step 2: Check in appropriate table
    $memberType = (int)$memberData['memberType'];
    $targetTable = '';
    switch ($memberType) {
        case 1: // Admin
        case 2: // Teacher
            $targetTable = 'staff';
            $emailColumn = 'email';
            break;
        case 3: // Student
            $targetTable = 'students';
            $emailColumn = 'student_email'; // use correct column name
            break;
        default:
            echo "<p style='color: red;'>❌ Invalid member type.</p>";
            exit;
    }

    // Step 3: Check existence in correct table
    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM $targetTable WHERE $emailColumn = :email");
    $stmt->execute(['email' => $memberData['memberEmail']]);
    $existsInMaster = (int) $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    if ($existsInMaster === 0) {
        echo "<p style='color: red;'>❌ No such " . ($memberType === 3 ? "student" : "staff") . " exists with this email!</p>";
        exit;
    }

    // Step 4: Add member
    $response = $adminController->addMember($memberData);
    if ($response['success']) {
        echo "<p style='color: green;'>✅ Member added successfully!</p>";
    } else {
        echo "<p style='color: red;'>❌ Error: " . htmlspecialchars($response['error']) . "</p>";
    }
}
