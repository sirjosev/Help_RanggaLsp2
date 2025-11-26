<?php

declare(strict_types=1);

function getAllBlogs(PDO $conn, string $orderBy = 'publish_date DESC', ?int $limit = null): array
{
    $sql = "SELECT * FROM blogs WHERE status = 'published' ORDER BY $orderBy";
    if ($limit) {
        $sql .= " LIMIT $limit";
    }
    $stmt = $conn->query($sql);
    return $stmt->fetchAll();
}

function getBlogById(PDO $conn, int $id): ?array
{
    $stmt = $conn->prepare("SELECT * FROM blogs WHERE id = ? AND status = 'published'");
    $stmt->execute([$id]);
    $result = $stmt->fetch();
    return $result === false ? null : $result;
}

function generateSummary(string $content, int $wordLimit): string
{
    $stripped_content = strip_tags($content);
    $words = explode(' ', $stripped_content);
    if (count($words) > $wordLimit) {
        return implode(' ', array_slice($words, 0, $wordLimit)) . '...';
    }
    return $stripped_content;
}

function formatBlogDate(string $dateString): string
{
    $formatter = new IntlDateFormatter('id_ID', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
    return $formatter->format(strtotime($dateString));
}
