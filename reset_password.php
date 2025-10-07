<?php
session_start();
include 'db.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Validate token
    $stmt = $conn->prepare("SELECT * FROM password_resets WHERE token=? AND expires > NOW() LIMIT 1");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $reset = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$reset) {
        die("Invalid or expired token.");
    }

    if (isset($_POST['change'])) {
        $newPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Update user password
        $stmt = $conn->prepare("UPDATE users SET password=? WHERE id=?");
        $stmt->bind_param("si", $newPassword, $reset['user_id']);
        $stmt->execute();
        $stmt->close();

        // Delete used token
        $stmt = $conn->prepare("DELETE FROM password_resets WHERE token=?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $stmt->close();

        echo "Password changed successfully. <a href='login.php'>Login</a>";
        exit;
    }
} else {
    die("Invalid request.");
}
?>
<?php include('includes/header.php'); ?>
<section class="container py-5">
    <h2>Reset Password</h2>
    <form method="post">
        <input type="password" name="password" class="form-control mb-2" placeholder="New Password" required>
        <button type="submit" name="change" class="btn btn-success">Change Password</button>
    </form>
</section>
<?php include('includes/footer.php'); ?>
