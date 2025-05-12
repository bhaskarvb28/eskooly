<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Assignment List</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
  <div class="content-container">
    <h1 class="title">Assignment List</h1>

    <div class="search-container">
      <form method='GET' action="">
        <i class="fas fa-search"></i>
        <input type="text" name="search" class="search" placeholder="Quick Search">
      </form>
    </div>

    <div class="table-container">
      <table class="table">
        <thead class="table-header">
          <tr>
            <th>Content Title</th>
            <th>Type</th>

            <th>Date</th>

            <th>Available For</th>
            <th>class</th>
            <th>Section</th>

            <th>Description</th>
            <th>Created By</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>

        <tbody class="table-values" id="table-values">
          <!-- Filled by JS  -->
        </tbody>
      </table>
    </div>


    <div class="pagination"></div>

    <script src="assignment.js"></script>
  </div>
</body>

</html>