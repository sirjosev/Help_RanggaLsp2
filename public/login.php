<?php
session_start();
require_once '../config/config.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $pass = $_POST['pass'];

    // Menggunakan PDO dan prepared statement dengan verifikasi password yang di-hash
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $conn->prepare($sql);

    try {
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check password: try password_verify first (for hashes), then plain text fallback
        $password_valid = false;
        if ($user) {
            if (password_verify($pass, $user['password'])) {
                $password_valid = true;
            } elseif ($pass === $user['password']) {
                $password_valid = true; // Fallback for plain text "123"
            }
        }

        if ($password_valid) {
            // Password cocok, buat session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            
            // Check for Super Admin status
            // 1. Check DB role (if column exists)
            $is_super_admin_db = isset($user['role']) && $user['role'] === 'super_admin';
            
            // 2. Check Config (Fallback/Bootstrap)
            $is_super_admin_config = in_array(strtolower($user['email']), array_map('strtolower', SUPER_ADMIN_EMAILS));
            
            $_SESSION['is_super_admin'] = $is_super_admin_db || $is_super_admin_config;

            // Redirect all logged-in users to the admin dashboard
            // Access control for specific pages (like manage_admins) is handled in those files
            header("Location: " . ADMIN_PATH_PREFIX . "/admin");
            exit();
        } else {
            // Email tidak ditemukan atau password salah
            $error = "Email atau password salah!";
        }
    } catch (PDOException $e) {
        // error_log("Login PDOException: " . $e->getMessage());
        $error = "Debug Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="assets/img/logo.png" alt="IMG">
                </div>

                <form class="login100-form validate-form" method="POST" action="">
                    <span class="login100-form-title">Welcome</span>

                    <?php
                    // Menampilkan pesan sukses registrasi atau error login
                    if (isset($_GET['status']) && $_GET['status'] == 'register_success') {
                        echo '<p style="color:green; text-align:center;">Registrasi berhasil! Silakan login.</p>';
                    } elseif ($error) {
                        echo '<p style="color:red; text-align:center;">' . $error . '</p>';
                    }
                    ?>

                    <div class="wrap-input100 validate-input" data-validate="Valid email is required">
                        <input class="input100" type="text" name="email" placeholder="Email" required>
                        <span class="focus-input100"></span>
                        <span class="symbol-input100"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <input class="input100" type="password" name="pass" placeholder="Password" required>
                        <span class="focus-input100"></span>
                        <span class="symbol-input100"><i class="fa fa-lock" aria-hidden="true"></i></span>
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" type="submit">Login</button>
                    </div>

                    <div class="text-center p-t-136">
                        <a class="txt2" href="register.php">
                            Create your Account
                            <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
    // Cek untuk status logout dan tampilkan pop-up jika ada
    if (isset($_GET['status']) && $_GET['status'] == 'logout_success') {
        echo "<script>alert('Anda telah berhasil logout.');</script>";
    }
    ?>
</body>
</html>
