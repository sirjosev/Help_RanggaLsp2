<?php
require_once '../config/config.php';

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $pass     = $_POST['pass'];
    $confirm  = $_POST['confirm-pass'];

    if (empty($username) || empty($email) || empty($pass)) {
        $error = "Semua field wajib diisi.";
    } elseif ($pass !== $confirm) {
        $error = "Password dan konfirmasi tidak cocok!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid.";
    } else {
        try {
            // 1. Cek apakah email sudah ada menggunakan PDO
            $sql_check = "SELECT id FROM users WHERE email = :email";
            $stmt_check = $conn->prepare($sql_check);
            $stmt_check->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt_check->execute();

            if ($stmt_check->fetch()) {
                $error = "Email sudah terdaftar!";
            } else {
                // 2. Hash password
                $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

                // 3. Insert user baru dengan password yang sudah di-hash
                $sql_insert = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
                $stmt_insert = $conn->prepare($sql_insert);
                $stmt_insert->bindParam(':username', $username, PDO::PARAM_STR);
                $stmt_insert->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt_insert->bindParam(':password', $hashed_pass, PDO::PARAM_STR);

                if ($stmt_insert->execute()) {
                    // Redirect ke login dengan pesan sukses
                    header("Location: login.php?status=register_success");
                    exit();
                } else {
                    $error = "Gagal mendaftar. Silakan coba lagi.";
                }
            }
        } catch (PDOException $e) {
            // error_log("Registration PDOException: " . $e->getMessage());
            $error = "Terjadi kesalahan pada sistem. Silakan coba lagi nanti.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Register</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="css/register.css">
</head>

<body>
  <div class="limiter">
    <div class="container-login100">
      <div class="wrap-login100">
        <div class="login100-pic js-tilt" data-tilt>
          <img src="assets/img/logo.png" alt="IMG">
        </div>

        <form class="login100-form validate-form" method="POST" action="">
          <span class="login100-form-title">
            Create Account
          </span>

          <!-- Pesan error atau sukses -->
          <?php if ($error): ?>
            <p style="color:red; text-align:center;"><?= $error ?></p>
          <?php endif; ?>

          <?php if ($success): ?>
            <p style="color:green; text-align:center;"><?= $success ?></p>
          <?php endif; ?>

          <div class="wrap-input100 validate-input" data-validate="Username is required">
            <input class="input100" type="text" name="username" placeholder="Username" required>
            <span class="focus-input100"></span>
            <span class="symbol-input100">
              <i class="fa fa-user" aria-hidden="true"></i>
            </span>
          </div>

          <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
            <input class="input100" type="text" name="email" placeholder="Email" required>
            <span class="focus-input100"></span>
            <span class="symbol-input100">
              <i class="fa fa-envelope" aria-hidden="true"></i>
            </span>
          </div>

          <div class="wrap-input100 validate-input" data-validate="Password is required">
            <input class="input100" type="password" name="pass" placeholder="Password" required>
            <span class="focus-input100"></span>
            <span class="symbol-input100">
              <i class="fa fa-lock" aria-hidden="true"></i>
            </span>
          </div>

          <div class="wrap-input100 validate-input" data-validate="Please confirm your password">
            <input class="input100" type="password" name="confirm-pass" placeholder="Confirm Password" required>
            <span class="focus-input100"></span>
            <span class="symbol-input100">
              <i class="fa fa-lock" aria-hidden="true"></i>
            </span>
          </div>

          <div class="container-login100-form-btn">
            <button class="login100-form-btn" type="submit">
              Create Account
            </button>
          </div>

          <div class="text-center p-t-136">
            <a class="txt2" href="login.php">
              Already have an account? Login
              <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
