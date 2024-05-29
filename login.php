<?php
require_once('./conn.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = mysqli_real_escape_string($conn, $username);

    $query = "SELECT password FROM membership WHERE username = '$username'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];

        if (password_verify($password, $hashedPassword)) {
            // Password is correct, user is authenticated
            $_SESSION['username'] = $username;
            // Redirect to a protected page
            header("Location: index.php");
            exit();
        } else {
            // Incorrect username or password message with style
            echo '<div style="border: 1px solid #ff0000; background-color: #ffcccc; color: #ff0000; padding: 10px; margin: 10px 0;">Incorrect username or password.</div>';
        }
    } else {
        // Username or password not found message with style
        echo '<div style="border: 1px solid #ff0000; background-color: #ffcccc; color: #ff0000; padding: 10px; margin: 10px 0;">Username or password not found.</div>';
    }

    // Close the database connection
    $conn->close();
}
?>
