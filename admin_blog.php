<?php

function processContentImages($content) {
    $dom = new DOMDocument();
    // Disable libxml errors and use internal errors
    libxml_use_internal_errors(true);
    $dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    libxml_clear_errors();
    
    $images = $dom->getElementsByTagName('img');
    $processed_content = $content;
    
    // Loop through images backwards (since we're modifying the array)
    for ($i = $images->length - 1; $i >= 0; $i--) {
        $img = $images->item($i);
        $src = $img->getAttribute('src');
        
        // Check if the image is base64 encoded
        if (strpos($src, 'data:image') === 0) {
            // Extract image information
            $image_parts = explode(';base64,', $src);
            $image_type_aux = explode('image/', $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = $image_parts[1];
            
            // Generate unique filename
            $upload_dir = 'assets/content/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            
            $file_name = uniqid() . '.' . $image_type;
            $file_path = $upload_dir . $file_name;
            
            // Save image file
            file_put_contents($file_path, base64_decode($image_base64));
            
            // Replace base64 image with new file path in content
            $processed_content = str_replace($src, $file_path, $processed_content);
        }
    }
    
    return $processed_content;
}

ini_set('upload_max_filesize', '10M');
ini_set('post_max_size', '10M');
ini_set('memory_limit', '256M');
set_time_limit(300); // 5 minutes for upload
ini_set('max_input_time', '300');

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once 'config.php';

// Check if GD library is installed
if (!extension_loaded('gd')) {
    die('PHP GD library is not installed');
}

// Image resize function
function resizeAndSaveImage($sourceFile, $targetPath, $maxWidth = 800, $maxHeight = 600) {
    list($width, $height, $type) = getimagesize($sourceFile);
    
    // Calculate new dimensions
    $ratio = min($maxWidth / $width, $maxHeight / $height);
    $new_width = round($width * $ratio);
    $new_height = round($height * $ratio);
    
    // Create new image
    $new_image = imagecreatetruecolor($new_width, $new_height);
    
    // Handle PNG transparency
    if($type == IMAGETYPE_PNG) {
        imagecolortransparent($new_image, imagecolorallocate($new_image, 0, 0, 0));
        imagealphablending($new_image, false);
        imagesavealpha($new_image, true);
    }
    
    // Load source image
    switch($type) {
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
    
    // Resize image
    imagecopyresampled($new_image, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    
    // Save image
    switch($type) {
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

// Handle blog operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'create':
                $title = $_POST['title'];
                $content = processContentImages($_POST['content']); // Process content before saving
                $author = $_POST['author'];
                
                // Handle image upload
                $featured_image = '';
                if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === 0) {
                    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
                    $max_size = 5 * 1024 * 1024; // 5MB
                    
                    $file_type = $_FILES['featured_image']['type'];
                    $file_size = $_FILES['featured_image']['size'];
                    
                    if (!in_array($file_type, $allowed_types)) {
                        die('File type not allowed');
                    }
                    
                    if ($file_size > $max_size) {
                        die('File too large');
                    }
                    
                    $upload_dir = 'assets/img/';
                    if (!file_exists($upload_dir)) {
                        mkdir($upload_dir, 0755, true);
                    }
                    
                    $file_extension = pathinfo($_FILES['featured_image']['name'], PATHINFO_EXTENSION);
                    $unique_filename = uniqid() . '.' . $file_extension;
                    $featured_image = $upload_dir . $unique_filename;
                    
                    if (!resizeAndSaveImage($_FILES['featured_image']['tmp_name'], $featured_image)) {
                        die('Failed to process image');
                    }
                }
                
                $stmt = $conn->prepare("INSERT INTO blogs (title, content, author, featured_image, publish_date, status) VALUES (?, ?, ?, ?, ?, 'draft')");
                $stmt->execute([$title, $content, $author, $featured_image, $_POST['publish_date']]);
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
                break;

            case 'update':
                $id = $_POST['blog_id'];
                $title = $_POST['title'];
                $content = processContentImages($_POST['content']); // Process content before saving
                $author = $_POST['author'];
                
                $featured_image = $_POST['current_image'];
                if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === 0) {
                    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
                    $max_size = 5 * 1024 * 1024;
                    
                    $file_type = $_FILES['featured_image']['type'];
                    $file_size = $_FILES['featured_image']['size'];
                    
                    if (!in_array($file_type, $allowed_types)) {
                        die('File type not allowed');
                    }
                    
                    if ($file_size > $max_size) {
                        die('File too large');
                    }
                    
                    $upload_dir = 'assets/img/';
                    $file_extension = pathinfo($_FILES['featured_image']['name'], PATHINFO_EXTENSION);
                    $unique_filename = uniqid() . '.' . $file_extension;
                    $featured_image = $upload_dir . $unique_filename;
                    
                    if (!resizeAndSaveImage($_FILES['featured_image']['tmp_name'], $featured_image)) {
                        die('Failed to process image');
                    }
                    
                    // Delete old image
                    if (!empty($_POST['current_image']) && file_exists($_POST['current_image'])) {
                        unlink($_POST['current_image']);
                    }
                }
                
                $stmt = $conn->prepare("UPDATE blogs SET title = ?, content = ?, author = ?, featured_image = ?, publish_date = ? WHERE id = ?");
                $stmt->execute([$title, $content, $author, $featured_image, $_POST['publish_date'], $id]);
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
                break;

            case 'delete':
                $id = $_POST['blog_id'];
                $stmt = $conn->prepare("SELECT featured_image FROM blogs WHERE id = ?");
                $stmt->execute([$id]);
                $blog = $stmt->fetch();
                
                if (!empty($blog['featured_image']) && file_exists($blog['featured_image'])) {
                    unlink($blog['featured_image']);
                }
                
                $stmt = $conn->prepare("DELETE FROM blogs WHERE id = ?");
                $stmt->execute([$id]);
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
                break;

            case 'update_status':
                $id = $_POST['blog_id'];
                $status = $_POST['status'];
                $stmt = $conn->prepare("UPDATE blogs SET status = ? WHERE id = ?");
                $stmt->execute([$status, $id]);
                echo json_encode(['success' => true]);
                exit;
                break;
        }
    }
}

// Fetch blogs
$blogs = $conn->query("SELECT * FROM blogs ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Management</title>
    <link rel="stylesheet" href="css/admin.css" />
    <script src="https://cdn.tiny.cloud/1/z879h2vkvp2801s702gci1i4gvps4263c2xwb6t06fa91302/tinymce/6/tinymce.min.js"></script>
    <!-- Blok <style> dihapus, styling akan dikelola oleh css/admin.css -->
</head>

<body>
    <div class="sidebar">
        <div class="logo">
            <!-- Menyamakan struktur logo dengan admin_skema.php jika diperlukan, atau pastikan styling logo di admin.css berlaku untuk keduanya -->
            <img class="img-fluid" src="assets/img/logo.png" alt="logo" style="width: 200px; height: auto;" />
        </div>
        <ul>
            <li><a href="admin_blog.php" class="active">Blog</a></li>
            <li><a href="admin_skema.php">Skema</a></li>
        </ul>
        <div class="sidebar-signout">
            <button class="btn btn-danger signout-btn-sidebar" onclick="window.location.href='login.php';">Sign Out</button>
        </div>
    </div>

    <div class="main-content">
        <header>
            <div class="header-content">
                <h1>Blog Management</h1>
                <!-- Tombol Sign Out dihapus dari header -->
            </div>
        </header>

        <!-- Menggunakan kelas 'form-section' seperti di admin_skema.php untuk konsistensi tombol aksi utama -->
        <section class="form-section">
            <button class="btn" onclick="showCreateForm()">Create New Blog</button> <!-- Menggunakan kelas 'btn' umum -->
        </section>

        <section class="blog-list-section"> <!-- Bisa juga dinamakan schema-section jika ingin lebih generik -->
            <h2>All Blogs (<?= count($blogs) ?> total)</h2>
            <div class="blog-list"> <!-- Bisa juga dinamakan schema-container jika ingin lebih generik -->
                <?php if (empty($blogs)): ?>
                    <div class="blog-card"> <!-- Akan di-style agar mirip schema-card via admin.css -->
                        <p>No blogs found. Create your first blog!</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($blogs as $blog): ?>
                    <div class="blog-card"> <!-- Akan di-style agar mirip schema-card via admin.css -->
                        <?php if (!empty($blog['featured_image'])): ?>
                            <img src="<?= htmlspecialchars($blog['featured_image']) ?>" alt="Featured Image" class="blog-image">
                        <?php endif; ?>
                        
                        <h3><?= htmlspecialchars($blog['title']) ?></h3>
                        
                        <div class="blog-meta">
                            <strong>Author:</strong> <?= htmlspecialchars($blog['author']) ?> | 
                            <strong>Date:</strong> <?= $blog['publish_date'] ?> | 
                            <strong>Created:</strong> <?= date('Y-m-d H:i', strtotime($blog['created_at'])) ?>
                            <br>
                            <strong>Status:</strong> 
                            <span class="status-badge status-<?= $blog['status'] ?>"> <!-- Style untuk status badge akan dipastikan ada di admin.css -->
                                <?= ucfirst($blog['status']) ?>
                            </span>
                        </div>
                        
                        <p class="blog-summary">
                            <?= substr(strip_tags($blog['content']), 0, 150) ?>...
                        </p>
                        
                        <div class="card-actions"> <!-- Menggunakan 'card-actions' seperti di admin_skema.php -->
                            <a href="#" onclick="viewBlog(<?= $blog['id'] ?>)" class="btn btn-small">Read more</a> <!-- Menambahkan kelas btn & btn-small -->
                            <button class="btn btn-small" onclick="editBlog(<?= $blog['id'] ?>)">Edit</button> <!-- Menggunakan kelas btn & btn-small -->
                            <button class="btn btn-danger btn-small" onclick="deleteBlog(<?= $blog['id'] ?>)">Delete</button> <!-- Menggunakan kelas btn, btn-danger & btn-small -->
                            
                            <select onchange="updateStatus(<?= $blog['id'] ?>, this.value)" style="margin-left: 10px;" class="form-control-small"> <!-- Menambahkan kelas untuk styling jika perlu -->
                                <option value="draft" <?= $blog['status'] == 'draft' ? 'selected' : '' ?>>Draft</option>
                                <option value="published" <?= $blog['status'] == 'published' ? 'selected' : '' ?>>Published</option>
                            </select>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>
    </div>

    <!-- Create/Edit Blog Modal -->
    <div id="blogModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="hideForm()">&times;</span>
            <h2 id="modalTitle">Create New Blog</h2>
            
            <form id="blogForm" action="" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="create">
                <input type="hidden" name="blog_id" id="blogId">
                <input type="hidden" name="current_image" id="currentImage">
                
                <div class="form-group">
                    <label for="title">Blog Title *</label>
                    <input type="text" name="title" id="title" required>
                </div>
                
                <div class="form-group">
                    <label for="author">Author *</label>
                    <input type="text" name="author" id="author" required>
                </div>
                
                <div class="form-group">
                    <label for="content">Content *</label>
                    <textarea id="content" name="content" rows="10"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="featured_image">Featured Image</label>
                    <input type="file" name="featured_image" id="featured_image" accept="image/*">
                    <div id="imagePreview"></div>
                </div>
                
                <div class="form-group">
                    <label for="publish_date">Publish Date *</label>
                    <input type="date" name="publish_date" id="publish_date" required>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn">Save Blog</button>
                    <button type="button" class="btn btn-danger" onclick="hideForm()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Initialize TinyMCE
        tinymce.init({
            selector: '#content',
            height: 400,
            plugins: 'lists link image code',
            toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist | link image | code',
            image_dimensions: false,
            content_style: 'img {max-width: 100%; height: auto;}',
            setup: function (editor) {
                editor.on('BeforeSetContent', function (e) {
                    if (e.content.includes('<img')) {
                        e.content = e.content.replace(/width=".*?"/g, '');
                        e.content = e.content.replace(/height=".*?"/g, '');
                    }
                });
            }
        });

        // Modal functions
        function showCreateForm() {
            document.getElementById('modalTitle').textContent = 'Create New Blog';
            document.getElementById('blogForm').reset();
            document.getElementById('imagePreview').innerHTML = '';
            document.querySelector('input[name="action"]').value = 'create';
            document.getElementById('blogModal').style.display = 'block';
            
            // Set default publish date to today
            document.getElementById('publish_date').value = new Date().toISOString().split('T')[0];
        }

        function hideForm() {
            document.getElementById('blogModal').style.display = 'none';
        }

        async function editBlog(id) {
            try {
                const response = await fetch(`get_blog.php?id=${id}`);
                if (!response.ok) {
                    throw new Error('Failed to fetch blog data');
                }
                const blog = await response.json();
                
                document.getElementById('modalTitle').textContent = 'Edit Blog';
                document.getElementById('blogId').value = blog.id;
                document.getElementById('title').value = blog.title;
                document.getElementById('author').value = blog.author;
                document.getElementById('currentImage').value = blog.featured_image || '';
                document.getElementById('publish_date').value = blog.publish_date;
                
                // Set TinyMCE content
                tinymce.get('content').setContent(blog.content || '');
                
                // Show current image preview
                const imagePreview = document.getElementById('imagePreview');
                if (blog.featured_image) {
                    imagePreview.innerHTML = `<img src="${blog.featured_image}" alt="Current Image" class="image-preview">`;
                } else {
                    imagePreview.innerHTML = '';
                }
                
                document.querySelector('input[name="action"]').value = 'update';
                document.getElementById('blogModal').style.display = 'block';
            } catch (error) {
                console.error('Error fetching blog:', error);
                alert('Failed to load blog data. Please try again.');
            }
        }

        function deleteBlog(id) {
            if (confirm('Are you sure you want to delete this blog? This action cannot be undone.')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="blog_id" value="${id}">
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }

        async function updateStatus(id, status) {
            try {
                const response = await fetch(window.location.href, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=update_status&blog_id=${id}&status=${status}`
                });
                
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                
                const result = await response.json();
                if (result.success) {
                    // Refresh page to show updated status
                    location.reload();
                }
            } catch (error) {
                console.error('Error updating status:', error);
                alert('Failed to update status. Please try again.');
            }
        }

        function viewBlog(id) {
            // You can implement a view blog function here
            // For now, just show an alert
            alert('View blog functionality - you can implement this to show blog details');
        }

        // Image preview functionality
        document.getElementById('featured_image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('imagePreview');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" alt="Preview" class="image-preview">`;
                };
                reader.readAsDataURL(file);
            } else {
                preview.innerHTML = '';
            }
        });

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('blogModal');
            if (event.target == modal) {
                hideForm();
            }
        }

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                hideForm();
            }
        });
    </script>
</body>
</html>