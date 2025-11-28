<?php
require_once 'config/config.php';

try {
    $conn->exec("CREATE TABLE IF NOT EXISTS `photos` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `title` VARCHAR(255) DEFAULT NULL,
        `file_path` VARCHAR(255) NOT NULL,
        `alt_text` VARCHAR(255) DEFAULT NULL,
        `status` ENUM('draft', 'published') NOT NULL DEFAULT 'draft',
        `uploaded_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    echo "Table 'photos' created successfully.";
} catch (PDOException $e) {
    echo "Error creating table: " . $e->getMessage();
}
?>
