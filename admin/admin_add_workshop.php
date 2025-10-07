<?php
session_start();
include '../db.php';  // adjust path as per your project

// // ✅ Admin authentication check
// if (!isset($_SESSION['admin_id'])) {
//     header("Location: admin_login.php");
//     exit;
// }

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title       = $_POST['title'];
    $description = $_POST['description'];
    $date        = $_POST['date'];
    $time        = $_POST['time'];
    $price       = $_POST['price'];
    $trainer     = $_POST['trainer'];
    $video_link  = $_POST['video_link'];

    // Handle notes upload
    $notes = null;
    if (!empty($_FILES['notes']['name'])) {
        $targetDir = "../uploads/notes/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $notesFile = basename($_FILES['notes']['name']);
        $targetFile = $targetDir . time() . "_" . $notesFile;

        if (move_uploaded_file($_FILES['notes']['tmp_name'], $targetFile)) {
            $notes = "uploads/notes/" . time() . "_" . $notesFile;
        }
    }

    // Insert into DB
    $stmt = $conn->prepare("INSERT INTO workshops1 
        (title, description, date, time, price, trainer, notes, video_link) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssisss", $title, $description, $date, $time, $price, $trainer, $notes, $video_link);

    if ($stmt->execute()) {
        $message = "✅ Workshop added successfully!";
    } else {
        $message = "❌ Error: " . $stmt->error;
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - Add Workshop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
  <div class="card shadow-lg p-4">
    <h2 class="mb-4">Add New Workshop</h2>

    <?php if ($message): ?>
      <div class="alert alert-info"><?= $message ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <label class="form-label">Workshop Title</label>
        <input type="text" name="title" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="4" required></textarea>
      </div>

      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Date</label>
          <input type="date" name="date" class="form-control" required>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Time</label>
          <input type="time" name="time" class="form-control" required>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Price</label>
          <input type="number" name="price" class="form-control" required>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Trainer</label>
          <input type="text" name="trainer" class="form-control" required>
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Upload Notes (PDF/DOC)</label>
        <input type="file" name="notes" class="form-control" accept=".pdf,.doc,.docx">
      </div>

      <div class="mb-3">
        <label class="form-label">Video Link</label>
        <input type="text" name="video_link" class="form-control" placeholder="https://youtube.com/...">
      </div>

      <button type="submit" class="btn btn-primary">Add Workshop</button>
    </form>
  </div>
</div>

</body>
</html>
