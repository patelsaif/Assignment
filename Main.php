<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";

// Create a database connection
$conn = new mysqli($servername, $username, $password);

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create the database
$databaseName = "DummyData";
$sqlCreateDatabase = "CREATE DATABASE $databaseName";

if ($conn->query($sqlCreateDatabase) === TRUE) {
    echo "Database created successfully<br>";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

// Select the newly created database
$conn->select_db($databaseName);

// Create the table
$sqlCreateTable = "CREATE TABLE DaywiseData (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    cdate DATE,
    cdata VARCHAR(255),
    additionalInfo VARCHAR(255),
    cimage LONGBLOB
)";

if ($conn->query($sqlCreateTable) === TRUE) {
    echo "Table created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

// Insert some dummy data
$sqlInsertData = "INSERT INTO DaywiseData (cdate, cdata, additionalInfo, cimage)
VALUES
    ('2023-10-03', 'Sample data 1', 'Additional info 1', '1.jpg'),
    ('2023-10-03', 'Sample data 2', 'Additional info 2', '2.jpg'),
    ('2023-10-04', 'Sample data 3', 'Additional info 3', '3.jpg'),
    ('2023-10-04', 'Sample data 4', 'Additional info 4', '4.jpg'),
    ('2023-09-05', 'Sample data 5', 'Additional info 5', '5.jpg')";

if ($conn->query($sqlInsertData) === TRUE) {
    echo "Dummy data inserted successfully<br>";
} else {
    echo "Error inserting data: " . $conn->error . "<br>";
}

// Close the database connection
$conn->close();
?>

