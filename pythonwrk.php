<?php
$pageTitle = "10-Day Data Science Short Workshop";
$pageDescription = "Join our beginner-friendly 10-day Data Science short workshop for just ₹500. Learn Python, Data Analysis, Visualization & Machine Learning with hands-on practice.";
$activePage = "workshops";
include 'includes/header.php';
?>

<div class="container py-5">

  <!-- Workshop Title -->
  <div class="text-center mb-5">
    <h1 class="fw-bold text-primary">📅 10-Day Data Science Short Workshop</h1>
    <p class="lead text-muted">Learn the essentials of Data Science in 10 days – Python, Pandas, Visualization & ML.  
      <br><strong>Workshop Fee: ₹500 only</strong></p>
    <a href="register.php?workshop=ds10days" class="btn btn-lg btn-primary rounded-pill px-4">Register Now</a>
  </div>

  <!-- Highlights -->
  <div class="row mb-5">
    <div class="col-md-4">
      <div class="card shadow-sm p-4 h-100">
        <h5 class="text-primary">📌 Duration</h5>
        <p>10 Days, 1 hour daily</p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm p-4 h-100">
        <h5 class="text-primary">💻 Mode</h5>
        <p>Online (Google Meet)</p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm p-4 h-100">
        <h5 class="text-primary">🎯 Who Can Join?</h5>
        <p>Beginners, Students, and Anyone interested in Data Science</p>
      </div>
    </div>
  </div>

  <!-- Workshop Schedule -->
  <h3 class="section-title text-center mb-4">🗓 Workshop Schedule</h3>
  <ul class="list-group list-group-flush mb-5">
    <li class="list-group-item d-flex justify-content-between align-items-center">
      Day 1 – Python Basics & Vs Code Setup
      <span class="badge bg-warning text-dark">1 Sep</span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
      Day 2 – Data Types, Lists & Dictionaries
      <span class="badge bg-warning text-dark">2 Sep</span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
      Day 3 – NumPy Arrays & Operations
      <span class="badge bg-warning text-dark">3 Sep</span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
      Day 4 – Pandas DataFrames Basics
      <span class="badge bg-warning text-dark">4 Sep</span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
      Day 5 – Data Cleaning & Wrangling
      <span class="badge bg-warning text-dark">5 Sep</span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
      Day 6 – Exploratory Data Analysis (EDA)
      <span class="badge bg-warning text-dark">6 Sep</span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
      Day 7 – Visualization with Matplotlib
      <span class="badge bg-warning text-dark">7 Sep</span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
      Day 8 – Advanced Visualization with Seaborn
      <span class="badge bg-warning text-dark">8 Sep</span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
      Day 9 – Intro to Machine Learning - Regression
      <span class="badge bg-warning text-dark">9 Sep</span>
    </li>
    <li class="list-group-item d-flex justify-content-between align-items-center">
      Day 10 – Clustering & Final Project
      <span class="badge bg-warning text-dark">10 Sep</span>
    </li>
  </ul>

  <!-- Registration Call to Action -->
  <div class="text-center">
    <h4 class="fw-bold">🎟 Limited Seats Available!</h4>
    <p>Grab your spot in this hands-on 10-day Data Science workshop for just <strong>₹500</strong>.</p>
    <a href="register.php?workshop=ds10days" class="btn btn-lg btn-success rounded-pill px-4">Register Now</a>
  </div>

</div>

<?php include 'includes/footer.php'; ?>
