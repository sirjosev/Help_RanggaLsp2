<?php

declare(strict_types=1);

session_start();
require_once 'config.php';

// Redirect to login if not authenticated
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Redirect if not super admin
if (!isset($_SESSION['is_super_admin']) || !$_SESSION['is_super_admin']) {
    header('Location: admin.php');
    exit;
}

$admin_id = $_GET['id'] ?? null;
if (!$admin_id) {
    header('Location: manage_admins.php');
    exit;
}

// Prevent super admin from deleting themselves
if ($admin_id == $_SESSION['admin_id']) {
    header('Location: manage_admins.php?error=cannot_delete_self');
    exit;
}

// Delete admin
$stmt = $conn->prepare("DELETE FROM users WHERE id = :id");
$stmt->bindParam(':id', $admin_id, PDO::PARAM_INT);

if ($stmt->execute()) {
    header('Location: manage_admins.php?success=deleted');
    exit;
} else {
    header('Location: manage_admins.php?error=delete_failed');
    exit;
}
