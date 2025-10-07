<?php
session_start();
include '../db.php';

// // ✅ Check admin login
// if (!isset($_SESSION['admin_id'])) {
//     header("Location: admin_login.php");
//     exit;
// }

// ✅ Handle delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM workshops1 WHERE id=$id");
    header("Location: admin_manage_workshops.php?msg=deleted");
    exit;
}

// ✅ Fetch all workshops
$result = $conn->query("SELECT * FROM workshops1 ORDER BY date DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - Manage Workshops</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
  <h2 class="mb-4">Manage Workshops</h2>

  <?php if (isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
    <div class="alert alert-danger">Workshop deleted successfully!</div>
  <?php endif; ?>

  <a href="admin_add_workshop.php" class="btn btn-primary mb-3">+ Add New Workshop</a>

  <table class="table table-bordered table-hover bg-white shadow-sm">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Date</th>
        <th>Time</th>
        <th>Trainer</th>
        <th>Price</th>
        <th>Notes</th>
        <th>Video</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= htmlspecialchars($row['title']) ?></td>
          <td><?= date("d M Y", strtotime($row['date'])) ?></td>
          <td><?= date("h:i A", strtotime($row['time'])) ?></td>
          <td><?= htmlspecialchars($row['trainer']) ?></td>
          <td>₹<?= $row['price'] ?></td>
          <td>
            <?php if (!empty($row['notes'])): ?>
              <a href="../<?= $row['notes'] ?>" target="_blank" class="btn btn-sm btn-info">View</a>
            <?php else: ?>
              <span class="text-muted">N/A</span>
            <?php endif; ?>
          </td>
          <td>
            <?php if (!empty($row['video_link'])): ?>
              <a href="<?= $row['video_link'] ?>" target="_blank" class="btn btn-sm btn-success">Watch</a>
            <?php else: ?>
              <span class="text-muted">N/A</span>
            <?php endif; ?>
          </td>
          <td>
            <a href="admin_edit_workshop.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
            <a href="?delete=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

</body>
</html>
