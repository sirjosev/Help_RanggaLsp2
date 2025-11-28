<?php
session_start();
include 'config.php';

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

            if ($user && password_verify($pass, $user['password'])) {
            // Password cocok, buat session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['is_super_admin'] = ($user['email'] === SUPER_ADMIN_EMAIL);

            if ($_SESSION['is_super_admin']) {
                header("Location: " . ADMIN_PATH_PREFIX . "/admin"); // Arahkan ke dashboard admin dengan prefix rahasia
            } else {
                header("Location: index"); // Arahkan ke home untuk user biasa
            }
            exit();
        } else {
            // Email tidak ditemukan atau password salah
            $error = "Email atau password salah!";
        }
    } catch (PDOException $e) {
        // error_log("Login PDOException: " . $e->getMessage());
        $error = "Terjadi kesalahan pada sistem. Silakan coba lagi nanti.";
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
