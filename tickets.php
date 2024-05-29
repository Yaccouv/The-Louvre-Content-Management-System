<?php
require_once('./conn.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './vendor/PHPMailer/src/Exception.php';
require './vendor/PHPMailer/src/PHPMailer.php';
require './vendor/PHPMailer/src/SMTP.php';

// Check if the form is submitted

$date = $_POST['date'];
$email = $_POST['email'];


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to insert data into the database
$sql = "INSERT INTO booking (email, date) VALUES ('$email', '$date')";

if ($conn->query($sql) === TRUE) {
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'mungoshiyacc4@gmail.com';
    $mail->Password = 'loan khst shff xfyi';
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;
    $mail->setFrom('mungoshiyacc4@gmail.com');

    // Recipients
    $mail->addAddress('mungoshiyacc4@gmail.com');
    $mail->addReplyTo($email);

    // Content
    $mail->isHTML(true);
    $mail->Subject = "Louvre Museum";
    $mail->Body    = "Your Booking for the date '$date' has been received and your Tickets will be processed shortly";

    $mail->send();

    // Styling for success message
    echo '<div style="background-color: #4CAF50; color: white; padding: 15px; margin-top: 10px;">Booking was successful, check your email for more info!</div>';
} else {
    // Styling for error message
    echo '<div style="background-color: #f44336; color: white; padding: 15px; margin-top: 10px;">Error: ' . $sql . '<br>' . $conn->error . '</div>';
}

// Close the database connection
$conn->close();
?>
