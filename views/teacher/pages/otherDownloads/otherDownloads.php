<!DOCTYPE html<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Other Downloads List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="content-container">
        <h2 class="title">Other Downloads List</h2>

        <div class="search-container">
            <form method="GET" action="">
                <i class="fas fa-search"></i>
                <input type="text" name="search" class="search" placeholder="Quick Search"">
            </form>
        </div>

        <div class=" table-container">
                <table class="table">
                    <thead class="table-header">
                        <tr>
                            <th>Content Title</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Available For</th>
                            <th>Class</th>
                            <th>Section</th>
                            <th>Description</th>
                            <th>Created By</th>
                            <th>Status</th>
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

    <script src="otherDownloads.js"></script>
</body>

</html>