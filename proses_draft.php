<?php
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
    $filename = uniqid() . '-' . basename($file['name']);
    $filepath = $upload_dir . $filename;

    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        try {
            $stmt = $conn->prepare("INSERT INTO photos (filename, filepath, status) VALUES (?, ?, 'draft')");
            $stmt->execute([$filename, $filepath]);
            $new_id = $conn->lastInsertId();

            echo json_encode([
                'success' => true,
                'message' => 'Draft saved successfully.',
                'photo' => [
                    'id' => $new_id,
                    'filepath' => $filepath
                ]
            ]);
            exit;
        } catch (PDOException $e) {
            unlink($filepath);
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
?>
