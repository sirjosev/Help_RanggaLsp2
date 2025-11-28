<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_super_admin']) || !$_SESSION['is_super_admin']) {
    header("Location: login");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['foto'])) {
    $upload_dir = 'assets/img/gallery/';

    // Buat direktori jika belum ada
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $file = $_FILES['foto'];

    // Validasi sederhana
    if ($file['error'] !== UPLOAD_ERR_OK) {
        die("Error during file upload.");
    }

    $image_info = getimagesize($file['tmp_name']);
    if ($image_info === false) {
        die("Invalid image file.");
    }

    // Buat nama file yang unik
    $filename = basename($file['name']);
    $unique_filename = uniqid() . '-' . $filename;
    $file_path = $upload_dir . $unique_filename;

    // Pindahkan file ke direktori tujuan
    if (move_uploaded_file($file['tmp_name'], $file_path)) {
        // Simpan ke database
        try {
            $stmt = $conn->prepare("INSERT INTO photos (title, alt_text, file_path, status) VALUES (?, ?, ?, 'published')");
            $stmt->execute([$filename, $filename, $file_path]);

            // Redirect kembali ke halaman admin
            header("Location: admin_photo.php?success=1");
            exit();
        } catch (PDOException $e) {
            // Hapus file jika insert DB gagal
            unlink($file_path);
            die("Database error: " . $e->getMessage());
        }
    } else {
        die("Failed to move uploaded file.");
    }
} else {
    // Jika bukan POST request, redirect ke halaman utama
    header("Location: admin_photo.php");
    exit();
}
?>
