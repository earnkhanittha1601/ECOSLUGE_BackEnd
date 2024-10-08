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
if ($username) {
    // ดึงชื่อโปรเจคโดยไม่ต้องแสดง _a
    $sql = "SHOW TABLES LIKE 'project_%'";
    $result = $conn->query($sql);

    $projects = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_array()) {
            $project_name = $row[0];
            $project_name = str_replace("project_", "", $project_name); // ลบคำว่า "project_"
            $project_name = str_replace("_a", "", $project_name); // ลบ "_a" ต่อท้ายออก
            $projects[] = $project_name;
        }
        echo json_encode(['success' => true, 'projects' => $projects]);
    } else {
        echo json_encode(['success' => true, 'projects' => []]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Missing username']);
}

$conn->close();
?>
