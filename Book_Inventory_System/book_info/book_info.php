<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Information</title>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
     <!-- The sidebar -->
<div class="sidebar">
    <h3 class="sidebar-heading">UUM PRESS BOOK STORE</h3>
    <hr class="sidebar-divider my-0">
    
    <a href="/staff_registration/dashboard.php"><i class="fa fa-fw fa-home"></i> Home</a>
    <h3 class="sidebar-heading">Tables</h3>
    <a href="/book_info/book_info.php"><i class="fa fa-book"></i> Book</a>
    <a href="/stock/stock.php"><i class="fa fa-archive"></i> Stock</a>
</div>



    <div class="container book">
    <div class="d-flex justify-content-end">

        
    <a href="/staff_registration/logout.php">Logout</a>
        </div>   
        <h2>List of Books</h2>
        <div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="d-flex justify-content-between align-items-center">
        <a class="btn btn-secondary" href="/book_info/create.php" role="button">New book</a>
        <form method="GET" class="w-50">
          <div class="input-group">
            <input type="text" name="search" value="<?php if(isset($_GET['search'])){echo $_GET['search']; }?>" class="form-control" placeholder="Search by ISBN">
            <button type="submit" class="btn btn-primary">Search</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
        <br>
        <hr>
        <table class="table">
            <thead>
                <tr>
                    <th>ISBN</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Year Publisher</th>
                    <th>Page</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
          
                <?php
                
               

                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "book_inventory";

                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                
                if(!isset($_GET['search'])){
                    
    
                    $sql = "SELECT * FROM `book_information`;";
                    $result = $conn->query($sql);
    
                    if (!$result) {
                        die("Invalid query: " . $conn->error);
                    }

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "
                        <tr>
                            <td>{$row['ISBN']}</td>
                            <td>{$row['title']}</td>
                            <td>{$row['author']}</td>
                            <td>{$row['year_publisher']}</td>
                            <td>{$row['page']}</td>
                            <td>{$row['price']}</td>
                            <td>
                                <a class='btn btn-primary btn-sm' href='/book_info/edit.php?ISBN={$row['ISBN']}' style='display: block; margin-bottom: 10px;'>Edit</a>
                               
                                <a class='btn btn-danger btn-sm' href='/book_info/delete.php?ISBN={$row['ISBN']}'>Delete</a>
                            </td>
                        </tr>
                        ";
                    }
                } else {
                    echo "<tr><td colspan='7'>No books found</td></tr>";
                }
                $conn->close();
            }else{
                

        if (isset($_GET['search'])) {
            $filtervalues = $_GET['search'];
            $sql = "SELECT * FROM book_information WHERE ISBN LIKE '%$filtervalues%' ";
        } else {
            $sql = "SELECT * FROM book_information";
        }

        $result = $conn->query($sql);

        if (!$result) {
            die("Invalid query: " . $conn->error);
        }

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                
                echo "
                <tr>
                    <td>{$row['ISBN']}</td>
                    <td>{$row['title']}</td>
                    <td>{$row['author']}</td>
                    <td>{$row['year_publisher']}</td>
                    <td>{$row['page']}</td>
                    <td>{$row['price']}</td>
                    <td>
                        <a class='btn btn-primary btn-sm' href='/book_info/edit.php?ISBN={$row['ISBN']}' style='display: block; margin-bottom: 10px;'>Edit</a>
                        <a class='btn btn-danger btn-sm' href='/book_info/delete.php?ISBN={$row['ISBN']}'>Delete</a>
                    </td>
                </tr>
                ";
            
            }
        } else {
            echo "<tr><td colspan='7'>No books found</td></tr>";
        }

        $conn->close();
            }

                
            
                ?>
            </tbody>
        </table>
    </div>
   
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
