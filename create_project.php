<?php
$host = "localhost";
$user = "root";
$password = ""; // รหัสผ่าน MySQL
$dbname = "flutter_app";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

$username = $_POST['username'] ?? null;
$project_name = $_POST['project_name'] ?? null;

if ($username && $project_name) {
    // สร้างตารางใหม่สำหรับโปรเจคนี้โดยไม่ต้องใส่ _a
    $table_name = "project_" . strtolower($project_name); // ไม่ใส่ _a
    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        gas_amount FLOAT,
        note TEXT,
        date DATE
    )";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true, 'message' => 'Project created successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error creating project: ' . $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Missing username or project_name']);
}

$conn->close();
?>
