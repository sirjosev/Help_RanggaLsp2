<?php
require_once 'config.php';

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
    $filename = uniqid() . '-' . basename($file['name']);
    $filepath = $upload_dir . $filename;

    // Pindahkan file ke direktori tujuan
    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        // Simpan ke database
        try {
            $stmt = $conn->prepare("INSERT INTO photos (filename, filepath, status) VALUES (?, ?, 'published')");
            $stmt->execute([$filename, $filepath]);

            // Redirect kembali ke halaman admin
            header("Location: admin_photo.php?success=1");
            exit();
        } catch (PDOException $e) {
            // Hapus file jika insert DB gagal
            unlink($filepath);
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
