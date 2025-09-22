<?php
$host = "localhost"; 
$user = "root";   
$pass = "";       
$dbname = "sectors";  

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT `id`, `zone_id`, `title` FROM `pfms_sectors`"; 
$result = $conn->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}
echo json_encode($data);
$conn->close();
?>
