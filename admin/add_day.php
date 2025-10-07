<?php
include '../db.php';

if (!isset($_GET['course_id'])) die("Invalid course");

$course_id = intval($_GET['course_id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $day_title = trim($_POST['day_title']);
    $day_order = intval($_POST['day_order']);

    if (!empty($day_title)) {
        $stmt = $conn->prepare("INSERT INTO days (course_id, day_title, day_order) VALUES (?, ?, ?)");
        $stmt->bind_param("isi", $course_id, $day_title, $day_order);
        if ($stmt->execute()) {
            header("Location: manage_days.php?course_id=$course_id");
            exit;
        } else {
            $error = "Error adding day: " . $conn->error;
        }
    } else {
        $error = "Day title cannot be empty";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Day</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <h2>Add Day for Course ID: <?= $course_id ?></h2>

    <?php if (!empty($error)) echo '<div class="alert alert-danger">' . htmlspecialchars($error) . '</div>'; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Day Title</label>
            <input type="text" name="day_title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Day Order</label>
            <input type="number" name="day_order" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Add Day</button>
        <a href="manage_days.php?course_id=<?= $course_id ?>" class="btn btn-secondary">Cancel</a>
    </form>
</body>
</html>
