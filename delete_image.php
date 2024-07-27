<?php
include "connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    // Debugging: Cek nilai ID
    error_log("ID to delete: " . $id);

    if (!empty($id) && is_numeric($id)) {
        $query = "DELETE FROM web_berita1 WHERE id = ?";
        $stmt = $conn->prepare($query);

        // Debugging: Cek apakah statement berhasil diprepare
        if ($stmt === false) {
            error_log("Prepare failed: " . htmlspecialchars($conn->error));
            header("Location: crud.php?pesan=error");
            exit();
        }

        $stmt->bind_param("i", $id);

        // Debugging: Eksekusi dan cek hasilnya
        if ($stmt->execute()) {
            error_log("Deletion successful for ID: " . $id);
            header("Location: crud.php?pesan=hapus");
        } else {
            error_log("Deletion failed for ID: " . $id . " - Error: " . htmlspecialchars($stmt->error));
            header("Location: crud.php?pesan=error");
        }
        $stmt->close();
    } else {
        error_log("Invalid ID: " . $id);
        header("Location: crud.php?pesan=invalid_id");
    }
} else {
    header("Location: crud.php");
}
$conn->close();
?>
