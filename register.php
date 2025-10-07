<?php
include 'db.php';

if(!isset($_GET['id']) || empty($_GET['id'])){
    header("Location: workshops.php");
    exit;
}

$workshop_id = intval($_GET['id']);

// Fetch workshop info
$stmt = $conn->prepare("SELECT * FROM workshops1 WHERE id = ?");
$stmt->bind_param("i", $workshop_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows == 0){
    echo "<p class='text-center py-5'>Workshop not found.</p>";
    exit;
}

$workshop = $result->fetch_assoc();
$success = "";
$error = "";
// Handle form submission
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $organization = trim($_POST['organization']);

    if(empty($name) || empty($email) || empty($phone)){
        $error = "Please fill all required fields.";
    } else {
        $stmt = $conn->prepare("INSERT INTO workshop_registrations (workshop_id, name, email, phone, organization) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $workshop_id, $name, $email, $phone, $organization);
        if($stmt->execute()){
            // Redirect to thank you page with workshop id
            header("Location: thankyou.php?id=".$workshop_id);
            exit;
        } else {
            $error = "Registration failed. Please try again.";
        }
    }
}

?>
<?php include('includes/header.php');?>

<style>

.register-card {
    background: #1e293b;
    padding: 2rem;
    border-radius: 12px;
    max-width: 600px;
    margin: 2rem auto;
}
    </style>
<!-- Registration Form -->
<section class="register-card">
    <h2 class="mb-3 text-center">Register for "<?php echo $workshop['title']; ?>"</h2>
    <p class="text-center">Date: <?php echo date("d M Y", strtotime($workshop['date'])); ?> | Time: <?php echo date("h:i A", strtotime($workshop['time'])); ?></p>

    <?php if($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    <?php if($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label>Name <span class="text-warning">*</span></label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email <span class="text-warning">*</span></label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Phone <span class="text-warning">*</span></label>
            <input type="text" name="phone" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>College / Organization</label>
            <input type="text" name="organization" class="form-control">
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Register Now</button>
        </div>
    </form>
</section>

<?php include('includes/footer.php');?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
