<?php
// Sample PHP code (get_alarms.php) to ensure correct JSON format
header('Content-Type: application/json');
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'flutter_app';

// Connect to database
$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM alarms";
$result = $conn->query($sql);

$alarms = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $alarms[] = [
            'id' => $row['id'],
            'name' => $row['NAME'],
            'time' => $row['TIME'],
            'days' => $row['days'],
            'enabled' => $row['enabled']
        ];
    }
}

echo json_encode($alarms);
$conn->close();

?>
