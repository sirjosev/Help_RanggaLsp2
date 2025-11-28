<?php
session_start();
require_once '../config/config.php';

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    header('Location: login');
    exit();
}

// Redirect if not super admin
if (!isset($_SESSION['is_super_admin']) || !$_SESSION['is_super_admin']) {
    header('Location: index');
    exit();
}

$admin_id = $_GET['id'] ?? null;
if (!$admin_id) {
    header('Location: manage_admins.php');
    exit();
}

// Prevent super admin from deleting themselves
if ($admin_id == $_SESSION['user_id']) {
    header('Location: manage_admins.php?error=cannot_delete_self');
    exit();
}

// Delete admin
$stmt = $conn->prepare("DELETE FROM users WHERE id = :id");
$stmt->bindParam(':id', $admin_id, PDO::PARAM_INT);

if ($stmt->execute()) {
    header('Location: manage_admins.php?success=deleted');
    exit();
} else {
    header('Location: manage_admins.php?error=delete_failed');
    exit();
}
?>
