<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$stmt = $conn->prepare("SELECT name, email, phone, organization, created_at FROM users WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<?php include('includes/header.php'); ?>

<section class="container py-5">
  <h2>My Profile</h2>
  
  <div class="card shadow-lg p-4" style="max-width:600px;margin:auto;">
    <div class="mb-3">
      <strong>Name:</strong> <?= htmlspecialchars($user['name']); ?>
    </div>
    <div class="mb-3">
      <strong>Email:</strong> <?= htmlspecialchars($user['email']); ?>
    </div>
    <div class="mb-3">
      <strong>Phone:</strong> <?= htmlspecialchars($user['phone']); ?>
    </div>
    <div class="mb-3">
      <strong>Organization:</strong> <?= htmlspecialchars($user['organization']); ?>
    </div>
    <div class="mb-3">
      <strong>Member Since:</strong> <?= date("d M Y", strtotime($user['created_at'])); ?>
    </div>
    
    <div class="d-flex justify-content-between mt-4">
      <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
      <a href="edit_profile.php" class="btn btn-primary">Edit Profile</a>
    </div>
  </div>
</section>

<?php include('includes/footer.php'); ?>
