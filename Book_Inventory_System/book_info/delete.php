<?php

if (isset($_GET["ISBN"])) {
    $ISBN = $_GET['ISBN'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "book_inventory";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Start transaction
    $conn->begin_transaction();

    try {
        // Delete dependent rows from scanner table
        $sql = "DELETE FROM scanner WHERE ISBN = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $ISBN);
        $stmt->execute();
        $stmt->close();

        // Delete book from book_information table
        $sql = "DELETE FROM book_information WHERE ISBN = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $ISBN);
        $stmt->execute();
        $stmt->close();

        // Commit transaction
        $conn->commit();

        // Redirect to book_info.php
        header("Location: /book_info/book_info.php");
        exit;
    } catch (Exception $e) {
        // Rollback transaction in case of error
        $conn->rollback();

        // Display error message
        echo "Error: " . $e->getMessage();
    }

    // Close connection
    $conn->close();
} else {
    // Redirect to book_info.php if ISBN is not set
    header("Location: /book_info/book_info.php");
    exit;
}
?>
