<?php include('includes/header.php'); ?>


<style>
/* General Styling */
body { background: #0f172a; color: #e2e8f0; font-family: 'Inter', sans-serif; }
section { margin-bottom: 3rem; }
h2, h3 { font-weight: 700; }
.btn-primary { background: #22d3ee; border: none; border-radius: 50px; font-weight: 600; padding: 0.6rem 1.5rem; }
.btn-primary:hover { background: #06b6d4; }

/* Hero */
.hero { text-align: center; padding: 5rem 2rem; background: linear-gradient(135deg, #0ea5e9, #22d3ee); border-radius: 12px; color: #fff; }
.hero h1 { font-size: 2.5rem; margin-bottom: 1rem; }
.hero p { font-size: 1.2rem; }

/* Info Grid */
.course-info { margin-top: 2rem; display: grid; grid-template-columns: repeat(auto-fit,minmax(200px,1fr)); gap: 1rem; }
.info-card { background: #1e293b; padding: 1rem; border-radius: 10px; text-align: center; }
.info-card .title { font-weight: bold; font-size: 1.3rem; }
.info-card .sub { color: #cbd5e1; font-size: 0.9rem; }

/* Pricing */
.pricing { display: grid; grid-template-columns: repeat(auto-fit,minmax(250px,1fr)); gap: 1.5rem; }
.price-card { background: #1e293b; padding: 2rem; border-radius: 12px; text-align: center; }
.price-card h3 { font-size: 1.5rem; margin-bottom: 0.5rem; }
.price-card p { font-size: 0.9rem; margin-bottom: 1rem; }

/* Register Form */
#register .course-detail { background: #1e293b; border-radius: 12px; padding: 2rem; margin-top: 2rem; }
#register form { background: #fff; padding: 1.5rem; border-radius: 12px; color: #000; }
#register .form-control { margin-bottom: 1rem; padding: 0.6rem; border-radius: 8px; border: 1px solid #ccc; width: 100%; }

/* FAQ */
.faq-item { margin-bottom: 1rem; }
.faq-item h4 { font-size: 1.1rem; margin-bottom: 0.3rem; }

/* Sticky CTA */
.sticky-bar { position: fixed; bottom: 0; left: 0; right: 0; background: #0ea5e9; padding: 0.8rem; text-align: center; }
.sticky-bar a { color: #fff; font-weight: 600; }
</style>

<!-- Hero -->
<section class="hero">
  <h1>Python Streamlit ML Bootcamp</h1>
  <p>Learn Python, build Streamlit apps, and apply Machine Learning in 5 days of live sessions.</p>
  <a href="#register" class="btn btn-primary mt-3">Register Now</a><br/><br/>
  <div style="background:#dc2626;color:#fff;text-align:center;padding:0.6rem;font-weight:600;">
  🎉 Limited Time Offer: Register within 24 Hrs for just ₹499 (original ₹1499) 🚀
</div>

</section>
<!-- Bootcamp Info -->
<section class="container">
  <h2 class="text-center mb-4">Bootcamp Highlights</h2>
  <div class="course-info">
    <div class="info-card"><div class="title">₹499</div><div class="sub">Live + Recorded Access</div></div>
    <div class="info-card"><div class="title">15 Hrs</div><div class="sub">Live Training</div></div>
    <div class="info-card"><div class="title">5 Projects</div><div class="sub">Portfolio Ready</div></div>
    <div class="info-card"><div class="title">Certificate</div><div class="sub">On Completion</div></div>
  </div>
</section>
<!-- Curriculum -->
<section class="container">
  <h2 class="text-center mb-4">5-Day Bootcamp Syllabus</h2>
  <div class="syllabus">
    <div class="day">
      <h3>Day 1: Python for Data Science</h3>
      <ul>
        <li>Introduction to Python & Jupyter Notebook</li>
        <li>Variables, Data Types, and Operators</li>
        <li>Data Structures (Lists, Dicts, Tuples, Sets)</li>
        <li>Loops, Functions & Modules</li>
        <li>Hands-on: Data Cleaning Basics</li>
      </ul>
    </div>
    <div class="day">
      <h3>Day 2: Data Analysis with Pandas & Visualization</h3>
      <ul>
        <li>Importing & Handling CSV/Excel Data</li>
        <li>Exploring DataFrames</li>
        <li>Data Cleaning & Preprocessing</li>
        <li>Matplotlib & Seaborn for Visualization</li>
        <li>Hands-on: Exploratory Data Analysis (EDA)</li>
      </ul>
    </div>
    <div class="day">
      <h3>Day 3: Streamlit for Interactive Apps</h3>
      <ul>
        <li>Getting Started with Streamlit</li>
        <li>Layouts, Widgets, and User Input</li>
        <li>Displaying DataFrames & Charts in Apps</li>
        <li>Hands-on: Build Your First Streamlit Dashboard</li>
      </ul>
    </div>
    <div class="day">
      <h3>Day 4: Machine Learning Basics</h3>
      <ul>
        <li>Intro to Machine Learning</li>
        <li>Supervised vs Unsupervised Learning</li>
        <li>Train/Test Split, Model Training</li>
        <li>Linear Regression, Classification Models</li>
        <li>Hands-on: Build a Prediction Model</li>
      </ul>
    </div>
    <div class="day">
      <h3>Day 5: Deploy & Showcase Projects</h3>
      <ul>
        <li>Integrating ML Models into Streamlit</li>
        <li>Building a Complete Data Science App</li>
        <li>Deploying Streamlit Apps on Streamlit Cloud</li>
        <li>Portfolio Projects (5 mini-projects)</li>
        <li>Career Guidance + Certificate Distribution</li>
      </ul>
    </div>
  </div>
</section>

<style>
.syllabus .day {
  background: #1e293b;
  padding: 1.5rem;
  border-radius: 12px;
  margin-bottom: 1.2rem;
}
.syllabus h3 {
  font-size: 1.2rem;
  margin-bottom: 0.8rem;
  color: #22d3ee;
}
.syllabus ul {
  list-style: disc;
  margin-left: 1.5rem;
}
.syllabus ul li {
  margin-bottom: 0.4rem;
  color: #cbd5e1;
}
</style>

<!-- Pricing -->
<section class="container">
  <h2 class="text-center mb-4">Choose Your Plan</h2>
  <div class="pricing">
    <div class="price-card">
      <h3>Bootcamp (Live + Recorded)</h3>
      <p>Interactive sessions + Lifetime Access</p>
      <div class="title">₹499</div>
      <a href="#register" class="btn btn-primary">Register</a>
    </div>
  </div>
</section>

<!-- Registration Form -->
<section class="container" id="register">
  <div class="course-detail">
    <h3>Register for Bootcamp</h3>
    <form id="regForm">
      <input type="text" name="name" placeholder="Full Name" required class="form-control">
      <input type="email" name="email" placeholder="Email Address" required class="form-control">
      <input type="text" name="phone" placeholder="Phone Number" required class="form-control">

      <select name="plan" class="form-control" required>
        <option value="499">Bootcamp (₹499)</option>
      </select>

      <button type="submit" class="btn btn-primary w-100">Proceed to Pay</button>
    </form>
  </div>
</section>

<!-- FAQ -->
<section class="container">
  <h2 class="text-center mb-4">FAQ</h2>
  <div class="faq-item">
    <h4>Will I get recordings?</h4>
    <p>Yes, recordings will be shared for lifetime access.</p>
  </div>
  <div class="faq-item">
    <h4>Is there a certificate?</h4>
    <p>Yes, a Bootcamp completion certificate will be provided.</p>
  </div>
</section>

<!-- Sticky CTA -->
<div class="sticky-bar">
  <a href="#register">Join the Bootcamp Now</a>
</div>

<!-- Razorpay Checkout -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
document.getElementById('regForm').addEventListener('submit', async function(e){
    e.preventDefault();
    const data = Object.fromEntries(new FormData(this).entries());

    // Send to backend to create Razorpay order
    const res = await fetch("order.php", {
      method:"POST",
      headers:{"Content-Type":"application/json"},
      body: JSON.stringify({ ...data, amount: parseInt(data.plan) * 100 })
    });
    const order = await res.json();

    var options = {
      "key": "rzp_live_wjqoqyQckgiqxo", // Replace with your Razorpay Key ID
      "amount": order.amount,
      "currency": "INR",
      "name": "Python + Streamlit Bootcamp",
      "description": "Bootcamp Registration",
      "order_id": order.id,
      "handler": async function (response){
          await fetch("save.php", {
            method:"POST",
            headers:{"Content-Type":"application/json"},
            body: JSON.stringify({
              ...data,
              payment_id: response.razorpay_payment_id,
              amount: order.amount
            })
          });
          alert("Payment Successful! You are registered.");
      },
      "prefill": {
        "name": data.name,
        "email": data.email,
        "contact": data.phone
      },
      "theme": { "color": "#22d3ee" }
    };
    new Razorpay(options).open();
});
</script>

<?php include('includes/footer.php'); ?>
