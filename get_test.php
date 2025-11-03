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

$sql = " SELECT 
    d.Sector,
    d.Subsector,
    d.Plot,
    d.Type,
    d.`Street_No/Road` AS Street_Road,
    d.Corner_status,
    d.Size,
    d.Longitude,
    d.Latitude,
    p.length,
    p.width
    FROM d12 AS d
    JOIN pfms_plots_info_sectord12 AS p
    ON d.Plot = p.plot_no
    AND d.`Street_No/Road` = p.street_road
    AND d.Size = p.size";

$result = $conn->query($sql);

if (!$result) {
    echo json_encode(["error" => "SQL Error: " . $conn->error]);
    exit;
}

$locations = [];
while ($row = $result->fetch_assoc()) {
    $locations[] = $row;
}

echo json_encode($locations);
$conn->close();
?>
