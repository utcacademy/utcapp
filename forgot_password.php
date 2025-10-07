<?php
session_start();
include 'db.php';

if (isset($_POST['reset'])) {
    $email = trim($_POST['email']);

    // Check if user exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email=? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if ($user) {
        // Generate reset token (valid for 1 hour)
        $token = bin2hex(random_bytes(32));
        $expires = date("Y-m-d H:i:s", strtotime("+1 hour"));

        // Save token
        $stmt = $conn->prepare("INSERT INTO password_resets (user_id, token, expires) VALUES (?,?,?)");
        $stmt->bind_param("iss", $user['id'], $token, $expires);
        $stmt->execute();
        $stmt->close();

        // Send email with reset link (replace with your mail logic)
        $resetLink = "https://aakkamkcs.com/kcs/reset_password.php?token=$token";
        mail($email, "Password Reset Request", "Click here to reset your password: $resetLink");

        $success = "Password reset link has been sent to your email.";
    } else {
        $error = "No account found with that email.";
    }
}
?>
<?php include('includes/header.php'); ?>
<section class="container py-5">
    <h2>Forgot Password</h2>
    <?php if (isset($error)) echo "<p class='text-danger'>$error</p>"; ?>
    <?php if (isset($success)) echo "<p class='text-success'>$success</p>"; ?>
    <form method="post">
        <input type="email" name="email" class="form-control mb-2" placeholder="Enter your email" required>
        <button type="submit" name="reset" class="btn btn-primary">Send Reset Link</button>
    </form>
</section>
<?php include('includes/footer.php'); ?>
