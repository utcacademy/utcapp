<?php
session_start();
include 'includes/admin_header.php';
?>

<h1 class="mb-4">Welcome, <?php echo $_SESSION['admin_username']; ?> 👋</h1>
<p>Use the menu to manage courses, workshops, and registrations.</p>

<?php include 'includes/admin_footer.php'; ?>
