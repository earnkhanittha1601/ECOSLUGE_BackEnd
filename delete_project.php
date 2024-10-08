<?php
$host = "localhost";
$user = "root";
$password = ""; // รหัสผ่าน MySQL
$dbname = "flutter_app"; // ชื่อฐานข้อมูล

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

$username = $_POST['username'] ?? null;
$project_name = $_POST['project_name'] ?? null;

if ($username && $project_name) {
    // ประกอบชื่อตาราง
    $table_name = "project_" . strtolower($project_name);

    // ตรวจสอบว่าตารางมีอยู่หรือไม่
    $check_table_sql = "SHOW TABLES LIKE '$table_name'";
    $result = $conn->query($check_table_sql);

    if ($result->num_rows > 0) {
        // ลบตารางออกจากฐานข้อมูล
        $sql = "DROP TABLE IF EXISTS $table_name";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['success' => true, 'message' => 'Project and table deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error deleting table: ' . $conn->error]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Table does not exist']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Missing username or project_name']);
}

$conn->close();
?>
