<?php
include 'db.php';

if(!isset($_GET['id']) || empty($_GET['id'])){
    header("Location: courses.php");
    exit();
}

$course_id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM courses12 WHERE id = ?");
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows == 0){
    echo "<p class='text-center mt-5'>Course not found.</p>";
    exit();
}

$course = $result->fetch_assoc();

// Decode JSON syllabus and FAQ
$syllabus_days = json_decode($course['syllabus_days'], true);
$faqs = json_decode($course['faq'], true);
?>
<?php include('includes/header.php'); ?>

<style>
body { background: #0f172a; color: #e2e8f0; font-family: 'Inter', sans-serif; }
h2, h3 { font-weight: 700; }
.btn-primary { background: #22d3ee; border: none; border-radius: 50px; font-weight: 600; padding: 0.6rem 1.5rem; }
.btn-primary:hover { background: #06b6d4; }

/* Hero */
.hero { text-align: center; padding: 4rem 2rem; background: linear-gradient(135deg, #0ea5e9, #22d3ee); border-radius: 12px; color: #fff; margin-bottom: 2rem; }
.hero h1 { font-size: 2.2rem; margin-bottom: 0.8rem; }
.hero p { font-size: 1.1rem; }

/* Sections */
.section { background: #1e293b; border-radius: 12px; padding: 2rem; margin-top: 2rem; }
.section h2 { margin-bottom: 1rem; }

/* Info Grid */
.course-info { margin-top: 2rem; display: grid; grid-template-columns: repeat(auto-fit,minmax(200px,1fr)); gap: 1rem; }
.info-card { background: #0f172a; padding: 1rem; border-radius: 10px; text-align: center; }
.info-card .title { font-weight: bold; font-size: 1.3rem; color: #22d3ee; }
.info-card .sub { color: #cbd5e1; font-size: 0.9rem; }

/* Accordion */
/* Accordion */
.accordion { border-radius: 10px; overflow: hidden; }
.accordion-item { margin-bottom: 8px; border-radius: 8px; overflow: hidden; }

.accordion-header {
  background: linear-gradient(135deg, #0ea5e9, #22d3ee);
  color: #fff;
  padding: 1rem;
  cursor: pointer;
  font-weight: 600;
  border: none;
  transition: background 0.3s ease;
}

.accordion-header:hover {
  background: linear-gradient(135deg, #06b6d4, #0ea5e9);
}

.accordion-body {
  display: none;
  padding: 1rem;
  background: #f1f5f9;   /* light slate */
  color: #0f172a;         /* dark text */
  line-height: 1.6;
}

/* Sticky CTA */
.sticky-bar { position: fixed; bottom: 0; left: 0; right: 0; background: #0ea5e9; padding: 0.8rem; text-align: center; z-index: 999; }
.sticky-bar a { color: #fff; font-weight: 600; margin: 0 10px; }
</style>

<!-- Hero -->
<section class="hero">
  <h1><?php echo htmlspecialchars($course['title']); ?></h1>
  <p><?php echo htmlspecialchars($course['subtitle']); ?></p>
  <a href="#register" class="btn btn-primary mt-3">Enroll Now</a>
</section>

<!-- About -->
<section class="container section">
  <h2>About this Course</h2>
  <p><?php echo nl2br(htmlspecialchars($course['description'])); ?></p>
</section>

<!-- Pricing -->
<section class="container section" id="register">
  <h2>Course Pricing</h2>
  <div class="course-info">
    <div class="info-card">
      <div class="title">₹<?php echo number_format($course['fee_live']); ?></div>
      <div class="sub">Live Sessions</div>
      <form action="razorpay_checkout.php" method="POST">
        <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
        <input type="hidden" name="type" value="live">
        <button type="submit" class="btn btn-primary mt-2">Buy Live</button>
      </form>
    </div>
    <div class="info-card">
      <div class="title">₹<?php echo number_format($course['fee_recorded']); ?></div>
      <div class="sub">Recorded Videos</div>
      <form action="razorpay_checkout.php" method="POST">
        <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
        <input type="hidden" name="type" value="recorded">
        <button type="submit" class="btn btn-primary mt-2">Buy Recorded</button>
      </form>
    </div>
    <div class="info-card">
      <div class="title"><?php echo htmlspecialchars($course['duration']); ?></div>
      <div class="sub">Duration</div>
    </div>
    <div class="info-card">
      <div class="title"><?php echo htmlspecialchars($course['mode']); ?></div>
      <div class="sub">Mode</div>
    </div>
  </div>
</section>
<style>
.syllabus-section {
  background: #1e293b; /* dark slate */
  border-radius: 12px;
  padding: 2rem;
  margin-top: 2rem;
  color: #f1f5f9;
}
.accordion-item {
  background: #0f172a;
  border: none;
  margin-bottom: 8px;
  border-radius: 8px;
  overflow: hidden;
}
.accordion-button {
  background: #0f172a;
  color: #f1f5f9;
  font-weight: 600;
}
.accordion-button:not(.collapsed) {
  background: #22d3ee; /* cyan highlight */
  color: #0f172a;
}
.accordion-body {
  background: #1e293b;
  color: #e2e8f0;
}
.btn-primary {
  background: #22d3ee;
  border: none;
  border-radius: 50px;
  font-weight: 600;
}
.btn-primary:hover {
  background: #06b6d4;
}
</style>

<style>
.syllabus-section {
  background: #1e293b; /* dark slate */
  border-radius: 12px;
  padding: 2rem;
  margin-top: 2rem;
  color: #f1f5f9;
}
.accordion-item {
  background: #0f172a;
  border: none;
  margin-bottom: 8px;
  border-radius: 8px;
  overflow: hidden;
}
.accordion-button {
  background: #0f172a;
  color: #f1f5f9;
  font-weight: 600;
}
.accordion-button:not(.collapsed) {
  background: #22d3ee; /* cyan highlight */
  color: #0f172a;
}
.accordion-body {
  background: #1e293b;
  color: #e2e8f0;
}
.btn-primary {
  background: #22d3ee;
  border: none;
  border-radius: 50px;
  font-weight: 600;
}
.btn-primary:hover {
  background: #06b6d4;
}
</style>

<!-- Syllabus Section -->
<section class="container syllabus-section">
  <h2 class="mb-4">📘 Course Syllabus</h2>
  <div class="accordion" id="syllabusAccordion">
    <?php
      $syllabus_stmt = $conn->prepare("SELECT * FROM syllabus WHERE course_id = ? ORDER BY day_number ASC");
      $syllabus_stmt->bind_param("i", $course_id);
      $syllabus_stmt->execute();
      $syllabus_result = $syllabus_stmt->get_result();

      $index = 0;
      while($row = $syllabus_result->fetch_assoc()) {
        $day = $row['day_number'];
        $hiddenClass = ($index >= 5) ? "d-none extra-day" : "";

        echo '
        <div class="accordion-item '.$hiddenClass.'">
          <h2 class="accordion-header" id="heading'.$day.'">
            <button class="accordion-button collapsed" type="button"
              data-bs-toggle="collapse" data-bs-target="#collapse'.$day.'"
              aria-expanded="false" aria-controls="collapse'.$day.'">
              Day '.$day.': '.htmlspecialchars($row['topic']).'
            </button>
          </h2>
          <div id="collapse'.$day.'" class="accordion-collapse collapse"
            aria-labelledby="heading'.$day.'" data-bs-parent="#syllabusAccordion">
            <div class="accordion-body">
              <p><span style="color:#94a3b8">'.nl2br(htmlspecialchars($row['subtopics'])).'</span></p>
            </div>
          </div>
        </div>';
        $index++;
      }
    ?>
  </div>
  <div class="text-center mt-3">
    <button id="viewMoreBtn" class="btn btn-primary">View More</button>
  </div>
</section>

<script>
document.getElementById("viewMoreBtn").addEventListener("click", function() {
  document.querySelectorAll(".extra-day").forEach(d => d.classList.remove("d-none"));
  this.style.display = "none"; // hide button after showing
});
</script>


<!-- Trainer -->
<section class="container section">
  <h2>Your Trainer</h2>
  <div style="display:flex;align-items:center;gap:1rem;">
    
    <div>
      <h3><?php echo htmlspecialchars($course['trainer_name']); ?></h3>
      <p><?php echo nl2br(htmlspecialchars($course['trainer_details'])); ?></p>
    </div>
  </div>
</section>

<!-- FAQ -->
<section class="container section">
  <h2>FAQ</h2>
  <div class="accordion" id="faq">
    <?php if(!empty($faqs)){ 
      foreach($faqs as $faq){ ?>
        <div class="accordion-item">
          <div class="accordion-header"><?php echo htmlspecialchars($faq['question']); ?></div>
          <div class="accordion-body"><?php echo nl2br(htmlspecialchars($faq['answer'])); ?></div>
        </div>
    <?php } } ?>
  </div>
</section>

<!-- Sticky CTA -->
<div class="sticky-bar">
  <a href="#register">⚡ Buy Live (₹<?php echo number_format($course['fee_live']); ?>)</a>
  <a href="#register">🎥 Buy Recorded (₹<?php echo number_format($course['fee_recorded']); ?>)</a>
</div>

<script>
// Accordion toggle
document.querySelectorAll('.accordion-header').forEach(header => {
  header.addEventListener('click', () => {
    const body = header.nextElementSibling;
    body.style.display = (body.style.display === "block") ? "none" : "block";
  });
});
</script>

<br><br>
<?php include('includes/footer.php'); ?>
