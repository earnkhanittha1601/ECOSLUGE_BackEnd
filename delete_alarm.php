<?php
$host = 'localhost';
$user = 'root';
$password = ''; // ใส่รหัสผ่าน MySQL ของคุณ
$dbname = 'flutter_app';

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['id'];
$sql = "DELETE FROM alarms WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    echo "Alarm deleted successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
