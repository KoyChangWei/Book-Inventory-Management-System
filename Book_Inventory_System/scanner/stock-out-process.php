<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "book_inventory";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: ". $conn->connect_error);
}

if (isset($_POST['barcode'])) {
    $barcode = $_POST['barcode'];

    // Prepare and bind the SQL query to prevent SQL injection
    $sql = "SELECT stock_id, quantity, ISBN FROM stock WHERE ISBN =?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $barcode);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $stock = $result->fetch_assoc();
        $stock_id = $stock['stock_id'];
        $quantity = $stock['quantity'];
        $isbn = $stock['ISBN']; // Assign ISBN from the fetched stock data

        // Update the quantity by incrementing it by 1 and stock-in date
        if ($quantity > 0) {
            $new_quantity = $quantity - 1;
            $sql = "UPDATE stock SET quantity =?, stock_out = NOW() WHERE stock_id =?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $new_quantity, $stock_id);
            $stmt->execute();

            // Find the title corresponding to the ISBN in the book_information table
            $sql = "SELECT title, author, year_publisher, page, price FROM book_information WHERE ISBN =?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $isbn);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $bookInfo = $result->fetch_assoc();
                $title = $bookInfo['title'];
                $author = $bookInfo['author'];
                $year = $bookInfo['year_publisher'];
                $page = $bookInfo['page'];
                $price = $bookInfo['price'];

                echo "<p>ISBN: $isbn</p><p>Title: $title</p><p>Author: $author</p>
                    <p>Year Publisher: $year</p><p>Page: $page</p><p>Price: RM $price</p>
                    <p>New quantity: $new_quantity</p>";
            } else {
                echo "<p>Book information not found for ISBN: $isbn</p>";
            }
        } else {
            echo "Out of stock. The quantity is 0.";
        }
    } else {
        echo "<p>Stock not found for ISBN: $barcode</p>";
    }
}

$conn->close();
?>