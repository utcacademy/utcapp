<?php
include 'db.php';
if (session_status() == PHP_SESSION_NONE) session_start();

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

// Check if ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: workshops.php");
    exit;
}

$workshop_id = intval($_GET['id']);

// Fetch workshop details
$stmt = $conn->prepare("SELECT * FROM workshops1 where highlighted=1 and  id = ?");
$stmt->bind_param("i", $workshop_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<p class='text-center py-5'>Workshop not found.</p>";
    exit;
}

$workshop = $result->fetch_assoc();

// Check if user already registered
$is_registered = false;
if ($user_id) {
    $stmt2 = $conn->prepare("SELECT id FROM registrations WHERE user_id = ? AND workshop_id = ?");
    $stmt2->bind_param("ii", $user_id, $workshop_id);
    $stmt2->execute();
    $check = $stmt2->get_result();
    $is_registered = ($check->num_rows > 0);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $workshop['title']; ?> | Kovai Consultancy Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #0f172a; color: #f8fafc; font-family: 'Segoe UI', sans-serif; }
        .workshop-detail { background: #1e293b; padding: 2rem; border-radius: 12px; margin-top: 2rem; }
        .btn-primary { background: #22d3ee; border: none; border-radius: 50px; font-weight: 600; }
        .btn-primary:hover { background: #06b6d4; }
        .btn-secondary { border-radius: 50px; }
    </style>
</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="container py-5">
    <div class="workshop-detail">
        <h2><?php echo $workshop['title']; ?></h2>
        <p><?php echo nl2br($workshop['description']); ?></p>
        <p><strong>Date:</strong> <?php echo date("d M Y", strtotime($workshop['date'])); ?></p>
        <p><strong>Time:</strong> <?php echo date("h:i A", strtotime($workshop['time'])); ?></p>
        <p><strong>Fee:</strong> ₹<?php echo number_format($workshop['price'], 2); ?></p>

        <?php if ($user_id): ?>
            <?php if ($is_registered): ?>
                <button class="btn btn-secondary mt-3" disabled>Registered</button>
            <?php else: ?>
                <a href="register-workshop.php?id=<?php echo $workshop['id']; ?>" class="btn btn-primary mt-3">Register Now</a>
            <?php endif; ?>
        <?php else: ?>
            <a href="login.php" class="btn btn-primary mt-3">Login to Register</a>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
