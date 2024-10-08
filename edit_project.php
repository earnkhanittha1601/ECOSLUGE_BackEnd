<?php
header('Content-Type: application/json'); // กำหนดให้ส่งข้อมูลในรูปแบบ JSON
$host = 'localhost';
$user = 'root';
$password = ''; // ใส่รหัสผ่าน MySQL
$dbname = 'flutter_app';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

$project_name = $_POST['project_name'] ?? null;

if (!$project_name) {
    echo json_encode(['success' => false, 'message' => 'Project name is missing']);
    exit;
}

$sql = "SELECT id, gas_amount AS value, note AS description, date FROM project_dog WHERE project_name = '$project_name'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
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
