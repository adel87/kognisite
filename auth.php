<?php
session_start();
$conn = new mysqli("localhost", "root", "", "techida_db");

if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM admin_users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    if (password_verify($password, $user['password'])) {
        $_SESSION['admin'] = $user['username'];
        header("Location: admin/dashboard.php");
        exit();
    }
}

header("Location: login.html?error=1");
exit();
?>
