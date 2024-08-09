<?php
include('connect.php');
do{

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "SELECT * FROM uum_press_staff WHERE user_id = '$username'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $error = "The user has registered!! ";
            break;
        }
    $stmt = $conn->prepare("INSERT INTO uum_press_staff (user_id, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashed_password);

    if ($stmt->execute()) {
        $success = "Registration successful!";
    } else {
        $error = "Error: " . $stmt->error;
    }
    $stmt->close();
}
}while(false);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Registration</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    <div class="register-container">
        <h2>Register</h2>
        <form action="register.php" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
        </form>
        <?php
        if (isset($success)) {
            echo "<p class = 'success'>$success</p>";
            echo '<p><a href="/staff_registration/login.php">Go to login</a></p>';
        }
        if (isset($error)) {
            echo "<p class = 'error'>$error</p>";
        }
        ?>
    </div>
</body>
</html>
