<?php
$host = "localhost";
$user = "root";
$password = ""; // ถ้าไม่มีรหัสผ่าน MySQL ให้เว้นว่าง
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

// ตรวจสอบว่ามีข้อมูลที่ถูกส่งมาหรือไม่
if ($username && $password) {
    // ตรวจสอบว่าผู้ใช้มีอยู่ในระบบแล้วหรือไม่
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Username already exists']);
    } else {
        // บันทึกข้อมูลลงฐานข้อมูล
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['success' => true, 'message' => 'User registered successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error: ' . $conn->error]);
        }
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Missing username or password']);
}

$conn->close();
?>
