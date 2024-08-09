<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Information</title>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container stock">
        <div class="d-flex justify-content-end">
            <a href="/staff_registration/logout.php">Logout</a>
        </div>
        <!-- The sidebar -->
        <div class="sidebar">
            <h3 class="sidebar-heading">UUM PRESS BOOK STORE</h3>
            <hr class="sidebar-divider my-0">
            <a href="/staff_registration/dashboard.php"><i class="fa fa-fw fa-home"></i> Home</a>
            <h3 class="sidebar-heading">Tables</h3>
            <a href="/book_info/book_info.php"><i class="fa fa-book"></i> Book</a>
            <a href="/stock/stock.php"><i class="fa fa-archive"></i> Stock</a>
        </div>
        <h2>Stock Preview</h2>
        <br> 
        <form method="GET" class="w-50">
          <div class="input-group">
            <input type="text" name="search" value="<?php if(isset($_GET['search'])){echo $_GET['search']; }?>" class="form-control" placeholder="Search by ISBN">
            <button type="submit" class="btn btn-primary">Search</button>
          </div>
        </form>
        <hr>
        <table class="table">
            <thead>
                <tr>
                    <th>Stock No</th>
                    <th>ISBN</th>
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Stock-in</th>
                    <th>Stock-out</th>
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
                $sql = "SELECT * FROM `stock`;";
                $result = $conn->query($sql);

                if (!$result) {
                    die("Invalid query: " . $conn->error);
                }

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $stockInDate = new DateTime($row['stock_in']);
                        $stockOutDate = $row['stock_out'] === '0000-00-00 00:00:00' ? null : new DateTime($row['stock_out']);
                        $currentDate = new DateTime();
                        $oneYearLater = $stockInDate->add(new DateInterval('P1Y'));
                        $activation = "Active";

                        echo "
                        <tr data-stock-in='{$row['stock_in']}' data-stock-out='{$row['stock_out']}' data-stock-id='{$row['stock_id']}'>
                            <td>{$row['stock_id']}</td>
                            <td>{$row['ISBN']}</td>
                            <td>{$row['quantity']}</td>
                            <td class='status'>{$activation}</td>
                            <td>{$row['stock_in']}</td>
                            <td>{$row['stock_out']}</td>
                        </tr>
                        ";
                    }
                } else {
                    echo "<tr><td colspan='6'>No stocks found</td></tr>";
                }
            }else{
                if (isset($_GET['search'])) {
                    $filtervalues = $_GET['search'];
                    $sql = "SELECT * FROM stock WHERE ISBN LIKE '%$filtervalues%' ";
                } else {
                    $sql = "SELECT * FROM stock";
                }
        
                $result = $conn->query($sql);
        
                if (!$result) {
                    die("Invalid query: " . $conn->error);
                }

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $stockInDate = new DateTime($row['stock_in']);
                        $stockOutDate = $row['stock_out'] === '0000-00-00 00:00:00' ? null : new DateTime($row['stock_out']);
                        $currentDate = new DateTime();
                        $oneYearLater = $stockInDate->add(new DateInterval('P1Y'));
                        $activation = "Active";

                        echo "
                        <tr data-stock-in='{$row['stock_in']}' data-stock-out='{$row['stock_out']}' data-stock-id='{$row['stock_id']}'>
                            <td>{$row['stock_id']}</td>
                            <td>{$row['ISBN']}</td>
                            <td>{$row['quantity']}</td>
                            <td class='status'>{$activation}</td>
                            <td>{$row['stock_in']}</td>
                            <td>{$row['stock_out']}</td>
                        </tr>
                        ";
                    }
                } else {
                    echo "<tr><td colspan='6'>No stocks found</td></tr>";
                }

            }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
    <script src="timerActivation.js"></script>
 
</body>
</html>
