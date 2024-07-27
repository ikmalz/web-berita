<?php
include "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $pengarang = mysqli_real_escape_string($conn, $_POST['pengarang']);
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']); 
    $tanggal_penulisan = date('Y-m-d H:i:s', strtotime($tanggal)); 
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
      $file_tmp = $_FILES['foto']['tmp_name'];
      $foto_name = basename($_FILES['foto']['name']);
      $upload_path = 'img/';
      $foto_baru = $upload_path . uniqid() . '_' . $foto_name;

      if (move_uploaded_file($file_tmp, $foto_baru)) {
        $query = "SELECT gambar_1 FROM web_berita1 WHERE id='$id'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        if ($row['gambar_1'] && file_exists($row['gambar_1'])) {
          unlink($row['gambar_1']);
        }
        $query = "UPDATE web_berita1 SET judul_berita='$judul', nama_penulis='$pengarang', deskripsi='$deskripsi', gambar_1='$foto_baru' WHERE id='$id'";
      } else {
        echo "<script>alert('Gagal mengunggah gambar baru. Data tidak diupdate.');window.location='edit.php?id=$id';</script>";
        exit;
      }
    } else {
      $query = "UPDATE web_berita1 SET judul_berita='$judul', nama_penulis='$pengarang', deskripsi='$deskripsi', tanggal_penulisan='$tanggal_penulisan' WHERE id='$id'";
    }

    $result = mysqli_query($conn, $query);

    if (!$result) {
      die("Query Error: " . mysqli_errno($conn) . " - " . mysqli_error($conn));
    } else {
      echo "<script>alert('Data berhasil diupdate.');window.location='crud.php';</script>";
    }
  } else {
    echo "<script>alert('ID tidak ditemukan.');window.location='crud.php';</script>";
  }
} else {
  echo "<script>alert('Metode tidak diizinkan.');window.location='crud.php';</script>";
}
