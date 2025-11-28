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
        $stmt = $conn->prepare("UPDATE photos SET status = 'published' WHERE id = ?");
        $stmt->execute([$photo_id]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Photo published successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Photo not found or no changes made.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
