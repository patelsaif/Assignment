<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$database = "DummyData";

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$inputDate = $_GET['date']; // Assuming the client sends the date as a GET parameter

$sql = "SELECT * FROM DaywiseData WHERE cdate = '$inputDate'";
$result = $conn->query($sql);

$response = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $response[] = $row;
    }
} else {
    $response['message'] = "No data found for the given date.";
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>

