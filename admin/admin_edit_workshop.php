<?php
session_start();
include '../db.php';

// // ✅ Admin check
// if (!isset($_SESSION['admin_id'])) {
//     header("Location: admin_login.php");
//     exit;
// }

$id = $_GET['id'] ?? null;
if (!$id) {
    die("Workshop ID missing.");
}

// ✅ Fetch workshop
$stmt = $conn->prepare("SELECT * FROM workshops1 WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    die("Workshop not found.");
}
$workshop = $result->fetch_assoc();
$stmt->close();

$message = "";

// ✅ Update on POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title       = $_POST['title'];
    $description = $_POST['description'];
    $date        = $_POST['date'];
    $time        = $_POST['time'];
    $price       = $_POST['price'];
    $trainer     = $_POST['trainer'];
    $video_link  = $_POST['video_link'];

    // Keep old notes by default
    $notes = $workshop['notes'];

    // If new notes uploaded
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

    $stmt = $conn->prepare("UPDATE workshops1 
        SET title=?, description=?, date=?, time=?, price=?, trainer=?, notes=?, video_link=? 
        WHERE id=?");
    $stmt->bind_param("ssssisssi", $title, $description, $date, $time, $price, $trainer, $notes, $video_link, $id);

    if ($stmt->execute()) {
        $message = "✅ Workshop updated successfully!";
        // Refresh workshop data
        $workshop['title']       = $title;
        $workshop['description'] = $description;
        $workshop['date']        = $date;
        $workshop['time']        = $time;
        $workshop['price']       = $price;
        $workshop['trainer']     = $trainer;
        $workshop['notes']       = $notes;
        $workshop['video_link']  = $video_link;
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
  <title>Edit Workshop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
  <div class="card shadow-lg p-4">
    <h2 class="mb-4">Edit Workshop</h2>

    <?php if ($message): ?>
      <div class="alert alert-info"><?= $message ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <label class="form-label">Workshop Title</label>
        <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($workshop['title']) ?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($workshop['description']) ?></textarea>
      </div>

      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Date</label>
          <input type="date" name="date" class="form-control" value="<?= $workshop['date'] ?>" required>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Time</label>
          <input type="time" name="time" class="form-control" value="<?= $workshop['time'] ?>" required>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Price</label>
          <input type="number" name="price" class="form-control" value="<?= $workshop['price'] ?>" required>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Trainer</label>
          <input type="text" name="trainer" class="form-control" value="<?= htmlspecialchars($workshop['trainer']) ?>" required>
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Current Notes</label><br>
        <?php if (!empty($workshop['notes'])): ?>
          <a href="../<?= $workshop['notes'] ?>" target="_blank" class="btn btn-sm btn-info">View Notes</a>
        <?php else: ?>
          <span class="text-muted">N/A</span>
        <?php endif; ?>
      </div>

      <div class="mb-3">
        <label class="form-label">Upload New Notes (optional)</label>
        <input type="file" name="notes" class="form-control" accept=".pdf,.doc,.docx">
      </div>

      <div class="mb-3">
        <label class="form-label">Video Link</label>
        <input type="text" name="video_link" class="form-control" value="<?= htmlspecialchars($workshop['video_link']) ?>">
      </div>

      <button type="submit" class="btn btn-success">Update Workshop</button>
      <a href="admin_manage_workshops.php" class="btn btn-secondary">Back</a>
    </form>
  </div>
</div>

</body>
</html>
