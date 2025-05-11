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
    if ($role == "root") {
        $stmt = $institutionDb->prepare("SELECT * FROM root_user WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        $stmt = $institutionDb->prepare("SELECT * FROM staff WHERE email = ? AND role_id = (SELECT id FROM roles WHERE name = ?)");
        $stmt->execute([$email, $role]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    if (!$user || !password_verify($password, $user['password'])) {
        die("Invalid email, password, or role.");
    }

    // Bypassing hashed password verification for testing purpose
    // if (!$user || $password !== $user['password']) {
    //     die("Invalid email, password, or role.");
    // }


    // 4. Login success - store session
    // Assuming $user is an associative array or object


    $_SESSION['institution'] = [
        'id' => $institution['id'],
        'name' => $institution['name'],
        'database_name' => $institution['database_name'],
        'email' => $institution['email'],
        'phone_number' => $institution['phone_number'],
        'website_url' => $institution['website_url'],
        'uploads_folder_path' => $institution['uploads_folder_path'],
        'logo_url' => $institution['logo_url'] ?? '', // Default to empty if not set
    ];

    // 5. Redirect to dashboard (adjust path as needed)
    if ($role == 'root') {
        $_SESSION['user'] = [
            'email' => $user['email'],  // If $user is an array
            'name' => $user['name'],    // If $user is an array
            'role' => $user['role'],    // If $user is an array
        ];
        header("Location: ../views/admin/adminDashboard.php");
        exit();
        // print_r($_SESSION);
    }
    $_SESSION['user'] = $user;
    header("Location: ../views/{$role}/{$role}Dashboard.php");
    exit();
} else {
    // Fetch institutions for the dropdown
    $stmt = $central->query("SELECT id, name FROM institutions");
    $institutions = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../public/assets/css/login.css" />
</head>

<body>
    <div class="login-container" id="user">
        <h2>Login</h2>
        <form action="" method="POST">
            <label for="institution_id">Institution</label>
            <select name="institution_id" id="institution_id" required>
                <?php foreach ($institutions as $institution): ?>
                    <option value="<?= $institution['id'] ?>">
                        <?= htmlspecialchars($institution['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="roles">Role</label>
            <select name="roles" id="roles" required>
                <option>Admin</option>
                <option>Teacher</option>
                <option>Student</option>
                <option>Parent</option>
                <option>Accountant</option>
                <option>Receptionist</option>
            </select>

            <label for="email">Email</label>
            <input id="email" type="email" name="email" placeholder="Email" autocomplete="email" required>

            <label for="password">Password</label>
            <input id="password" type="password" name="password" placeholder="Password" required>

            <button type="submit">Login</button>

            <div class="links">
                <p>Root User? <a href="#" onclick="toggleLoginType('root')">Login</a></p>
            </div>
        </form>
    </div>

    <div class="login-container" id="root" style="display: none;">
        <h2>Root Login</h2>
        <form action="" method="POST">
            <label for="root_institution_id">Institution</label>
            <select name="institution_id" id="root_institution_id" required>
                <?php foreach ($institutions as $institution): ?>
                    <option value="<?= $institution['id'] ?>">
                        <?= htmlspecialchars($institution['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="rootRole" style="display: none">Role</label>
            <select name="roles" id="rootRole" required style="display: none">
                <option>Root</option>
            </select>

            <label for="rootEmail">Email</label>
            <input id="rootEmail" type="email" name="email" placeholder="Email" autocomplete="email" required>

            <label for="rootPassword">Password</label>
            <input id="rootPassword" type="password" name="password" placeholder="Password" required>

            <button type="submit">Login</button>

            <div class="links">
                <p>Not a Root User? <a href="#" onclick="toggleLoginType('user')">Login</a></p>
                <p>Don't have an account?<a href="../public/signup.php">Sign up</a></p>
            </div>
        </form>
    </div>

    <script>
        function toggleLoginType(loginType) {
            if (loginType === 'root') {
                document.getElementById('user').style.display = 'none';
                document.getElementById('root').style.display = 'block';
            } else {
                document.getElementById('user').style.display = 'block';
                document.getElementById('root').style.display = 'none';
            }
        }
    </script>
</body>

</html>