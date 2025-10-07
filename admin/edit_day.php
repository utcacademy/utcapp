<?php
include '../db.php';

if (!isset($_GET['course_id'], $_GET['day_id'])) die("Invalid request");

$course_id = intval($_GET['course_id']);
$day_id = intval($_GET['day_id']);

// Fetch existing day
$stmt = $conn->prepare("SELECT * FROM days WHERE course_id = ? AND day_order = ?");
$stmt->bind_param("ii", $course_id, $day_id);
$stmt->execute();
$result = $stmt->get_result();
$day = $result->fetch_assoc();
if (!$day) die("Day not found");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $day_title = trim($_POST['day_title']);
    $day_order = intval($_POST['day_order']);

    if (!empty($day_title)) {
        $update = $conn->prepare("UPDATE days SET day_title = ?, day_order = ? WHERE course_id = ? AND day_order = ?");
        $update->bind_param("siii", $day_title, $day_order, $course_id, $day_id);
        if ($update->execute()) {
            header("Location: manage_days.php?course_id=$course_id");
            exit;
        } else {
            $error = "Error updating day: " . $conn->error;
        }
    } else {
        $error = "Day title cannot be empty";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Day</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <h2>Edit Day for Course ID: <?= $course_id ?></h2>

    <?php if (!empty($error)) echo '<div class="alert alert-danger">' . htmlspecialchars($error) . '</div>'; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Day Title</label>
            <input type="text" name="day_title" class="form-control" value="<?= htmlspecialchars($day['day_title']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Day Order</label>
            <input type="number" name="day_order" class="form-control" value="<?= $day['day_order'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Day</button>
        <a href="manage_days.php?course_id=<?= $course_id ?>" class="btn btn-secondary">Cancel</a>
    </form>
</body>
</html>
