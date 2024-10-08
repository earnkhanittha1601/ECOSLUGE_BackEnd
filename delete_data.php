<?php
// เชื่อมต่อฐานข้อมูล
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'flutter_app';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed']));
}

// ตรวจสอบว่ามีค่า id และ project_name ถูกส่งมาหรือไม่
if (!isset($_POST['id']) || !isset($_POST['project_name'])) {
    echo json_encode(['success' => false, 'message' => 'ID or Project Name not provided']);
    exit;
}

$id = intval($_POST['id']); // รับค่า id และแปลงเป็น integer เพื่อลดความเสี่ยงของ SQL injection
$project_name = $_POST['project_name']; // รับค่า project_name

// สร้างชื่อตารางที่สัมพันธ์กับโปรเจคที่เลือก
$table_name = 'project_' . $conn->real_escape_string($project_name);

// ตรวจสอบว่าตารางที่ระบุมีอยู่จริงหรือไม่
$table_check_query = "SHOW TABLES LIKE '$table_name'";
$table_check_result = $conn->query($table_check_query);

if ($table_check_result->num_rows == 0) {
    echo json_encode(['success' => false, 'message' => 'Table not found']);
    $conn->close();
    exit;
}

// ลบข้อมูลตาม id
$sql = "DELETE FROM $table_name WHERE id = ?";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Data deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete data']);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to prepare statement']);
}

$conn->close();
?>
