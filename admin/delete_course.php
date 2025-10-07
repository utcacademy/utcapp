<?php
include('../db.php');

if (!isset($_GET['id'])) {
    die("Invalid request");
}

$id = intval($_GET['id']);
$stmt = $conn->prepare("DELETE FROM courses1 WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: manage_courses.php?msg=Course deleted successfully");
    exit;
} else {
    echo "Error deleting course: " . $conn->error;
}
