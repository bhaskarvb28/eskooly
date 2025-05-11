<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Eskooly | <?= $pageTitle ?? 'Admin Panel' ?></title>
    <link rel="stylesheet" href="../../public/assets/css/layout.css" />
    <!-- <link rel="stylesheet" href="staffAndStudents.css" /> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="container">

        <!-- Navbar with sidebar + Topbar -->
        <?php include 'navbar.php'; ?>

        <!-- Wrapper for sidebar and main content -->
        <div class="container">
            <!-- Main Content -->
            <div id="main-content">

            </div>
        </div>

    </div>

    <script src="../../public/assets/js/navbar.js"></script>
</body>

</html>