<?php
require_once '../config/db.php';
require_once '../config/createInstitutionDb.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize POST data
    $institutionName = $_POST['institution_name'] ?? null;
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;
    $phone = $_POST['phone_number'] ?? null;
    $website = $_POST['website_url'] ?? null;
    $address = $_POST['address'] ?? null;
    $city = $_POST['city'] ?? null;
    $state = $_POST['state'] ?? null;
    $postalCode = $_POST['postal_code'] ?? null;
    $country = $_POST['country'] ?? 'India';

    // Basic validation
    if (!$institutionName || !$email || !$password || !$phone || !$address) {
        die("All required fields must be filled and terms must be accepted.");
    }

    // Make a safe DB name
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

        // Insert institution
        $stmt = $central->prepare("
            INSERT INTO institutions (
                name, database_name, email, phone_number, website_url,
                address, city, state, postal_code, country
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $institutionName,
            $dbName,
            $email,
            $phone,
            $website,
            $address,
            $city,
            $state,
            $postalCode,
            $country,
        ]);

        // Try to create new database (throws error if fails)
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
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
    <title>Institution Signup</title>
    <link rel="stylesheet" href="../public/assets/css/signup.css" />
</head>

<body>
    <div class="form-container">
        <h2>Institution Signup</h2>
        <form action="../public/signup.php" method="POST">
            <label for="institution_name">Institution Name</label>
            <input type="text" name="institution_name" id="institution_name" required>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>

            <label for="phone_number">Phone Number</label>
            <input type="text" name="phone_number" id="phone_number" required>

            <label for="website_url">Website URL</label>
            <input type="text" name="website_url" id="website_url">

            <label for="address">Address</label>
            <input type="text" name="address" id="address" required>

            <label for="city">City</label>
            <input type="text" name="city" id="city">

            <label for="state">State</label>
            <input type="text" name="state" id="state">

            <label for="postal_code">Postal Code</label>
            <input type="text" name="postal_code" id="postal_code">

            <label for="country">Country</label>
            <input type="text" name="country" id="country" value="India">

            <div class="terms">
                <input type="checkbox" name="terms" id="terms" required>
                <label for="terms">I accept the Terms and Conditions</label>
            </div>

            <button type="submit">Sign Up</button>
            <a class="link" href="../public/login.php">Already have an account? Login</a>
        </form>
    </div>
</body>

</html>