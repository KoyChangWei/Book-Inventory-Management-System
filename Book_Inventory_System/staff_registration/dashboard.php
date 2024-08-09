<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel = "stylesheet" href ="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="dashboardStyle.css">
</head>
<body>
<!-- Logout link -->
<div class="logout-box">
    <a href="/staff_registration/logout.php" class="logout">Logout</a>
</div>
<!-- The sidebar -->
<div class="sidebar">
    <h3 class="sidebar-heading">UUM PRESS BOOK STORE</h3>
    <hr class="sidebar-divider my-0">
    
    <a href=""><i class="fa fa-fw fa-home"></i> Home</a>
    <h3 class="sidebar-heading">Tables</h3>
    <a href="/book_info/book_info.php"><i class="fa fa-book"></i> Book</a>
    <a href="/stock/stock.php"><i class="fa fa-archive"></i> Stock</a>
</div>
<!-- Main content area -->
<div class="header">
<h2>Book Inventory System</h2>
</div>

<div class ="record">
  <?php
  // Create a connection to the database
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "book_inventory";

  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check the connection
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // Write a SQL query to count the number of rows in the book table
  $sql = "SELECT COUNT(*) FROM book_information";

  // Execute the query and store the result
  $result = mysqli_query($conn, $sql);

  // Fetch the result as an associative array
  $row = mysqli_fetch_assoc($result);

  // Display the total number of book records
  echo "<div class='record-box'>";
  echo "<h2 class='bRecord'>Total number of books: " . $row["COUNT(*)"] . "</h2>";
  echo "</div>";

  // Close the connection
  mysqli_close($conn);
  ?>
<!-- HTML -->
<div class="main-content">
<h2>Manage stock</h2>
  <div class="scanner-stockout-container">
    
    <div class="scanner">
      <a href="/scanner/scan.php">
         Stock-in
      </a>
    </div>
    <div class="stock-out">
      <a href="/scanner/stock-out.php">
         Stock Out
      </a>
    </div>
  </div>
</div>

  
  
</div>

 
</body>
</html>