<?php
session_start();
include 'db.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id     = $_SESSION['user_id'];
$workshop_id = $_GET['workshop_id'] ?? null;

if (!$workshop_id) {
    die("Workshop not specified.");
}
?>

<?php include('includes/header.php'); ?>

<div class="container py-5">
    <h2 class="mb-4">Workshop Feedback</h2>
    <form action="save_feedback.php" method="POST" class="p-4 bg-light rounded shadow-sm">

        <!-- Hidden fields -->
        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
        <input type="hidden" name="workshop_id" value="<?php echo htmlspecialchars($workshop_id); ?>">

        <!-- Rating -->
        <div class="mb-3">
            <label for="rating" class="form-label">Rating (1–5)</label>
            <select name="rating" id="rating" class="form-select" required>
                <option value="">Select</option>
                <option value="1">⭐</option>
                <option value="2">⭐⭐</option>
                <option value="3">⭐⭐⭐</option>
                <option value="4">⭐⭐⭐⭐</option>
                <option value="5">⭐⭐⭐⭐⭐</option>
            </select>
        </div>

        <!-- Comments -->
        <div class="mb-3">
            <label for="comments" class="form-label">Comments</label>
            <textarea name="comments" id="comments" rows="3" class="form-control" required></textarea>
        </div>

        <!-- Learning -->
        <div class="mb-3">
            <label for="learning" class="form-label">Key Learnings</label>
            <textarea name="learning" id="learning" rows="3" class="form-control" required></textarea>
        </div>

        <!-- Suggestions -->
        <div class="mb-3">
            <label for="suggestions" class="form-label">Suggestions for Improvement</label>
            <textarea name="suggestions" id="suggestions" rows="3" class="form-control"></textarea>
        </div>

        <!-- Experience -->
        <div class="mb-3">
            <label for="experience" class="form-label">Overall Experience</label>
            <textarea name="experience" id="experience" rows="3" class="form-control" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit Feedback</button>
    </form>
</div>

<?php include('includes/footer.php'); ?>
