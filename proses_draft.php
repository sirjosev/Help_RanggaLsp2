<?php

declare(strict_types=1);

session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['admin_id'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}


require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['foto'])) {
    $upload_dir = 'assets/img/gallery/';

    // Buat direktori jika belum ada
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $file = $_FILES['foto'];

    // Validasi
    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['success' => false, 'message' => 'Error during file upload.']);
        exit;
    }

    $image_info = getimagesize($file['tmp_name']);
    if ($image_info === false) {
        echo json_encode(['success' => false, 'message' => 'Invalid image file.']);
        exit;
    }

    // Buat nama file yang unik
    $filename = basename($file['name']);
    $unique_filename = uniqid() . '-' . $filename;
    $file_path = $upload_dir . $unique_filename;

    if (move_uploaded_file($file['tmp_name'], $file_path)) {
        try {
            $stmt = $conn->prepare("INSERT INTO photos (title, alt_text, file_path, status) VALUES (?, ?, ?, 'draft')");
            $stmt->execute([$filename, $filename, $file_path]);
            $new_id = $conn->lastInsertId();

            echo json_encode([
                'success' => true,
                'message' => 'Draft saved successfully.',
                'photo' => [
                    'id' => $new_id,
                    'title' => $filename,
                    'file_path' => $file_path
                ]
            ]);
            exit;
        } catch (PDOException $e) {
            // Hapus file jika insert DB gagal
            unlink($file_path);
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to move uploaded file.']);
        exit;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
    exit;
}
