<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch current details
$stmt = $conn->prepare("SELECT name, phone, organization, email FROM users WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Update on form submit
if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $organization = $_POST['organization'];
    $password = $_POST['password'];

    if (!empty($password)) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET name=?, phone=?, organization=?, password=? WHERE id=?");
        $stmt->bind_param("ssssi", $name, $phone, $organization, $hashed, $user_id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET name=?, phone=?, organization=? WHERE id=?");
        $stmt->bind_param("sssi", $name, $phone, $organization, $user_id);
    }

    if ($stmt->execute()) {
        $_SESSION['name'] = $name; // update session name
        $success = "Profile updated successfully!";
        // Refresh details
        $user['name'] = $name;
        $user['phone'] = $phone;
        $user['organization'] = $organization;
    } else {
        $error = "Something went wrong. Please try again.";
    }
}
?>

<?php include('includes/header.php'); ?>

<section class="container py-2">
    <div  class="card shadow-lg p-4">
  <h2 style="text-align:center;">Edit Profile</h2>
  <?php if(isset($success)) echo "<p class='text-success'>$success</p>"; ?>
  <?php if(isset($error)) echo "<p class='text-danger'>$error</p>"; ?>

  <form method="post" style="max-width:600px;margin:auto;">
    <div class="mb-3">
      <label class="form-label">Full Name</label>
      <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name']); ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Phone (+91)</label>
      <input type="text" name="phone" class="form-control" 
             value="<?= htmlspecialchars($user['phone']); ?>"  
             placeholder="1234567890" required>
      <div class="form-text">Format: +91XXXXXXXXXX</div>
    </div>

    <div class="mb-3">
      <label class="form-label">Organization / College</label>
      <input type="text" name="organization" class="form-control" 
             value="<?= htmlspecialchars($user['organization']); ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Email (cannot change)</label>
      <input type="email" class="form-control" value="<?= htmlspecialchars($user['email']); ?>" disabled>
    </div>

    <div class="mb-3">
      <label class="form-label">New Password (leave blank if not changing)</label>
      <input type="password" name="password" class="form-control" placeholder="Enter new password">
    </div>

    <div class="d-flex justify-content-between">
      <a href="profile.php" class="btn btn-secondary">Cancel</a>
      <button type="submit" name="update" class="btn btn-primary">Update Profile</button>
    </div>
  </form>
</div>
</section>

<?php include('includes/footer.php'); ?>
