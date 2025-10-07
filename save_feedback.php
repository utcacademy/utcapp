<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'] ?? null;
    $workshop_id = $_POST['workshop_id'] ?? null;
    $rating = $_POST['rating'] ?? null;
    $comments = $_POST['comments'] ?? null;
    $learning = $_POST['learning'] ?? null;
    $suggestions = $_POST['suggestions'] ?? null;
    $experience = $_POST['experience'] ?? null;

    if (!$user_id || !$workshop_id) {
        die("Missing user or workshop ID.");
    }

    // ✅ Save feedback
    $sql = "INSERT INTO feedback (user_id, workshop_id, rating, comments, learning, suggestions, experience) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("SQL error: " . $conn->error);
    }

    $stmt->bind_param("iiissss", $user_id, $workshop_id, $rating, $comments, $learning, $suggestions, $experience);

    if ($stmt->execute()) {
        // ✅ Also update registrations table
        $update = $conn->prepare("UPDATE registrations SET feedback_given = 1 WHERE user_id = ? AND workshop_id = ?");
        $update->bind_param("ii", $user_id, $workshop_id);
        $update->execute();
        $update->close();

        // Redirect back to dashboard
        header("Location: dashboard.php?feedback=success");
        exit;
    } else {
        echo "❌ Error executing query: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
