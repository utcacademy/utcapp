<?php
include '../db.php';

if (!isset($_GET['course_id'], $_GET['day_id'])) die("Invalid request");

$course_id = intval($_GET['course_id']);
$day_id = intval($_GET['day_id']);

$stmt = $conn->prepare("DELETE FROM days WHERE course_id = ? AND day_order = ?");
$stmt->bind_param("ii", $course_id, $day_id);

if ($stmt->execute()) {
    header("Location: manage_days.php?course_id=$course_id");
    exit;
} else {
    echo "Error deleting day: " . $conn->error;
}
