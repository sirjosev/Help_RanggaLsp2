<?php

declare(strict_types=1);

class PhotoManager
{
    private $db;

    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
        $this->initTable();
    }

    private function initTable()
    {
        $stmt = $this->db->query("SHOW TABLES LIKE 'photos'");
        if ($stmt->rowCount() == 0) {
            $this->db->exec("CREATE TABLE `photos` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `title` VARCHAR(255) DEFAULT NULL,
                `file_path` VARCHAR(255) NOT NULL,
                `alt_text` VARCHAR(255) DEFAULT NULL,
                `status` ENUM('draft', 'published') NOT NULL DEFAULT 'draft',
                `uploaded_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        } else {
            $stmt = $this->db->query("SHOW COLUMNS FROM `photos` LIKE 'status'");
            if ($stmt->rowCount() == 0) {
                $this->db->exec("ALTER TABLE `photos` ADD COLUMN `status` ENUM('draft', 'published') NOT NULL DEFAULT 'draft';");
            }
        }
    }

    public function getAllPhotos(): array
    {
        $stmt = $this->db->query("SELECT * FROM photos ORDER BY uploaded_at DESC");
        return $stmt->fetchAll();
    }
}
