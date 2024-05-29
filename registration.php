<?php
require_once('./conn.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $dob = $_POST['dob'];
    $nationality = $_POST['nationality'];

    $errors = array(); // Create an array to store validation errors
    $successMessage = ""; // Initialize a variable for success message


    // If there are validation errors, display them
    if (!empty($errors)) {
        echo '<div class="error-box">';
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
        echo '</div>';
    } else {
        // All input fields are valid, proceed with the registration

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Escape user inputs to prevent SQL injection
        $username = mysqli_real_escape_string($conn, $username);
        $password = mysqli_real_escape_string($conn, $password);
        $email = mysqli_real_escape_string($conn, $email);
        $dob = mysqli_real_escape_string($conn, $dob);
        $nationality = mysqli_real_escape_string($conn, $nationality);
        $fullname = mysqli_real_escape_string($conn, $fullname);

        // Check if the email already exists in the database
        $checkEmailQuery = "SELECT email FROM membership WHERE email = '$email'";
        $result = $conn->query($checkEmailQuery);

        if ($result->num_rows > 0) {
            // Email already exists, display an error message
            echo '<div class="error-box">Email already exists. Please use a different email address.</div>';
        } else {
            // Email is unique, proceed to insert the new record

            // Hash the password (for security)
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // SQL query to insert data into the database
            $sql = "INSERT INTO membership (username, password, email, dob, nationality, fullname) VALUES ('$username', '$hashedPassword', '$email', '$dob', '$nationality', '$fullname')";

            if ($conn->query($sql) === TRUE) {
                $successMessage = "welcome: $username your Registration was successful!";
            } else {
                echo '<div class="error-box">Error: ' . $sql . "<br>" . $conn->error . '</div>';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <style>
        /* Style for the error message box */
        .error-box {
            border: 1px solid #ff0000;
            background-color: #ffcccc;
            color: #ff0000;
            padding: 10px;
            margin: 10px 0;
        }

        /* Style for the success message box */
        .success-box {
            border: 1px solid #00ff00;
            background-color: #ccffcc;
            color: #00ff00;
            padding: 10px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <?php
    if (!empty($successMessage)) {
        echo '<div class="success-box">' . $successMessage . '</div>';
    }
    ?>
    <!-- Your registration form goes here -->
</body>
</html>
