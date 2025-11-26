<?php

declare(strict_types=1);

class BlogManager
{
    private $db;

    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
    }

    public function getAllBlogs()
    {
        return $this->db->query("SELECT * FROM blogs ORDER BY created_at DESC")->fetchAll();
    }

    public function createBlog(array $data, array $files): void
    {
        $content = $this->processContentImages($data['content']);
        $featured_image = $this->handleImageUpload($files['featured_image']);

        $stmt = $this->db->prepare("INSERT INTO blogs (title, content, author, featured_image, publish_date, status) VALUES (?, ?, ?, ?, ?, 'draft')");
        $stmt->execute([$data['title'], $content, $data['author'], $featured_image, $data['publish_date']]);
    }

    public function updateBlog(array $data, array $files): void
    {
        $id = $data['blog_id'];
        $content = $this->processContentImages($data['content']);
        $featured_image = $data['current_image'];

        if (isset($files['featured_image']) && $files['featured_image']['error'] === 0) {
            $featured_image = $this->handleImageUpload($files['featured_image'], $featured_image);
        }

        $stmt = $this->db->prepare("UPDATE blogs SET title = ?, content = ?, author = ?, featured_image = ?, publish_date = ? WHERE id = ?");
        $stmt->execute([$data['title'], $content, $data['author'], $featured_image, $data['publish_date'], $id]);
    }


    public function deleteBlog(int $id): void
    {
        $stmt = $this->db->prepare("SELECT featured_image FROM blogs WHERE id = ?");
        $stmt->execute([$id]);
        $blog = $stmt->fetch();

        if (!empty($blog['featured_image']) && file_exists($blog['featured_image'])) {
            unlink($blog['featured_image']);
        }

        $stmt = $this->db->prepare("DELETE FROM blogs WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function updateBlogStatus(int $id, string $status): void
    {
        $stmt = $this->db->prepare("UPDATE blogs SET status = ? WHERE id = ?");
        $stmt->execute([$status, $id]);
    }

    private function processContentImages(string $content): string
    {
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $images = $dom->getElementsByTagName('img');
        $processed_content = $content;

        for ($i = $images->length - 1; $i >= 0; $i--) {
            $img = $images->item($i);
            $src = $img->getAttribute('src');

            if (strpos($src, 'data:image') === 0) {
                $image_parts = explode(';base64,', $src);
                $image_type_aux = explode('image/', $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = $image_parts[1];

                $upload_dir = 'assets/content/';
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }

                $file_name = uniqid() . '.' . $image_type;
                $file_path = $upload_dir . $file_name;

                file_put_contents($file_path, base64_decode($image_base64));
                $processed_content = str_replace($src, $file_path, $processed_content);
            }
        }

        return $processed_content;
    }

    private function handleImageUpload(array $file, string $current_image = null): ?string
    {
        if (isset($file) && $file['error'] === 0) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            $max_size = 5 * 1024 * 1024; // 5MB

            if (!in_array($file['type'], $allowed_types) || $file['size'] > $max_size) {
                return $current_image;
            }

            $upload_dir = 'assets/img/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $unique_filename = uniqid() . '.' . $file_extension;
            $new_image_path = $upload_dir . $unique_filename;

            if ($this->resizeAndSaveImage($file['tmp_name'], $new_image_path)) {
                if ($current_image && file_exists($current_image)) {
                    unlink($current_image);
                }
                return $new_image_path;
            }
        }

        return $current_image;
    }

    private function resizeAndSaveImage(string $sourceFile, string $targetPath, int $maxWidth = 800, int $maxHeight = 600): bool
    {
        list($width, $height, $type) = getimagesize($sourceFile);

        $ratio = min($maxWidth / $width, $maxHeight / $height);
        $new_width = (int) round($width * $ratio);
        $new_height = (int) round($height * $ratio);

        $new_image = imagecreatetruecolor($new_width, $new_height);

        if ($type == IMAGETYPE_PNG) {
            imagecolortransparent($new_image, imagecolorallocate($new_image, 0, 0, 0));
            imagealphablending($new_image, false);
            imagesavealpha($new_image, true);
        }

        switch ($type) {
            case IMAGETYPE_JPEG:
                $source = imagecreatefromjpeg($sourceFile);
                break;
            case IMAGETYPE_PNG:
                $source = imagecreatefrompng($sourceFile);
                break;
            case IMAGETYPE_GIF:
                $source = imagecreatefromgif($sourceFile);
                break;
            default:
                return false;
        }

        imagecopyresampled($new_image, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

        switch ($type) {
            case IMAGETYPE_JPEG:
                imagejpeg($new_image, $targetPath, 90);
                break;
            case IMAGETYPE_PNG:
                imagepng($new_image, $targetPath, 9);
                break;
            case IMAGETYPE_GIF:
                imagegif($new_image, $targetPath);
                break;
        }

        imagedestroy($new_image);
        imagedestroy($source);

        return true;
    }
}
