<?php
include('../db.php');

if (!isset($_GET['id'])) {
    die("Invalid request");
}

$id = intval($_GET['id']);

// Fetch existing course data
$stmt = $conn->prepare("SELECT title, description FROM courses1 WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$course = $result->fetch_assoc();

if (!$course) {
    die("Course not found");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    if (!empty($title)) {
        $updateStmt = $conn->prepare("UPDATE courses1 SET title = ?, description = ? WHERE id = ?");
        $updateStmt->bind_param("ssi", $title, $description, $id);
        if ($updateStmt->execute()) {
            header("Location: manage_courses.php?msg=Course updated successfully");
            exit;
        } else {
            $error = "Error updating course: " . $conn->error;
        }
    } else {
        $error = "Course title cannot be empty!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Course</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <h2 class="mb-4">Edit Course</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Course Title</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($course['title']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="5"><?= htmlspecialchars($course['description']) ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Course</button>
        <a href="manage_courses.php" class="btn btn-secondary">Cancel</a>
    </form>
</body>
</html>
