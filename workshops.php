<?php
include 'db.php';
if (session_status() == PHP_SESSION_NONE) session_start();

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

// Fetch all workshops
$sql = "SELECT * FROM workshops1 where highlighted=1 ORDER BY date ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workshops | Kovai Consultancy Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #0f172a; color: #f8fafc; font-family: 'Segoe UI', sans-serif; }
        .navbar { background: #1e293b; }
        .navbar-brand { color: #22d3ee !important; font-weight: 700; }
        .nav-link { color: #f8fafc !important; }
        .workshop-card { background: #1e293b; padding: 1.5rem; border-radius: 12px; margin-bottom: 1.5rem; transition: transform 0.3s; }
        .workshop-card:hover { transform: translateY(-5px); background: #334155; }
        .btn-primary { background: #22d3ee; border: none; border-radius: 50px; font-weight: 600; }
        .btn-primary:hover { background: #06b6d4; }
        .btn-secondary { border-radius: 50px; }
        .search-bar { max-width: 400px; margin-bottom: 1rem; }
    </style>
</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="container py-5">
    <h1 class="mb-4">Our Workshops</h1>

    <!-- Search Bar -->
    <input type="text" id="search-input" class="form-control search-bar" placeholder="Search workshops...">

    <div class="row g-4" id="workshop-list">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                // Check if user already registered
                $is_registered = false;
                if ($user_id) {
                    $stmt = $conn->prepare("SELECT id FROM registrations WHERE user_id = ? AND workshop_id = ?");
                    $stmt->bind_param("ii", $user_id, $row['id']);
                    $stmt->execute();
                    $check = $stmt->get_result();
                    $is_registered = ($check->num_rows > 0);
                }
                ?>
                <div class="col-lg-4 col-md-6 workshop-item">
                    <div class="workshop-card">
                        <h5><?php echo $row['title']; ?></h5>
                        <p><?php echo substr($row['description'], 0, 80); ?>...</p>
                        <p><strong>Date:</strong> <?php echo date("d M Y", strtotime($row['date'])); ?></p>
                        <p><strong>Time:</strong> <?php echo date("h:i A", strtotime($row['time'])); ?></p>

                        <?php if ($user_id): ?>
                            <?php if ($is_registered): ?>
                                <button class="btn btn-secondary mt-2" disabled>Registered</button>
                            <?php else: ?>
                                <a href="register-workshop.php?id=<?php echo $row['id']; ?>" class="btn btn-primary mt-2">Register</a>
                            <?php endif; ?>
                        <?php else: ?>
                            <a href="login.php" class="btn btn-primary mt-2">Login to Register</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php
            }
        } else {
            echo '<p class="text-center">No workshops available at the moment.</p>';
        }
        ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Simple Search Filter
    const searchInput = document.getElementById('search-input');
    const workshopList = document.getElementById('workshop-list');
    const workshops = workshopList.getElementsByClassName('workshop-item');

    searchInput.addEventListener('input', function () {
        const filter = searchInput.value.toLowerCase();
        Array.from(workshops).forEach(function (item) {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(filter) ? '' : 'none';
        });
    });
</script>

<?php include 'includes/footer.php'; ?>
</body>
</html>
