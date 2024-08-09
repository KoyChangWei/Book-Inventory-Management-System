<?php
$ISBN = "";
$Title = "";
$Author = "";
$Year_Publisher = "";
$Page = "";
$Price = "";
$errorMessage = "";
$successMessage = "";

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "book_inventory";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == 'GET') {
    if (!isset($_GET['ISBN'])) {
        header("location:/book_info/book_info.php");
        exit;
    }
    $ISBN = $_GET["ISBN"];
    $sql = "SELECT * FROM book_information WHERE ISBN = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $ISBN);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location:/book_info/book_info.php");
        exit;
    }

    $Title = $row["title"];
    $Author = $row["author"];
    $Year_Publisher = $row["year_publisher"];
    $Page = $row["page"];
    $Price = $row["price"];
} else {
    $ISBN = $_POST["ISBN"];
    $Title = $_POST["Title"];
    $Author = $_POST["Author"];
    $Year_Publisher = $_POST["Year_Publisher"];
    $Page = $_POST["Page"];
    $Price = $_POST["Price"];

    do {
        if (empty($ISBN) || empty($Title) || empty($Author) || empty($Year_Publisher) || empty($Page) || empty($Price)) {
            $errorMessage = 'Please fill up all the fields!';
            break;
        }

        $sql = "UPDATE book_information SET title = ?, author = ?, year_publisher = ?, page = ?, price = ? WHERE ISBN = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssiiis", $Title, $Author, $Year_Publisher, $Page, $Price, $ISBN);

        if ($stmt->execute()) {
            $successMessage = "Book updated successfully";
            header("location:/book_info/book_info.php");
            exit;
        } else {
            $errorMessage = "Invalid query: " . $conn->error;
            break;
        }
    } while (false);
}

$conn->close();
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
        <h2>Edit Book</h2>

        <?php
        if (!empty($errorMessage)) {
            echo "<div class='alert alert-danger'>$errorMessage</div>";
        }
        if (!empty($successMessage)) {
            echo "<div class='alert alert-success'>$successMessage</div>";
        }
        ?>

        <form method="post">
            <input type="hidden" name="ISBN" value="<?php echo $ISBN; ?>">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">ISBN</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="ISBN" value="<?php echo $ISBN; ?>" readonly>
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
