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
