<?php
// fetch_graph_data.php

header('Content-Type: application/json');

// เชื่อมต่อฐานข้อมูล
$host = 'localhost';
$user = 'root';
$password = ''; // ใส่รหัสผ่าน MySQL
$dbname = 'flutter_app';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed']));
}

// รับค่าจาก Flutter ผ่าน POST
$project_name = $_POST['project_name'] ?? null;

if (!$project_name) {
    echo json_encode(['success' => false, 'message' => 'Project name is missing']);
    exit;
}

// ใช้ชื่อตารางที่ตรงกับโปรเจคที่เลือก
$table_name = 'project_' . $conn->real_escape_string($project_name);

$sql = "SELECT id, gas_amount AS value, note AS description, date FROM $table_name";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'id' => $row['id'],
            'value' => $row['value'],
            'description' => $row['description'],
            'date' => $row['date']
        ];
    }
    echo json_encode(['success' => true, 'summary' => $data]);
} else {
    echo json_encode(['success' => false, 'message' => 'No data available']);
}

$conn->close();
?>
