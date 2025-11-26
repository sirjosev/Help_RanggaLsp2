<?php

declare(strict_types=1);

session_start();

// Redirect to login page if user is not logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

require_once 'config.php';
require_once 'includes/BlogManager.php';

$blogManager = new BlogManager($conn);

// Handle blog operations
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    try {
        switch ($_POST['action']) {
            case 'create':
                $blogManager->createBlog($_POST, $_FILES);
                break;
            case 'update':
                $blogManager->updateBlog($_POST, $_FILES);
                break;
            case 'delete':
                $blogManager->deleteBlog((int)$_POST['blog_id']);
                break;
            case 'update_status':
                $blogManager->updateBlogStatus((int)$_POST['blog_id'], $_POST['status']);
                echo json_encode(['success' => true]);
                exit;
        }
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } catch (Exception $e) {
        // Log the error and show a generic message
        error_log($e->getMessage());
        die('An error occurred. Please try again later.');
    }
}

// Fetch blogs
$blogs = $blogManager->getAllBlogs();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Management</title>
    <link rel="stylesheet" href="css/admin.css" />
    <script src="https://cdn.tiny.cloud/1/z879h2vkvp2801s702gci1i4gvps4263c2xwb6t06fa91302/tinymce/6/tinymce.min.js"></script>
</head>

<body>
    <?php require_once 'includes/sidebar.php'; ?>

    <div class="main-content">
        <header>
            <div class="header-content">
                <h1>Blog Management</h1>
            </div>
        </header>

        <section class="form-section">
            <button class="btn" onclick="showCreateForm()">Create New Blog</button>
        </section>

        <section class="blog-list-section">
            <h2>All Blogs (<?= count($blogs) ?> total)</h2>
            <div class="blog-list">
                <?php if (empty($blogs)): ?>
                    <div class="blog-card">
                        <p>No blogs found. Create your first blog!</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($blogs as $blog): ?>
                    <div class="blog-card">
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
                            <span class="status-badge status-<?= $blog['status'] ?>">
                                <?= ucfirst($blog['status']) ?>
                            </span>
                        </div>
                        
                        <p class="blog-summary">
                            <?= substr(strip_tags($blog['content']), 0, 150) ?>...
                        </p>
                        
                        <div class="card-actions">
                            <a href="blog_detail.php?id=<?= $blog['id'] ?>" target="_blank" class="btn btn-small">Read more</a>
                            <button class="btn btn-small" onclick="editBlog(<?= $blog['id'] ?>)">Edit</button>
                            <button class="btn btn-danger btn-small" onclick="deleteBlog(<?= $blog['id'] ?>)">Delete</button>
                            
                            <select onchange="updateStatus(<?= $blog['id'] ?>, this.value)" style="margin-left: 10px;" class="form-control-small">
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
