<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>UTC Academy - Python Full Stack Development</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<style>
  body { font-family: 'Arial', sans-serif; scroll-behavior: smooth; }
  
  /* Reduced Hero Section */
  .hero {
    height: 50vh;
    padding: 40px 20px;
    background: linear-gradient(rgba(139,0,0,0.8), rgba(139,0,0,0.8)), url('hero-bg.jpg') center/cover no-repeat;
    color: #FFD700;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
  }
  .hero h1 { font-size:2.5rem; font-weight:bold; }
  .hero p { font-size:1.1rem; margin-bottom:15px; }
  .cta-btn { background: linear-gradient(to right, #FFD700, #FFA500); color: #8B0000; font-weight:bold; padding:12px 30px; border-radius:8px; border:none; transition: transform 0.3s; }
  .cta-btn:hover { transform: scale(1.1); color:white; }

  section { padding:80px 0; }
  .section-title { text-align:center; font-size:2rem; color:#8B0000; margin-bottom:50px; position:relative; }
  .section-title::after { content:''; width:80px; height:3px; background:#FFD700; display:block; margin:10px auto 0; border-radius:3px; }

  .syllabus-card { border-radius:15px; padding:20px; box-shadow:0 4px 15px rgba(0,0,0,0.2); margin-bottom:20px; transition: transform 0.3s; background:#fff; }
  .syllabus-card:hover { transform: translateY(-5px); }

  blockquote { font-style:italic; background:#f9f9f9; padding:20px; border-left:5px solid #8B0000; border-radius:5px; }

  footer { background:#8B0000; color:#FFD700; padding:40px 0; text-align:center; }
  .social-icons a { color:#FFD700; margin:0 10px; font-size:1.5rem; transition: color 0.3s; }
  .social-icons a:hover { color:#FFA500; }
</style>
</head>
<body>

<!-- Hero Section -->
<section class="hero">
  <h1>Python Full Stack Development</h1>
  <p>8 Weeks | Live & Recorded | Build Real Projects</p>
  <a href="#register" class="cta-btn">Enroll Now</a>
</section>

<!-- Course Highlights -->
<section class="container">
  <h2 class="section-title">Course Highlights</h2>
  <div class="row text-center">
    <div class="col-md-3 mb-4">
      <i class="fa-brands fa-python fa-3x mb-3" style="color:#306998;"></i>
      <h5>Python Mastery</h5>
    </div>
    <div class="col-md-3 mb-4">
      <i class="fa-solid fa-server fa-3x mb-3" style="color:#8B0000;"></i>
      <h5>Backend with Flask</h5>
    </div>
    <div class="col-md-3 mb-4">
      <i class="fa-brands fa-js fa-3x mb-3" style="color:#f0db4f;"></i>
      <h5>JavaScript & Frontend</h5>
    </div>
    <div class="col-md-3 mb-4">
      <i class="fa-solid fa-rocket fa-3x mb-3" style="color:#FFD700;"></i>
      <h5>Deployment & Projects</h5>
    </div>
  </div>
</section>

<!-- Syllabus Accordion -->
<section class="container my-5">
  <h2 class="section-title">Syllabus Snapshot</h2>
  <div class="accordion" id="syllabusAccordion">

    <!-- Week 1 -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="week1Heading">
        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#week1" aria-expanded="true" aria-controls="week1">
          Week 1: Python Basics & OOP
        </button>
      </h2>
      <div id="week1" class="accordion-collapse collapse show" aria-labelledby="week1Heading" data-bs-parent="#syllabusAccordion">
        <div class="accordion-body">
          <p><strong>Topics:</strong> Python basics, Variables, Data Types, Loops, Functions, OOP</p>
          <p><strong>Project:</strong> CLI Calculator / To-do List</p>
        </div>
      </div>
    </div>

    <!-- Week 2 -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="week2Heading">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#week2" aria-expanded="false" aria-controls="week2">
          Week 2: Advanced Python
        </button>
      </h2>
      <div id="week2" class="accordion-collapse collapse" aria-labelledby="week2Heading" data-bs-parent="#syllabusAccordion">
        <div class="accordion-body">
          <p><strong>Topics:</strong> Lists, Dictionaries, File Handling, JSON</p>
          <p><strong>Project:</strong> CSV/JSON Data Analyzer / To-do App</p>
        </div>
      </div>
    </div>

    <!-- Week 3 -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="week3Heading">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#week3" aria-expanded="false" aria-controls="week3">
          Week 3: Frontend Basics
        </button>
      </h2>
      <div id="week3" class="accordion-collapse collapse" aria-labelledby="week3Heading" data-bs-parent="#syllabusAccordion">
        <div class="accordion-body">
          <p><strong>Topics:</strong> HTML, CSS, Bootstrap, JS Basics, Responsive Design</p>
          <p><strong>Project:</strong> Portfolio Website / Interactive Quiz</p>
        </div>
      </div>
    </div>

    <!-- Week 4 -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="week4Heading">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#week4" aria-expanded="false" aria-controls="week4">
          Week 4: Flask Basics
        </button>
      </h2>
      <div id="week4" class="accordion-collapse collapse" aria-labelledby="week4Heading" data-bs-parent="#syllabusAccordion">
        <div class="accordion-body">
          <p><strong>Topics:</strong> Flask Routing, Templates, Forms, Session</p>
          <p><strong>Project:</strong> Blog App (CRUD) / User Login</p>
        </div>
      </div>
    </div>

    <!-- Week 5 -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="week5Heading">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#week5" aria-expanded="false" aria-controls="week5">
          Week 5: Database & ORM
        </button>
      </h2>
      <div id="week5" class="accordion-collapse collapse" aria-labelledby="week5Heading" data-bs-parent="#syllabusAccordion">
        <div class="accordion-body">
          <p><strong>Topics:</strong> Databases, SQL, SQLAlchemy, Data Modeling</p>
          <p><strong>Project:</strong> Student Management System</p>
        </div>
      </div>
    </div>

    <!-- Week 6 -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="week6Heading">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#week6" aria-expanded="false" aria-controls="week6">
          Week 6: Frontend Interactivity & APIs
        </button>
      </h2>
      <div id="week6" class="accordion-collapse collapse" aria-labelledby="week6Heading" data-bs-parent="#syllabusAccordion">
        <div class="accordion-body">
          <p><strong>Topics:</strong> AJAX, Fetch API, JSON, React Intro</p>
          <p><strong>Project:</strong> Weather App / Task Manager</p>
        </div>
      </div>
    </div>

    <!-- Week 7 -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="week7Heading">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#week7" aria-expanded="false" aria-controls="week7">
          Week 7: Authentication & Advanced Features
        </button>
      </h2>
      <div id="week7" class="accordion-collapse collapse" aria-labelledby="week7Heading" data-bs-parent="#syllabusAccordion">
        <div class="accordion-body">
          <p><strong>Topics:</strong> Authentication, Authorization, File Upload, Error Handling</p>
          <p><strong>Project:</strong> Secure Blog Platform / Admin Panel</p>
        </div>
      </div>
    </div>

    <!-- Week 8 -->
    <div class="accordion-item">
      <h2 class="accordion-header" id="week8Heading">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#week8" aria-expanded="false" aria-controls="week8">
          Week 8: Deployment & Capstone Project
        </button>
      </h2>
      <div id="week8" class="accordion-collapse collapse" aria-labelledby="week8Heading" data-bs-parent="#syllabusAccordion">
        <div class="accordion-body">
          <p><strong>Topics:</strong> Deployment, Environment Setup</p>
          <p><strong>Project:</strong> E-commerce / Social Media / Online Course Platform</p>
        </div>
      </div>
    </div>

  </div>
</section>

<!-- Instructor -->
<section class="container">
  <h2 class="section-title">Instructor</h2>
  <div class="row align-items-center">
    <div class="col-md-3 text-center">
      <img src="instructor-photo.jpg" class="img-fluid rounded-circle" alt="Instructor">
    </div>
    <div class="col-md-9">
      <h4>Surendar Kumar</h4>
      <p>Full Stack Developer & Trainer with 7+ years of experience. Mentor for Python, Flask, and Web Development projects.</p>
    </div>
  </div>
</section>

<!-- Testimonials Carousel -->
<section class="container">
  <h2 class="section-title">Testimonials</h2>
  <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <blockquote>"UTC Academy helped me land my first Full Stack Developer job!"</blockquote>
        <p>- Student A</p>
      </div>
      <div class="carousel-item">
        <blockquote>"Amazing teaching style and practical projects!"</blockquote>
        <p>- Student B</p>
      </div>
      <div class="carousel-item">
        <blockquote>"The capstone project made me confident to build real-world apps."</blockquote>
        <p>- Student C</p>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
    </button>
  </div>
</section>

<!-- Registration -->
<section class="container text-center" id="register">
  <h2 class="section-title">Enroll Now</h2>
  <form>
    <script src="https://checkout.razorpay.com/v1/checkout.js"
      data-key="YOUR_RAZORPAY_KEY"
      data-amount="500000"
      data-currency="INR"
      data-buttontext="Pay ₹5000 & Register"
      data-name="UTC Academy"
      data-description="Python Full Stack Development"
      data-image="utc-logo.png"
      data-theme.color="#8B0000">
    </script>
  </form>
</section>

<!-- Footer -->
<footer>
  <div class="social-icons mb-3">
    <a href="#"><i class="fab fa-facebook-f"></i></a>
    <a href="#"><i class="fab fa-instagram"></i></a>
    <a href="#"><i class="fab fa-twitter"></i></a>
  </div>
  <p>UTC Academy | Contact: info@utcacademy.com</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
