<?php
$host = 'localhost';
$user = 'root';
$password = ''; // ใส่รหัสผ่าน MySQL ของคุณ
$dbname = 'flutter_app';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['id'] ?? null;
$name = $_POST['name'];
$time = $_POST['time'];
$days = $_POST['days'];
$enabled = $_POST['enabled'];

if ($id) {
    // Update alarm
    $sql = "UPDATE alarms SET name='$name', time='$time', days='$days', enabled='$enabled' WHERE id=$id";
} else {
    // Insert new alarm
    $sql = "INSERT INTO alarms (name, time, days, enabled) VALUES ('$name', '$time', '$days', '$enabled')";
}

if ($conn->query($sql) === TRUE) {
    echo "Alarm saved successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
