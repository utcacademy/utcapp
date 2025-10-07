<?php
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: ../admin_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>KCS Admin Panel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <style>
    .navbar {
      background: linear-gradient(135deg, #2196F3, #009688);
    }
    .navbar-brand, .nav-link {
      color: #fff !important;
      font-weight: 600;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg shadow">
    <div class="container-fluid">
      <a class="navbar-brand" href="admin_dashboard.php">KCS Admin</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a href="admin_dashboard.php" class="nav-link">Dashboard</a></li>
          <li class="nav-item"><a href="courses_manage.php" class="nav-link">Courses</a></li>
          <li class="nav-item"><a href="workshops.php" class="nav-link">Workshops</a></li>
          <li class="nav-item"><a href="registrations.php" class="nav-link">Registrations</a></li>
          <li class="nav-item"><a href="logout.php" class="nav-link">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container py-4">
