<?php
// save_data.php

$host = 'localhost';
$user = 'root';
$password = ''; // รหัสผ่าน MySQL
$dbname = 'flutter_app'; // ชื่อฐานข้อมูล

// สร้างการเชื่อมต่อฐานข้อมูล
$conn = new mysqli($host, $user, $password, $dbname);

// ตรวจสอบการเชื่อมต่อฐานข้อมูล
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

// รับค่าจาก Flutter ที่ส่งมาด้วย POST
$username = $_POST['username'] ?? null;
$project_name = $_POST['project_name'] ?? null;
$value = $_POST['value'] ?? null;
$description = $_POST['description'] ?? null;
$date = $_POST['date'] ?? null;

// ตรวจสอบว่ามีการส่งค่าที่จำเป็นทั้งหมดหรือไม่
if ($username && $project_name && $value && $description && $date) {
    // ประกอบชื่อตารางของโปรเจกต์
    $table_name = "project_" . strtolower($project_name);

    // ตรวจสอบว่าตารางมีอยู่หรือไม่
    $check_table_sql = "SHOW TABLES LIKE '$table_name'";
    $result = $conn->query($check_table_sql);

    if ($result->num_rows > 0) {
        // เพิ่มข้อมูลลงในตาราง
        $sql = "INSERT INTO $table_name (gas_amount, note, date) VALUES ('$value', '$description', '$date')";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['success' => true, 'message' => 'Data saved successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error saving data: ' . $conn->error]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Table does not exist']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Missing parameters']);
}

$conn->close();
?>
