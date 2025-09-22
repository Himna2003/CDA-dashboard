<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$csvFile = 'markaz.csv';

if (!file_exists($csvFile)) {
    http_response_code(500);
    echo json_encode(["error" => "CSV file not found"]);
    exit;
}

function readCSV($filename) {
    $rows = [];
    if (($handle = fopen($filename, 'r')) !== FALSE) {
        $headers = fgetcsv($handle);
        while (($data = fgetcsv($handle)) !== FALSE) {
            $rows[] = array_combine($headers, $data);
        }
        fclose($handle);
    }
    return $rows;
}
$markazData = readCSV($csvFile);

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    if ($action === 'list') {
        $names = array_map(fn($row) => $row['name'], $markazData);
        echo json_encode($names);
        exit;
    }

    if ($action === 'detail' && isset($_GET['name'])) {
        $name = $_GET['name'];
        foreach ($markazData as $row) {
            if ($row['name'] === $name) {
                echo json_encode($row);
                exit;
            }
        }
        http_response_code(404);
        echo json_encode(["error" => "Markaz not found"]);
        exit;
    }
}

http_response_code(400);
echo json_encode(["error" => "Invalid request"]);
exit;
?>