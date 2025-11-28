<?php
namespace App\Model;

use PDO;
use Exception;
use IntlDateFormatter;
use DateTime;

class BlogManager
{
    private $db;

    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
    }

    /**
     * Fetches all blog posts or a limited number, ordered as specified.
     */
    public function getAllBlogs(string $orderBy = 'publish_date DESC', ?int $limit = null): array
    {
        $sql = "SELECT id, title, content, featured_image, publish_date, status FROM blogs WHERE status = 'published' ORDER BY " . $orderBy;
        if ($limit !== null && $limit > 0) {
            $sql .= " LIMIT " . $limit;
        }

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error fetching blogs: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Fetches a single blog post by its ID.
     */
    public function getTotalBlogs(): int
    {
        try {
            $stmt = $this->db->query("SELECT COUNT(*) FROM blogs WHERE status = 'published'");
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Error getting total blogs: " . $e->getMessage());
            return 0;
        }
    }

    public function getBlogById(int $id)
    {
        $sql = "SELECT id, title, content, featured_image, publish_date FROM blogs WHERE id = :id AND status = 'published'";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error fetching blog by ID " . $id . ": " . $e->getMessage());
            return false;
        }
    }

    /**
     * Generates a short summary from content. Static as it doesn't depend on DB state.
     */
    public static function generateSummary(string $content, int $wordLimit = 30): string
    {
        $strippedContent = strip_tags($content);
        $words = preg_split("/\s+/", $strippedContent);
        if (count($words) > $wordLimit) {
            return implode(" ", array_slice($words, 0, $wordLimit)) . "...";
        }
        return $strippedContent;
    }

    /**
     * Formats a date string. Static as it doesn't depend on DB state.
     */
    public static function formatBlogDate(string $dateString): string
    {
        if (empty($dateString)) {
            return '';
        }
        try {
            $date = new DateTime($dateString);
            
            if (class_exists('IntlDateFormatter')) {
                $formatter = new IntlDateFormatter('id_ID', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
                $formatter->setPattern('d MMMM yyyy');
                return $formatter->format($date);
            } else {
                // Fallback for when php-intl is not enabled
                $months = [
                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                ];
                $day = $date->format('d');
                $month = $months[(int)$date->format('n')];
                $year = $date->format('Y');
                return "$day $month $year";
            }
        } catch (Exception $e) {
            error_log("Error formatting date: " . $e->getMessage());
            return $dateString;
        }
    }
}
