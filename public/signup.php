<?php
require_once '../config/db.php';
require_once '../config/createInstitutionDb.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $institutionName = $_POST['institution_name'] ?? null;
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    if (!$institutionName || !$email || !$password) {
        die("All fields are required.");
    }

    $dbSafeName = strtolower(preg_replace('/[^a-z0-9_]/', '_', $institutionName));
    $dbName = $dbSafeName . '_' . time(); // Ensures uniqueness

    try {
        $central->beginTransaction();

        // Check for existing email
        $stmt = $central->prepare("SELECT id FROM institutions WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            throw new Exception("Email already used.");
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insert institution
        $stmt = $central->prepare("INSERT INTO institutions (institution_name, database_name, email, password) VALUES (?, ?, ?, ?)");
        $stmt->execute([$institutionName, $dbName, $email, $hashedPassword]);

        // Try to create new database (throws error if fails)
        createinstitutionDatabase($dbName, $institutionName, $email, $hashedPassword);

        $central->commit();

        // Redirect to avoid resubmission
        header("Location: success.php");
        exit();
    } catch (Exception $e) {
        $central->rollBack();
        echo "Error: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="../public/signup.php" method="POST">
        <input type="text" name="institution_name" placeholder="Institution Name" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Sign Up</button>
        <a href="../public/login.php">Login</a>
    </form>
</body>

</html>