<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "book_inventory";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['barcode'])) {
    $barcode = $_POST['barcode'];

    // Find the stock details corresponding to the ISBN in the stock table
    $sql = "SELECT stock_id, quantity, ISBN FROM stock WHERE ISBN = '$barcode'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $stock = $result->fetch_assoc();
        $stock_id = $stock['stock_id'];
        $quantity = $stock['quantity'];
        $isbn = $stock['ISBN']; // Assign ISBN from the fetched stock data

        // Update the quantity by incrementing it by 1 and stock-in date
        $new_quantity = $quantity + 1;
        $sql = "UPDATE stock SET quantity = '$new_quantity', stock_in = NOW() WHERE stock_id = '$stock_id'";
        $conn->query($sql);

        // Find the title corresponding to the ISBN in the book_information table
        $sql = "SELECT title, author, year_publisher, page, price FROM book_information WHERE ISBN = '$isbn'";
        $result = $conn->query($sql);
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
        echo "<p>Stock not found for ISBN: $barcode</p>";
    }
} else {
    echo "<p>Barcode not provided</p>";
}

$conn->close();
?>
