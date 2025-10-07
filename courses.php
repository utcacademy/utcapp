<?php
include 'db.php';
include 'includes/header.php';

?>

<style>
  
.course-card {
  background: #1e293b;
  border-radius: 12px;
  padding: 1.5rem;
  transition: transform 0.3s, background 0.3s;
}
.course-card:hover {
  background: #334155;
  transform: translateY(-5px);
}
.btn-primary {
  background: #22d3ee;
  border: none;
  border-radius: 50px;
  font-weight: 600;
}
.btn-primary:hover { background: #06b6d4; }
</style>
<!-- Page Header -->
<section class="container py-5 text-center">
  <h1>All Courses</h1>
  <p>Explore our industry-relevant courses and boost your career</p>
  <input type="text" id="course-search" class="form-control search-bar mx-auto" placeholder="Search courses...">
</section>

<!-- Course Cards -->
<section class="container pb-5">
  <div class="row g-4" id="course-list">
    <?php
    $sql = "SELECT * FROM courses12 ORDER BY title ASC";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo '
            <div class="col-lg-4 col-md-6 course-item">
              <div class="course-card">
                <h5>'. $row['title'] .'</h5>
                <p>'. substr($row['description'], 0, 80) .'...</p>
                <p><strong>Duration:</strong> '. $row['duration'] .'</p>
                <p><strong>Fee:</strong> ₹'. number_format($row['fee_recorded'],2) .'</p>
                <a href="course-detail.php?id='. $row['id'] .'" class="btn btn-primary mt-2">View Details</a>
              </div>
            </div>';
        }
    } else {
        echo '<p class="text-center">No courses available at the moment.</p>';
    }
    ?>
  </div>
</section>

<?php include('includes/footer.php');?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Course Search JS -->
<script>
const searchInput = document.getElementById('course-search');
const courseList = document.getElementById('course-list');

searchInput.addEventListener('input', function(){
    const filter = this.value.toLowerCase();
    const items = document.querySelectorAll('.course-item');

    items.forEach(item => {
        const title = item.querySelector('h5').textContent.toLowerCase();
        const desc = item.querySelector('p').textContent.toLowerCase();
        if(title.includes(filter) || desc.includes(filter)){
            item.style.display = '';
        } else {
            item.style.display = 'none';
        }
    });
});
</script>

</body>
</html>
