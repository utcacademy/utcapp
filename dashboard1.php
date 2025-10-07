<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Counts
$workshops_count = $conn->query("SELECT COUNT(*) as c FROM registrations WHERE user_id=$user_id")->fetch_assoc()['c'];
$courses_count   = $conn->query("SELECT COUNT(*) as c FROM registrations WHERE user_id=$user_id")->fetch_assoc()['c'];

// Fetch Workshops (limit preview if needed)
$workshops = $conn->query("SELECT w.title, w.date, w.time 
                           FROM workshops1 w 
                           JOIN registrations r ON w.id=r.workshop_id 
                           WHERE r.user_id=$user_id ORDER BY w.date DESC");

// Fetch Courses
$courses = $conn->query("SELECT c.title, c.start_date 
                         FROM courses c 
                         JOIN course_registrations cr ON c.id=cr.course_id 
                         WHERE cr.user_id=$user_id ORDER BY c.start_date DESC");
?>
<?php include('includes/header.php'); ?>

<div class="container py-5">
  <h2 class="mb-4">Welcome, <?= htmlspecialchars($_SESSION['name']); ?></h2>

  <div class="row g-4">
    <!-- Workshops -->
    <div class="col-md-6">
      <div class="card text-center shadow-sm h-100">
        <div class="card-body">
          <i class="bi bi-easel2 fs-2 text-primary"></i>
          <h5 class="card-title mt-2">Workshops</h5>
          <p class="display-6"><?= $workshops_count ?></p>
          <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#workshopsList">View More</button>
        </div>
        <!-- Expandable Section -->
        <div id="workshopsList" class="collapse text-start p-3">
          <?php if($workshops->num_rows > 0): ?>
            <ul class="list-group list-group-flush">
              <?php while($w = $workshops->fetch_assoc()): ?>
                <li class="list-group-item">
                  <strong><?= htmlspecialchars($w['title']); ?></strong><br>
                  <small><?= date("d M Y", strtotime($w['date'])); ?> at <?= date("h:i A", strtotime($w['time'])); ?></small>
                </li>
              <?php endwhile; ?>
            </ul>
          <?php else: ?>
            <p>No workshops registered.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Courses -->
    <div class="col-md-6">
      <div class="card text-center shadow-sm h-100">
        <div class="card-body">
          <i class="bi bi-journal-bookmark fs-2 text-success"></i>
          <h5 class="card-title mt-2">Courses</h5>
          <p class="display-6"><?= $courses_count ?></p>
          <button class="btn btn-sm btn-outline-success" data-bs-toggle="collapse" data-bs-target="#coursesList">View More</button>
        </div>
        <!-- Expandable Section -->
        <div id="coursesList" class="collapse text-start p-3">
          <?php if($courses->num_rows > 0): ?>
            <ul class="list-group list-group-flush">
              <?php while($c = $courses->fetch_assoc()): ?>
                <li class="list-group-item">
                  <strong><?= htmlspecialchars($c['title']); ?></strong><br>
                  <small>Starts on <?= date("d M Y", strtotime($c['start_date'])); ?></small>
                </li>
              <?php endwhile; ?>
            </ul>
          <?php else: ?>
            <p>No courses registered.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include('includes/footer.php'); ?>
