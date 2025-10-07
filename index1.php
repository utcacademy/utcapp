<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kovai Consultancy Services</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
  <style>
    :root {
      --base-bg: #0f172a;
      --accent: #22d3ee;
      --text-light: #f8fafc;
      --highlight-grad: linear-gradient(135deg, #4f46e5, #22d3ee);
      --btn-highlight: #facc15;
    }

    body { font-family: 'Segoe UI', sans-serif; background-color: var(--base-bg); color: var(--text-light); }

    /* Navbar */
    .navbar { background-color: #1e293b; }
    .navbar-brand { color: var(--accent) !important; font-weight: 700; font-size: 1.3rem; }
    .nav-link { color: var(--text-light) !important; transition: color 0.3s; }
    .nav-link:hover { color: var(--accent) !important; }

    .search-bar { width: 350px; position: relative; }
    
    /* Dropdown Style */
    #search-results, #hero-search-results {
      position: absolute; top: 100%; left: 0; width: 100%;
      background: #0f172a; border-radius: 12px; max-height: 300px; overflow-y: auto; z-index: 1000;
      box-shadow: 0 5px 15px rgba(0,0,0,0.3); display: none; padding: 0.5rem 0;
      animation: fadeIn 0.2s ease;
    }
    .result-item {
      padding: 0.75rem 1rem; border-bottom: 1px solid #334155; cursor: pointer; display: flex; flex-direction: column;
      transition: background 0.3s, transform 0.2s;
    }
    .result-item:last-child { border-bottom: none; }
    .result-item:hover { background: #1e293b; transform: translateX(5px); }
    .result-item a { color: var(--text-light); font-weight: 600; text-decoration: none; display: flex; align-items: center; }
    .result-item a span { margin-right: 0.5rem; }
    .result-item p { margin: 0; font-size: 0.85rem; color: #94a3b8; }

    @keyframes fadeIn { from {opacity: 0;} to {opacity: 1;} }

    /* Hero */
    .hero { background: var(--highlight-grad); color: white; padding: 5rem 1rem; text-align: center; overflow: hidden; position: relative; }
    .hero h1 { font-size: 3rem; font-weight: 700; }
    .hero p { font-size: 1.2rem; margin-top: 1rem; }
    .hero input { border-radius: 50px; padding: 0.75rem 1rem; border: none; width: 60%; max-width: 500px; position: relative; z-index: 2; }


.hero {
  background: var(--highlight-grad);
  color: white;
  padding: 5rem 1rem;
  text-align: center;
  position: relative; /* important for absolute dropdown */
  overflow: visible;  /* allow dropdown to show outside hero */
}

#hero-search-results {
  position: absolute;
  top: calc(100% + 0.25rem); /* slightly below input */
  left: 50%;
  transform: translateX(-50%);
  width: 60%;  /* match input width */
  max-width: 500px;
  background: #0f172a;
  border-radius: 12px;
  max-height: 300px;
  overflow-y: auto;
  z-index: 1050; /* high enough to appear above other content */
  display: none;
  padding: 0.5rem 0;
}

    /* Cards */
    .course-card { background: #1e293b; border-radius: 12px; transition: transform 0.3s, background 0.3s; color: var(--text-light); }
    .course-card:hover { background: #334155; transform: translateY(-5px); }
    .btn-primary { background-color: var(--accent); border: none; border-radius: 50px; font-weight: 600; }
    .btn-primary:hover { background-color: #06b6d4; }

    /* Testimonials */
    .testimonial { background: #1e293b; border-radius: 12px; padding: 2rem; text-align: center; color: var(--text-light); }
    .testimonial p { font-style: italic; }

    /* Footer */
    footer { background-color: #1e293b; color: var(--text-light); }
    footer h5 { color: var(--accent); font-weight: 600; }
    footer a { color: var(--text-light); text-decoration: none; transition: color 0.3s; }
    footer a:hover { color: var(--accent) !important; }
    .bottom-bar { background-color: #0f172a; text-align: center; padding: 0.75rem; font-size: 0.9rem; }

    /* Responsive Navbar Buttons */
    @media (max-width: 991px) {
      .navbar-nav .btn {
        width: 100%;
        margin: 0.25rem 0;
      }
      .search-bar { width: 100% !important; margin-bottom: 1rem; }
      #search-input { width: 100% !important; }
    }

  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="#">
      <img src="img/kcs-logo1.png" alt="KCS Logo" height="40" class="me-2">
      Kovai Consultancy
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <div class="mx-auto search-bar">
        <input id="search-input" class="form-control" type="search" placeholder="Search courses, workshops...">
        <div id="search-results"></div>
      </div>
      <ul class="navbar-nav ms-auto align-items-lg-center">
        <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="courses.php">Courses</a></li>
        <li class="nav-item"><a class="nav-link" href="workshops.php">Workshops</a></li>
        <li class="nav-item"><a class="nav-link" href="final-year-projects.php">Projects</a></li>
        <li class="nav-item ms-lg-3"><a href="login.php" class="btn btn-outline-light btn-sm">Login</a></li>
        <li class="nav-item ms-2"><a href="signup.php" class="btn btn-primary btn-sm">Sign Up</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Hero -->
<section class="hero">
  <div class="container position-relative">
    <h1>Learn Anytime, Anywhere</h1>
    <p>Access industry-relevant courses and workshops that empower your career.</p>
    <input type="text" id="hero-search" placeholder="What do you want to learn?">
    <div id="hero-search-results"></div>
  </div>
</section>

<!-- Popular Workshops -->
<section class="container py-5">
  <h2 class="text-center mb-4">Popular Workshops</h2>
  <div class="row g-4">
    <?php
    include 'db.php';
    $sql = "SELECT * FROM workshops1 LIMIT 3"; 
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
             echo '
    <div class="col-lg-4 col-md-6">
      <div class="course-card">
        <div class="p-3">
          <h5>' . $row['title'] . '</h5>
          <p>' . substr($row['description'], 0, 80) . '...</p>
          <p><strong>Date:</strong> ' . date("d M Y", strtotime($row['date'])) . '</p>
          <p><strong>Time:</strong> ' . date("h:i A", strtotime($row['time'])) . '</p>
          <a href="workshop-detail.php?id=' . $row['id'] . '" class="btn btn-primary mt-3">View Details</a>
        </div>
      </div>
    </div>';
        }
    } else { echo "<p class='text-center'>No workshops available right now.</p>"; }
    ?>
  </div>
</section>

<!-- Popular Courses -->
<section class="container py-5">
  <h2 class="text-center mb-4">Popular Courses</h2>
  <div class="row g-4">
    <?php
      $sql = "SELECT * FROM courses1 LIMIT 3"; 
      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()){
              echo '
              <div class="col-lg-4 col-md-6">
                <div class="course-card">
                  <div class="p-3">
                    <h5>'. $row['title'] .'</h5>
                    <p>'. substr($row['description'], 0, 100) .'...</p>
                    <p><strong>Duration:</strong> '. $row['duration'] .'</p>
                    <p><strong>Price:</strong> ₹'. number_format($row['fee'], 2) .'</p>
                    <a href="course-detail.php?id='. $row['id'] .'" class="btn btn-primary btn-sm mt-2">View Details</a>
                  </div>
                </div>
              </div>';
          }
      } else { echo '<p class="text-center">No courses available right now.</p>'; }
    ?>
  </div>
</section>

<!-- Testimonials -->
<section class="container py-5">
  <h2 class="text-center mb-4">What Our Students Say</h2>
  <div class="row g-4">
    <div class="col-md-4"><div class="testimonial"><p>"KCS courses helped me land my dream job in Data Science."</p><strong>- Priya, Data Scientist</strong></div></div>
    <div class="col-md-4"><div class="testimonial"><p>"The workshops are highly practical and industry-focused."</p><strong>- Arjun, Software Engineer</strong></div></div>
    <div class="col-md-4"><div class="testimonial"><p>"Final year project guidance from KCS made my academics shine."</p><strong>- Kavya, B.Tech Student</strong></div></div>
  </div>
</section>

<!-- Footer -->
<footer class="text-white mt-5">
  <div class="container py-4">
    <div class="row">
      <div class="col-md-6"><h5>Kovai Consultancy Services</h5><p>Empowering careers with industry-ready courses, hands-on workshops, and project guidance.</p></div>
      <div class="col-md-3"><h5>Quick Links</h5><ul class="list-unstyled"><li><a href="courses.php">Courses</a></li><li><a href="workshops.php">Workshops</a></li><li><a href="final-year-projects.php">Projects</a></li></ul></div>
      <div class="col-md-3"><h5>Contact</h5><p>📞 +91 99523 82360<br>📧 info@aakkamkcs.com</p></div>
    </div>
  </div>
  <div class="bottom-bar"><p class="mb-0">&copy; 2025 Kovai Consultancy. All Rights Reserved.</p></div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // Live search
  const searchInput = document.getElementById('search-input');
  const searchResults = document.getElementById('search-results');

  const heroInput = document.getElementById('hero-search');
  const heroResults = document.getElementById('hero-search-results');

  function liveSearch(inputElem, resultsElem){
    inputElem.addEventListener('input', function(){
      const query = this.value.trim();
      if(query.length < 2){ resultsElem.style.display='none'; return; }
      fetch('search.php?q='+encodeURIComponent(query))
        .then(res => res.text())
        .then(data => {
          resultsElem.innerHTML = data;
          resultsElem.style.display = 'block';
        });
    });

    document.addEventListener('click', function(e){
      if(!inputElem.contains(e.target) && !resultsElem.contains(e.target)){
        resultsElem.style.display='none';
      }
    });
  }

  liveSearch(searchInput, searchResults);
  liveSearch(heroInput, heroResults);
</script>

</body>
</html>
