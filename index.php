<?php include('includes/header.php');?>
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
    $sql = "SELECT * FROM workshops1 where highlighted=1 LIMIT 3"; 
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
      $sql = "SELECT * FROM courses12 LIMIT 3"; 
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
                    <p><strong>Price:</strong> ₹'. number_format($row['fee_live'], 2) .'</p>
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
<?php include('includes/footer.php');?>

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
