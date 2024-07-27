<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$serve = "localhost";
$username = "root";
$password = "";
$dbname = "web_berita";

//var_dump($_SESSION);

$conn = new mysqli($serve, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['berita'])) {
    //  input buat untuk menghindari SQL Injection
    $berita = mysqli_real_escape_string($conn, $_POST['berita']);
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['description']);
    $penulis = mysqli_real_escape_string($conn, $_SESSION['username']);

    $target_dir = 'img/';
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;

    if ($_FILES["image"]["size"] > 5000000) {
        echo "Maaf, file terlalu besar.";
        $uploadOk = 0;
    }

    // Periksa ekstensi filenya pak
    $allowed_extensions = array("jpg", "jpeg", "png", "gif");
    $file_extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if (!in_array($file_extension, $allowed_extensions)) {
        echo "Maaf, hanya file JPG, JPEG, PNG, dan GIF yang diizinkan.";
        $uploadOk = 0;
    }

    // Cek apakah uploadOk masih bernilai 1 (tidak ada masalah)
    if ($uploadOk == 0) {
        echo "Maaf, file Anda tidak dapat diunggah.";
    } else {
        // Pindahkan file ke direktori targetnya
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // ini untuk masuk ke database, saya pakai user id
            $user_id = $_SESSION['user_id'];
            $sql = "INSERT INTO web_berita1 (judul_berita, tanggal_penulisan, gambar_1, deskripsi, nama_penulis, user_id) VALUES ('$berita', '$tanggal', '$target_file', '$deskripsi', '$penulis', '$user_id')";
            if (mysqli_query($conn, $sql)) {
                $pesan = "input";
                header("Location: crud.php?pesan=" . $pesan);
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
         } else {
            echo "Maaf, terjadi kesalahan saat mengunggah file Anda.";
        }
    }
}

if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    $sql = "DELETE FROM web_berita1 WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        header("Location: crud.php?pesan=hapus");
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}

function getNewsTitles()
{
    global $conn;
    $sql = "SELECT judul_berita FROM web_berita1";
    $result = $conn->query($sql);

    $titles = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $titles[] = $row["judul_berita"];
        }
    }
    return $titles;
}
