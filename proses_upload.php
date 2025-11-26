<?php

declare(strict_types=1);

session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}


require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['foto'])) {
    $upload_dir = 'assets/img/gallery/';

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $file = $_FILES['foto'];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        header("Location: admin_photo.php?error=upload_failed");
        exit;
    }

    $image_info = getimagesize($file['tmp_name']);
    if ($image_info === false) {
        header("Location: admin_photo.php?error=invalid_image");
        exit;
    }

    $filename = basename($file['name']);
    $unique_filename = uniqid() . '-' . $filename;
    $file_path = $upload_dir . $unique_filename;

    if (move_uploaded_file($file['tmp_name'], $file_path)) {
        try {
            $stmt = $conn->prepare("INSERT INTO photos (title, alt_text, file_path, status) VALUES (?, ?, ?, 'published')");
            $stmt->execute([$filename, $filename, $file_path]);

            header("Location: admin_photo.php?success=1");
            exit;
        } catch (PDOException $e) {
            unlink($file_path);
            header("Location: admin_photo.php?error=db_error");
            exit;
        }
    } else {
        header("Location: admin_photo.php?error=move_failed");
        exit;
    }
} else {
    header("Location: admin_photo.php");
    exit;
}
