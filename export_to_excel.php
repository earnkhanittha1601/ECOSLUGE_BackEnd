<?php
// ตั้งค่า Content Type เป็น Excel
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="data_export.xls"');

$host = 'localhost';
$user = 'root';
$password = ''; // ใส่รหัสผ่าน MySQL ของคุณ
$dbname = 'flutter_app';

// เชื่อมต่อฐานข้อมูล
$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ตรวจสอบและรับค่า project_name จาก POST
$project_name = $_POST['project_name'] ?? null;
if (!$project_name) {
    echo "Project name is missing";
    exit;
}

// ดึงข้อมูลจากตารางที่เกี่ยวข้องกับโปรเจคที่เลือก
$sql = "SELECT id, gas_amount AS value, note AS description, date FROM project_$project_name";
$result = $conn->query($sql);

// เขียนข้อมูลเป็น Excel
if ($result->num_rows > 0) {
    // หัวข้อคอลัมน์
    echo "ID\tValue\tDescription\tDate\n";

    // แสดงข้อมูลในแต่ละแถว
    while ($row = $result->fetch_assoc()) {
        echo $row['id'] . "\t" . $row['value'] . "\t" . $row['description'] . "\t" . $row['date'] . "\n";
    }
} else {
    echo "No data available for the selected project";
}

$conn->close();
?>
