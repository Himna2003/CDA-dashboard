<?php
$host = "localhost"; 
$user = "root";   
$pass = "";       
$dbname = "sectors";  

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT `name`, `longitude`, `latitude` FROM `sectors_1`"; 
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

header('Content-Type: application/json'); 
echo json_encode($data);

$conn->close();
?>
