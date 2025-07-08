<?php
session_start();
include 'config.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tidak perlu mysqli_real_escape_string dengan prepared statements PDO
    $email = $_POST['email'];
    $pass = $_POST['pass']; // Password masih plain text untuk saat ini

    // Menggunakan PDO dan prepared statement
    // TODO: Ganti pengecekan password plain text dengan password_verify() setelah password di-hash
    $sql = "SELECT * FROM users WHERE email = :email AND password = :password";
    $stmt = $conn->prepare($sql);

    try {
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $pass, PDO::PARAM_STR); // Asumsi password di DB belum di-hash
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Jika menggunakan password_hash:
            // if (password_verify($pass, $user['password'])) {
            //     $_SESSION['user_id'] = $user['id']; // Simpan user ID atau info lain yang relevan
            //     $_SESSION['email'] = $user['email'];
            //     header("Location: admin_blog.php"); // Atau ke admin.php sebagai dashboard utama
            //     exit();
            // } else {
            //     $error = "Email atau password salah!";
            // }

            // Untuk sementara karena password belum di-hash:
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            header("Location: admin_blog.php");
            exit();
        } else {
            $error = "Email atau password salah!";
        }
    } catch (PDOException $e) {
        // error_log("Login PDOException: " . $e->getMessage()); // Sebaiknya di-log ke file
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
                    if (isset($_GET['status']) && $_GET['status'] == 'logout_success'): ?>
                        <p style="color:green;">Anda telah berhasil logout.</p>
                    <?php endif; ?>

                    <?php if ($error): ?>
                        <p style="color:red;"><?= $error ?></p>
                    <?php endif; ?>

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
</body>
</html>
