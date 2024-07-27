<?php
session_start();
include "connect.php";

if (isset($_POST['username']) && isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $password = isset($_POST['password']) ? mysqli_real_escape_string($conn, $_POST['password']) : '';

  if (!empty($password)) {
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    $query = "UPDATE users1 SET username='$username', password='$password_hash' WHERE id='$user_id'";
  } else {
    $query = "UPDATE users1 SET username='$username' WHERE id='$user_id'";
  }

  if (mysqli_query($conn, $query)) {
    header("Location: crud.php?pesan=update");
    exit();
  } else {
    echo "Error updating record: " . mysqli_error($conn);
  }
} else {
  header("Location: crud.php");
  exit();
}
?>
