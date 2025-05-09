<?php

// If two institutuion have same name how will you help user select the right institution.

session_start();
require_once '../config/db.php'; // Central DB
require_once '../config/connectInstitutionDb.php'; // Function to connect institution DB

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $institutionId = $_POST['institution_id'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = strtolower($_POST['roles'] ?? '');

    if (empty($institutionId) || empty($email) || empty($password) || empty($role)) {
        die("All fields are required.");
    }

    // 1. Get institution details from central DB
    $stmt = $central->prepare("SELECT * FROM institutions WHERE id = ?");
    $stmt->execute([$institutionId]);
    $institution = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$institution) {
        die("Invalid institution selected.");
    }

    // 2. Connect to the institution's database
    $institutionDb = connectToInstitutionDB($institution['database_name']);
    if (!$institutionDb) {
        die("Could not connect to the selected institution's database.");
    }

    // 3. Search for user in institution DB
    $stmt = $institutionDb->prepare("SELECT * FROM users WHERE email = ? AND role_id = (SELECT id FROM roles WHERE name = ?)");
    $stmt->execute([$email, $role]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !password_verify($password, $user['password'])) {
        die("Invalid email, password, or role.");
    }

    // Bypassing hashed password verification for testing purpose
    // if (!$user || $password !== $user['password']) {
    //     die("Invalid email, password, or role.");
    // }


    // 4. Login success - store session
    $_SESSION['user'] = $user;
    $_SESSION['institution'] = $institution;
    $_SESSION['role'] = $role;

    // 5. Redirect to dashboard (adjust path as needed)
    if ($role == 'super admin') {
        header("Location: ../views/admin/pages/dashboard.php");
        exit();
    }
    header("Location: ../views/{$role}/pages/dashboard.php");
    exit();
} else {
    // Fetch institutions for the dropdown
    $stmt = $central->query("SELECT id, institution_name FROM institutions");
    $institutions = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>

<body>
    <h2>Login</h2>
    <form action="" method="POST">

        <!-- Institution Dropdown -->
        <label for="institution_id">Institution:</label>
        <select name="institution_id" id="institution_id" required>
            <?php foreach ($institutions as $institution): ?>
                <option value="<?= $institution['id'] ?>">
                    <?= htmlspecialchars($institution['institution_name']) ?>
                </option>
            <?php endforeach; ?>
        </select><br />

        <!-- Role Dropdown -->
        <label for="roles">Role: </label>
        <select name="roles" id="roles" required>
            <option>Super Admin</option>
            <option>Admin</option>
            <option>Teacher</option>
            <option>Student</option>
            <option>Parent</option>
            <option>Accountant</option>
            <option>Receptionist</option>
        </select><br />

        <!-- Email and Password fields -->
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>

        <button type="submit">Login</button>
        <a href="../public/signup.php">Sign up</a>
    </form>
</body>

</html>