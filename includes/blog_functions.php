<?php
// includes/blog_functions.php

/**
 * Fetches all blog posts or a limited number, ordered as specified.
 *
 * @param PDO $conn The PDO database connection object.
 * @param string $orderBy The SQL ORDER BY clause.
 * @param int|null $limit The maximum number of posts to retrieve. Null for all.
 * @return array An array of blog posts.
 */
function getAllBlogs(PDO $conn, string $orderBy = 'publish_date DESC', ?int $limit = null): array {
    $sql = "SELECT id, title, content, featured_image, publish_date, status FROM blogs WHERE status = 'published' ORDER BY " . $orderBy;
    if ($limit !== null && $limit > 0) {
        $sql .= " LIMIT " . $limit;
    }

    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        // Basic error handling, consider logging in a real application
        error_log("Error fetching blogs: " . $e->getMessage());
        return []; // Return empty array on error
    }
}

/**
 * Fetches a single blog post by its ID.
 *
 * @param PDO $conn The PDO database connection object.
 * @param int $id The ID of the blog post.
 * @return array|false The blog post as an associative array, or false if not found or on error.
 */
function getBlogById(PDO $conn, int $id) {
    $sql = "SELECT id, title, content, featured_image, publish_date FROM blogs WHERE id = :id AND status = 'published'";
    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    } catch (PDOException $e) {
        error_log("Error fetching blog by ID " . $id . ": " . $e->getMessage());
        return false; // Return false on error
    }
}

/**
 * Generates a short summary from content.
 *
 * @param string $content The full content.
 * @param int $wordLimit The approximate number of words for the summary.
 * @return string The generated summary.
 */
function generateSummary(string $content, int $wordLimit = 30): string {
    $strippedContent = strip_tags($content); // Remove HTML tags
    $words = preg_split("/\s+/", $strippedContent);
    if (count($words) > $wordLimit) {
        return implode(" ", array_slice($words, 0, $wordLimit)) . "...";
    }
    return $strippedContent;
}

/**
 * Formats a date string.
 * Example: 21 April 2025
 *
 * @param string $dateString The date string (e.g., from database YYYY-MM-DD HH:MM:SS).
 * @return string The formatted date.
 */
function formatBlogDate(string $dateString): string {
    if (empty($dateString)) {
        return '';
    }
    try {
        $date = new DateTime($dateString);
        // Set locale to Indonesian
        $formatter = new IntlDateFormatter('id_ID', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
        $formatter->setPattern('d MMMM yyyy'); // Example: 21 April 2025
        return $formatter->format($date);
    } catch (Exception $e) {
        error_log("Error formatting date: " . $e->getMessage());
        return $dateString; // Return original on error
    }
}

?>
