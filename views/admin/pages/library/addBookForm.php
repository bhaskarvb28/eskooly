<?php
require '../../../../config/connectInstitutionDb.php';
require '../../../../controllers/AdminController.php';

session_start();

$institutionDb = $_SESSION['institution']['database_name'];



$conn = connectToInstitutionDB($institutionDb);

$categories = [];
try {
    $stmt = $conn->query("SELECT id, name FROM book_categories");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching categories: " . $e->getMessage();
}

$subjects = [];
try {
    $stmt = $conn->query("SELECT id, name FROM subjects");
    $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching subjects: " . $e->getMessage();
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Eskooly Add Book</title>
</head>

<body>

    <div class="content-container">
        <h1 id="addBookHeading">Add Book</h1>

        <form action="pages/library/addBook.php" method="POST">
            <div class="form-group">
                <input type="text" name="title" placeholder="BOOK TITLE *" required />

                <select name="category_id" required>
                    <option disabled selected>SELECT BOOK CATEGORY *</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= htmlspecialchars($cat['id']) ?>">
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <select name="subject_id" required>
                    <option disabled selected>SELECT SUBJECTS *</option>
                    <?php foreach ($subjects as $subject): ?>
                        <option value="<?= htmlspecialchars($subject['id']) ?>">
                            <?= htmlspecialchars($subject['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <input type="text" name="book_no" placeholder="BOOK NO.""/>
                <input type=" text" name="isbn" placeholder="ISBN NO." />
                <input type="text" name="publisher" placeholder="PUBLISHER NAME" />
                <input type="text" name="author" placeholder="AUTHOR NAME" />
                <input type="text" name="rack_no" placeholder="RACK NUMBER" />
                <input type="number" name="quantity" placeholder="QUANTITY" required />
                <input type="number" name="price" placeholder="BOOK PRICE" step="0.01" />
            </div>

            <textarea name="description" rows="3" placeholder="DESCRIPTION"></textarea>

            <input type="submit" value="Save Book">
        </form>

    </div>

</body>

</html>