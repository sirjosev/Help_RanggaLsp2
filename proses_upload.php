<?php
require_once 'config.php';

header('Content-Type: application/json');

// Helper function to send JSON response and exit
function json_response($success, $message = '', $data = []) {
    $response = ['success' => $success, 'message' => $message];
    if (!empty($data)) {
        $response = array_merge($response, $data);
    }
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['foto'])) {
    $upload_dir = 'assets/img/gallery/';

    // Buat direktori jika belum ada
    if (!is_dir($upload_dir)) {
        // Check if parent directory is writable, otherwise mkdir might fail silently
        if (!is_writable(dirname($upload_dir))) {
             json_response(false, 'Server error: Directory is not writable.');
        }
        mkdir($upload_dir, 0777, true);
    }

    $file = $_FILES['foto'];

    // Validasi
    if ($file['error'] !== UPLOAD_ERR_OK) {
        json_response(false, 'Error during file upload. Code: ' . $file['error']);
    }

    $image_info = getimagesize($file['tmp_name']);
    if ($image_info === false) {
        json_response(false, 'Invalid image file.');
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

            json_response(true, 'Photo uploaded successfully.');

        } catch (PDOException $e) {
            // Hapus file jika insert DB gagal
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            json_response(false, 'Database error: ' . $e->getMessage());
        }
    } else {
        json_response(false, 'Failed to move uploaded file. Check server permissions.');
    }
} else {
    json_response(false, 'Invalid request method.');
}
?>
