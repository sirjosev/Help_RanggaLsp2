<?php
require_once '../config/config.php';

session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_super_admin']) || !$_SESSION['is_super_admin']) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $photo_id = $_POST['id'];

    if (empty($photo_id)) {
        echo json_encode(['success' => false, 'message' => 'Invalid Photo ID.']);
        exit;
    }

    try {
        // 1. Dapatkan file_path sebelum menghapus record
        $stmt = $conn->prepare("SELECT file_path FROM photos WHERE id = ?");
        $stmt->execute([$photo_id]);
        $photo = $stmt->fetch();

        if ($photo) {
            // 2. Hapus record dari database
            $stmt = $conn->prepare("DELETE FROM photos WHERE id = ?");
            $deleted = $stmt->execute([$photo_id]);

            if ($deleted) {
                // 3. Hapus file dari server
                if (file_exists($photo['file_path'])) {
                    unlink($photo['file_path']);
                }
                echo json_encode(['success' => true, 'message' => 'Photo deleted successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to delete photo from database.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Photo not found.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
