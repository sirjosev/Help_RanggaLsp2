<?php
session_start();
require_once '../config/config.php';

// 1. Database Migration & Setup (Auto-run)
try {
    // Check if 'role' column exists
    $stmt = $conn->query("SHOW COLUMNS FROM users LIKE 'role'");
    if ($stmt->rowCount() == 0) {
        // Add role column if missing, default to 'admin'
        $conn->exec("ALTER TABLE users ADD COLUMN role ENUM('super_admin', 'admin') NOT NULL DEFAULT 'admin'");
    }

    // Sync Super Admins from Config to DB
    // This ensures that hardcoded super admins in config.php are always super_admin in DB
    if (defined('SUPER_ADMIN_EMAILS')) {
        $placeholders = implode(',', array_fill(0, count(SUPER_ADMIN_EMAILS), '?'));
        $sql = "UPDATE users SET role = 'super_admin' WHERE email IN ($placeholders)";
        $stmt = $conn->prepare($sql);
        $stmt->execute(SUPER_ADMIN_EMAILS);
    }
} catch (PDOException $e) {
    die("Database setup error: " . $e->getMessage());
}

// 2. Access Control
// We still use the session check, which currently relies on login.php logic.
// After this update, login.php should ideally be updated to use the DB role, 
// but for now, we rely on the session variable which is set at login.
if (!isset($_SESSION['user_id'])) {
    header('Location: login');
    exit();
}

if (!isset($_SESSION['is_super_admin']) || !$_SESSION['is_super_admin']) {
    header('Location: index');
    exit();
}

// 3. Handle Form Submissions
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        try {
            switch ($_POST['action']) {
                case 'create':
                    $username = $_POST['username'];
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $role = $_POST['role'];

                    // Validate email
                    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
                    $stmt->execute([$email]);
                    if ($stmt->fetch()) {
                        throw new Exception("Email already exists!");
                    }

                    $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$username, $email, $hashed_pass, $role]);
                    $message = "Admin created successfully!";
                    break;

                case 'update':
                    $id = $_POST['id'];
                    $username = $_POST['username'];
                    $email = $_POST['email'];
                    $role = $_POST['role'];
                    $password = $_POST['password'];

                    // Check if email exists for other users
                    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
                    $stmt->execute([$email, $id]);
                    if ($stmt->fetch()) {
                        throw new Exception("Email already taken by another user!");
                    }

                    if (!empty($password)) {
                        // Update with password
                        $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
                        $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, role = ?, password = ? WHERE id = ?");
                        $stmt->execute([$username, $email, $role, $hashed_pass, $id]);
                    } else {
                        // Update without password
                        $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, role = ? WHERE id = ?");
                        $stmt->execute([$username, $email, $role, $id]);
                    }
                    $message = "Admin updated successfully!";
                    break;

                case 'delete':
                    $id = $_POST['id'];
                    // Prevent deleting yourself
                    if ($id == $_SESSION['user_id']) {
                        throw new Exception("You cannot delete your own account!");
                    }
                    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
                    $stmt->execute([$id]);
                    $message = "Admin deleted successfully!";
                    break;
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
        }
    }
}

// 4. Fetch All Users
$stmt = $conn->query("SELECT * FROM users ORDER BY id DESC");
$admins = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Admins</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin.css">
    <style>
        .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); }
        .modal-content { background-color: #fefefe; margin: 10% auto; padding: 20px; border: 1px solid #888; width: 50%; border-radius: 8px; }
        .close { color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer; }
        .close:hover { color: black; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group select { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        .btn { padding: 8px 15px; border: none; border-radius: 4px; cursor: pointer; color: white; }
        .btn-primary { background-color: #007bff; }
        .btn-danger { background-color: #dc3545; }
        .btn-warning { background-color: #ffc107; color: black; }
        .alert { padding: 10px; margin-bottom: 15px; border-radius: 4px; }
        .alert-success { background-color: #d4edda; color: #155724; }
        .alert-danger { background-color: #f8d7da; color: #721c24; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 0.85em; }
        .badge-super_admin { background-color: #28a745; color: white; }
        .badge-admin { background-color: #6c757d; color: white; }
    </style>
</head>
<body>
    <?php require_once __DIR__ . '/../src/View/partials/sidebar.php'; ?>

    <div class="main-content">
        <header>
            <h1>Manage Admins</h1>
        </header>

        <section class="admin-management">
            <?php if ($message): ?>
                <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <button class="btn btn-primary" onclick="openModal('create')">Add New Admin</button>
            <br><br>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($admins as $admin): ?>
                        <tr>
                            <td><?= htmlspecialchars($admin['id']) ?></td>
                            <td><?= htmlspecialchars($admin['username']) ?></td>
                            <td><?= htmlspecialchars($admin['email']) ?></td>
                            <td>
                                <span class="badge badge-<?= $admin['role'] ?>">
                                    <?= ucwords(str_replace('_', ' ', $admin['role'])) ?>
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-warning" onclick='editAdmin(<?= json_encode($admin) ?>)'>Edit</button>
                                <?php if ($admin['id'] != $_SESSION['user_id']): ?>
                                    <button class="btn btn-danger" onclick="deleteAdmin(<?= $admin['id'] ?>)">Delete</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </div>

    <!-- Modal -->
    <div id="adminModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 id="modalTitle">Add New Admin</h2>
            <form method="POST" id="adminForm">
                <input type="hidden" name="action" id="formAction" value="create">
                <input type="hidden" name="id" id="adminId">

                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" id="username" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select name="role" id="role">
                        <option value="admin">Admin</option>
                        <option value="super_admin">Super Admin</option>
                    </select>
                </div>
                <div class="form-group">
                    <label id="passwordLabel">Password</label>
                    <input type="password" name="password" id="password">
                    <small id="passwordHelp" style="display:none; color: #666;">Leave blank to keep current password</small>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('adminModal');
        const form = document.getElementById('adminForm');
        const modalTitle = document.getElementById('modalTitle');
        const formAction = document.getElementById('formAction');
        const adminId = document.getElementById('adminId');
        const usernameInput = document.getElementById('username');
        const emailInput = document.getElementById('email');
        const roleInput = document.getElementById('role');
        const passwordInput = document.getElementById('password');
        const passwordLabel = document.getElementById('passwordLabel');
        const passwordHelp = document.getElementById('passwordHelp');

        function openModal(mode) {
            modal.style.display = "block";
            if (mode === 'create') {
                modalTitle.innerText = "Add New Admin";
                formAction.value = "create";
                form.reset();
                passwordInput.required = true;
                passwordHelp.style.display = "none";
            }
        }

        function editAdmin(admin) {
            modal.style.display = "block";
            modalTitle.innerText = "Edit Admin";
            formAction.value = "update";
            adminId.value = admin.id;
            usernameInput.value = admin.username;
            emailInput.value = admin.email;
            roleInput.value = admin.role;
            
            passwordInput.value = "";
            passwordInput.required = false;
            passwordHelp.style.display = "block";
        }

        function closeModal() {
            modal.style.display = "none";
        }

        function deleteAdmin(id) {
            if (confirm("Are you sure you want to delete this admin?")) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.innerHTML = `<input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="${id}">`;
                document.body.appendChild(form);
                form.submit();
            }
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>
