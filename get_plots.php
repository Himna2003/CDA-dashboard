<?php
header("Content-Type: application/json");

$host = "localhost";
$user = "root";   
$pass = "";       
$dbname = "d12";  

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed: " . $conn->connect_error]));
}

$sql = "SELECT `Sector`, `Subsector`, `Plot`, `Type`,`Street_No/Road`, `Corner_status`,`Size`,`Longitude`, 
`Latitude` FROM `d12`";
$result = $conn->query($sql);

$locations = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $locations[] = $row;
    }
}

echo json_encode($locations);
$conn->close();
?>
