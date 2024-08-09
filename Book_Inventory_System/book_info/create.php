<?php
$ISBN = "";
$Title= "";
$Author= "";
$Year_Publisher= "";
$Page= "";
$Price= "";
$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ISBN = $_POST['ISBN'];
    $Title = $_POST['Title'];
    $Author = $_POST['Author'];
    $Year_Publisher = $_POST['Year_Publisher'];
    $Page = $_POST['Page'];
    $Price = $_POST['Price'];

    do {
        if (empty($ISBN) || empty($Title) || empty($Author) || empty($Year_Publisher) || empty($Page) || empty($Price)) {
            $errorMessage = 'All fields are required!!';
            break;
        }
        //create connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "book_inventory";

        // Check if the ISBN already exists
        $conn = new mysqli($servername, $username, $password, $dbname);
        $sql = "SELECT * FROM book_information WHERE ISBN = '$ISBN'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $errorMessage = "The ISBN is repeated";
            break;
        }

        // Add the book to the database
        $sql = "INSERT INTO book_information (ISBN, title, author, year_publisher, page, price) VALUES ('$ISBN', '$Title', '$Author', '$Year_Publisher', '$Page', '$Price')";
        if ($conn->query($sql) === TRUE) {
            $successMessage = "Book has been successfully added!";
            // Clear form fields
            $ISBN = "";
            $Title = "";
            $Author = "";
            $Year_Publisher = "";
            $Page = "";
            $Price = "";
            header("location:/book_info/book_info.php");
            exit();
        } else {
            $errorMessage = "Error: ". $sql. "<br>". $conn->error;
        }
    } while (false);
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Information</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
   
</head>
<body>
    <div class="container book">
        <h2>New Book</h2>

        <?php
        if (!empty($errorMessage)) {
            echo "<div class='alert alert-danger'>$errorMessage</div>";
        }
        if (!empty($successMessage)) {
            echo "<div class='alert alert-success'>$successMessage</div>";
        }
        ?>

        <form method="post">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">ISBN</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="ISBN" value="<?php echo $ISBN; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Title</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="Title" value="<?php echo $Title; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Author</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="Author" value="<?php echo $Author; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Year Publisher</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="Year_Publisher" value="<?php echo $Year_Publisher; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Page</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="Page" value="<?php echo $Page; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Price</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="Price" value="<?php echo $Price; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="/book_info/book_info.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
