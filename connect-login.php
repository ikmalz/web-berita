<?php
session_start();

$serve = "localhost";
$username = "root";
$password = "";
$dbname = "web_berita";

$conn = new mysqli($serve, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $action = $_POST['action'];
    // Register
    if ($action === "register") {
        $username = $conn->real_escape_string($_POST['username']);
        $email = $conn->real_escape_string($_POST['email']);
        $password = $conn->real_escape_string($_POST['password']);
        $confirmasi = $conn->real_escape_string($_POST['confirm-password']);

        if ($password !== $confirmasi) {
            $error = "Konfirmasi password tidak sama";
        } else {
            $checkEmailQuery = "SELECT * FROM users1 WHERE email='$email'";
            $result = $conn->query($checkEmailQuery);
            if ($result->num_rows > 0) {
                $error = "Email sudah terdaftar";
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $insertQuery = "INSERT INTO users1 (username, email, password) VALUES ('$username', '$email', '$hashedPassword')";
                if ($conn->query($insertQuery) === TRUE) {
                    header("Location: login.php");
                    exit();
                } else {
                    $error = "Error: " . $conn->error;
                }
            }
        }
    }
    // Login
    elseif ($action === "login") {
        $email = $conn->real_escape_string($_POST['email']);
        $password = $conn->real_escape_string($_POST['password']);

        $checkEmailQuery = "SELECT * FROM users1 WHERE email='$email'";
        $result = $conn->query($checkEmailQuery);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                header("Location: landingpage.php");
                exit();
            } else {
                $error = "Password salah";
            }
        } else {
            $error = "Email tidak ditemukan";
        }
    }
    // Logout
    elseif ($action == 'logout') {
        session_unset();
        session_destroy();
        header("Location: landingpage.php");
        exit;
    }
}
