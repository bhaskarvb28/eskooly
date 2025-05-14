<?php
require '../../../../config/connectInstitutionDb.php';
// require '../../../../controllers/AdminController.php';

session_start();

$institutionDb = $_SESSION['institution']['database_name'];
$conn = connectToInstitutionDB($institutionDb);


$roles = [];
try {
    $stmt = $conn->query("SELECT id, name FROM roles WHERE id IN (1, 2, 4)");
    $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching roles: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Book List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>

    <div class="content-container">
        <h1>Add Member</h1>

        <form action="pages/library/addMember.php" method="POST">
            <div">
                <select name="role_id" required>
                    <?php foreach ($roles as $role): ?>
                        <option value="<?= htmlspecialchars($role['id']) ?>">
                            <?= htmlspecialchars($role['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <input id="email" type="email" name="email" placeholder="Email" autocomplete="email" required>
                <input type="submit" value="Add Member">
        </form>

        <h1 class="title">Member List</h1>

        <div class="search-container">
            <i class="fas fa-search"></i>
            <input type="text" name="search" class="search" placeholder="Quick Search">
        </div>

        <div class="table-container">
            <table class="table">
                <thead class="table-header">
                    <tr>
                        <th>Name</th>
                        <th>Member Type</th>
                        <th>Member ID</th>
                        <th>Member Email</th>
                        <th>Mobile</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="table-values" class="table-values">
                    <!-- Filled by JS -->
                </tbody>

            </table>
        </div>

        <div class="pagination"></div>

    </div>

    <script src="libMembers.js"></script>

</body>

</html>