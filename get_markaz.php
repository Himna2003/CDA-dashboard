<?php
$host = "localhost"; 
$user = "root";   
$pass = "";       
$dbname = "markaz";  

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT `Name`, `Address`, `Longitude`, `Latitude` FROM `markaz_in_`"; 
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($data);
$conn->close();
?>
