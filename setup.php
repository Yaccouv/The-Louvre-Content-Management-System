<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$database = "databaselouvre";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to create the 'membership' table
$sqlCreateMembershipTable = "CREATE TABLE IF NOT EXISTS `membership` (
    `fullname` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL,
    `password` varchar(255) NOT NULL,
    `username` varchar(255) NOT NULL,
    `dob` varchar(255) NOT NULL,
    `nationality` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;";

if ($conn->query($sqlCreateMembershipTable) === TRUE) {
    echo "Table 'membership' created successfully<br>";
} else {
    echo "Error creating 'membership' table: " . $conn->error;
}

// Sample data for 'membership' table
$fullnameMembership = 'yaccouv mungoshi';
$emailMembership = 'Mungoshiyacc4@gmail.com';
$usernameMembership = 'jcov';
$dobMembership = '11/03/2000';
$nationalityMembership = 'France';

// Password hash for 'membership' table
$passwordMembership = '$2y$10$eLjg0QiJjqDHeFZOKUPJ5.HSa8JVqLd0b21cb4GpiCpCoHdjvpPPO';
$passwordHashMembership = password_hash($passwordMembership, PASSWORD_DEFAULT);

// SQL query to insert sample data into the 'membership' table
$sqlInsertDataMembership = $conn->prepare("INSERT INTO `membership` (`fullname`, `email`, `password`, `username`, `dob`, `nationality`) VALUES (?, ?, ?, ?, ?, ?)");
$sqlInsertDataMembership->bind_param("ssssss", $fullnameMembership, $emailMembership, $passwordHashMembership, $usernameMembership, $dobMembership, $nationalityMembership);

$sqlInsertDataMembership->execute();

echo "Sample data inserted into 'membership' table successfully<br>";

// SQL query to create the 'booking' table
$sqlCreateBookingTable = "CREATE TABLE IF NOT EXISTS `booking` (
    `date` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;";

if ($conn->query($sqlCreateBookingTable) === TRUE) {
    echo "Table 'booking' created successfully<br>";
} else {
    echo "Error creating 'booking' table: " . $conn->error;
}

// SQL query to insert sample data into the 'booking' table
$sqlInsertDataBooking = $conn->prepare("INSERT INTO `booking` (`date`, `email`) VALUES (?, ?)");
$sqlInsertDataBooking->bind_param("ss", $dateBooking, $emailBooking);

// Sample data for 'booking' table
$dateBooking = '11/02/2023';
$emailBooking = 'mungoshiyacc4@gmail.com';

$sqlInsertDataBooking->execute();

echo "Sample data inserted into 'booking' table successfully<br>";

// Close the connection
$conn->close();
?>
