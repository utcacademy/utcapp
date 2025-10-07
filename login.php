<?php
session_start();
include 'db.php';

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if($user && password_verify($password,$user['password'])){
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : "dashboard.php";
        if(isset($_GET['id'])) $redirect .= "?id=".$_GET['id'];
        header("Location:$redirect");
        exit;
    } else {
        $error = "Invalid email or password";
    }
}
?>

<?php include('includes/header.php'); ?>
<section class="container py-5">
<h2>Login</h2>
<?php if(isset($error)) echo "<p class='text-danger'>$error</p>"; ?>
<form method="post">
  <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
  <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
  <button type="submit" name="login" class="btn btn-primary">Login</button>
</form>
<p class="mt-2">
    <a href="forgot_password.php">Forgot your password?</a>
</p>

<p class="mt-2">Don't have an account? <a href="signup.php">Sign Up here</a></p>
</section>
<?php include('includes/footer.php'); ?>
