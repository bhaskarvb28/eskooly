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
        <h1 class="title">Book List</h1>

        <div class="search-container">
            <i class="fas fa-search"></i>
            <input type="text" name="search" class="search" placeholder="Quick Search">
        </div>

        <div class="table-container">
            <table class="table">
                <thead class="table-header">
                    <tr>
                        <th>Book Title</th>
                        <!-- <th>Book No.</th> -->
                        <th>ISBN No</th>
                        <th>Category</th>
                        <th>Subject</th>
                        <th>Publisher Name</th>
                        <th>Author Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
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

    <script src="book.js"></script>

</body>

</html>