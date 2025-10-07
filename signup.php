<?php
session_start();
include 'db.php';

if (isset($_POST['signup'])) {
    $name = trim($_POST['name']);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $phone = preg_replace('/\D/', '', $_POST['phone']); // remove non-digits
    $organization = trim($_POST['organization']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    // Auto add +91 if missing
    if (strlen($phone) === 10) {
        $phone = '+91' . $phone;
    } elseif (strlen($phone) === 12 && substr($phone, 0, 2) === '91') {
        $phone = '+' . $phone;
    }

    // Validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email address";
    } elseif (strlen($password) < 8) {
        $error = "Password must be at least 8 characters long";
    } elseif ($password !== $confirm) {
        $error = "Passwords do not match";
    } elseif (!preg_match('/^\+91[0-9]{10}$/', $phone)) {
        $error = "Please enter a valid phone number with +91";
    } else {
        // Check email exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            $error = "Email already registered";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (name,email,phone,organization,password) VALUES (?,?,?,?,?)");
            $stmt->bind_param("sssss", $name, $email, $phone, $organization, $hashedPassword);
            $stmt->execute();

            $_SESSION['user_id'] = $conn->insert_id;
            $_SESSION['name'] = $name;

            $redirect = $_GET['redirect'] ?? "dashboard.php";
            if (isset($_GET['id'])) $redirect .= "?id=" . $_GET['id'];

            header("Location: $redirect");
            exit;
        }
    }
}
?>

<?php include('includes/header.php'); ?>
<section class="container py-5">
  <h2>Create an Account</h2>
  <?php if (isset($error)) echo "<p class='text-danger'>$error</p>"; ?>

  <form method="post">
    <input type="text" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" class="form-control mb-2" placeholder="Full Name" required>
    <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" class="form-control mb-2" placeholder="Email" required>
    <input type="text" name="phone" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>" class="form-control mb-2" placeholder="Phone Number (10 digits)" required pattern="[0-9]{10}">
    <input type="text" name="organization" value="<?= htmlspecialchars($_POST['organization'] ?? '') ?>" class="form-control mb-2" placeholder="Organization / College Name" required>
    <input type="password" name="password" class="form-control mb-2" placeholder="Password (min 8 chars)" required>
    <input type="password" name="confirm_password" class="form-control mb-2" placeholder="Confirm Password" required>
    
    <button type="submit" name="signup" class="btn btn-primary">Sign Up</button>
  </form>

  <p class="mt-2">Already have an account? <a href="login.php">Login here</a></p>
</section>
<?php include('includes/footer.php'); ?>
