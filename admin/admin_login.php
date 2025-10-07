<?php
session_start();

// If already logged in, go to dashboard
if (isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_dashboard.php");
    exit();
}

// Handle login form
$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // --- Set your own admin credentials here ---
    $adminUser = "admin";
    $adminPass = "kcs@123"; // 🔐 Strong password recommended

    if ($username === $adminUser && $password === $adminPass) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Admin Login | Kovai Consultancy Services</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #2196F3, #009688);
      font-family: 'Nunito', sans-serif;
    }
    .login-box {
      max-width: 400px;
      margin: 100px auto;
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }
    .btn-primary {
      background-color: #009688;
      border: none;
    }
    .btn-primary:hover {
      background-color: #00796B;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="login-box text-center">
      <h2 class="mb-4 text-primary fw-bold">KCS Admin Login</h2>

      <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
      <?php endif; ?>

      <form method="post" action="">
        <div class="mb-3 text-start">
          <label for="username" class="form-label fw-bold">Username</label>
          <input type="text" class="form-control" name="username" id="username" required>
        </div>
        <div class="mb-3 text-start">
          <label for="password" class="form-label fw-bold">Password</label>
          <input type="password" class="form-control" name="password" id="password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100 py-2">Login</button>
      </form>
    </div>
  </div>
</body>
</html>
