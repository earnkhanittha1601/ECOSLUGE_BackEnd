<?php
$host = "localhost";
$user = "root";
$password = ""; // รหัสผ่าน MySQL (ถ้ายังไม่ได้ตั้ง ให้เว้นว่างไว้)
$dbname = "flutter_app";

// สร้างการเชื่อมต่อฐานข้อมูล
$conn = new mysqli($host, $user, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

// รับข้อมูลจาก Flutter (POST)
$username = $_POST['username'] ?? null;
$password = $_POST['password'] ?? null;

if ($username && $password) {
    // ตรวจสอบว่ามีผู้ใช้นี้อยู่ในระบบหรือไม่
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Login successful']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid username or password']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Missing username or password']);
}

$conn->close();
?>
