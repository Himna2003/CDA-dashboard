<?php
header("Content-Type: application/json");
$host = "localhost"; 
$user = "root";   
$pass = "";       
$dbname = "parks";  

$conn = new mysqli("localhost", "username", "password", "database");

if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed"]));
}

$sql = "SELECT `ID`, `Area`, `Parks`, `Longitude`, `Latitude` FROM `parks_csv___parks_csv_csv`";
$result = $conn->query($sql);

$locations = [];
while($row = $result->fetch_assoc()) {
    $locations[] = $row;
}

echo json_encode($locations);
$conn->close();
?>
