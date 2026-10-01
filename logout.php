<?php
session_start();
// Hapus semua data sesi
session_unset();
session_destroy();

// Alihkan ke login dengan parameter sukses logout
header("Location: login.php?success=logout");
exit;
?>