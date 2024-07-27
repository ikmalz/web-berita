<?php
// Mulai session (jika belum dimulai)
session_start();

// Hapus semua data session
session_unset();

// Hapus session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Hancurkan session
session_destroy();

// Redirect ke halaman login setelah logout
header("Location: crud.php");
exit();
?>
