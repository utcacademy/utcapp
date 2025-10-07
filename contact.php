<?php
$pageTitle = "Contact Us | Kovai Consultancy Services";
$pageDescription = "Get in touch with Kovai Consultancy Services (KCS) for training, workshops, and consultancy services.";
$activePage = "contact";
include 'includes/header.php';
?>



<!-- Contact Info + Form -->
<section class="container py-5">
  <div class="row g-5">
    <!-- Contact Information -->
    <div class="col-md-5">
      <div class="p-4 bg-white shadow rounded h-100">
        <h3 class="text-danger fw-bold mb-4">📍 Get in Touch</h3>
        <p><i class="bi bi-geo-alt-fill text-danger"></i> 14,saibaba colony coimbatore </p>
        <p><i class="bi bi-telephone-fill text-danger"></i> +91 99523 82360</p>
        <p><i class="bi bi-envelope-fill text-danger"></i> info@aakkamkcs.com</p>
        <p><i class="bi bi-clock-fill text-danger"></i> Mon - Sat: 9:00 AM – 7:00 PM</p>
      </div>
    </div>

    <!-- Contact Form -->
    <div class="col-md-7">
      <div class="p-4 bg-white shadow rounded">
        <h3 class="text-danger fw-bold mb-4">✉️ Send Us a Message</h3>
        <form action="send_message.php" method="POST">
          <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" placeholder="Your Name" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" placeholder="Your Email" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Phone Number</label>
            <input type="text" name="phone" class="form-control" placeholder="Your Phone" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Message</label>
            <textarea name="message" class="form-control" rows="5" placeholder="Type your message..." required></textarea>
          </div>
          <button type="submit" class="btn btn-danger fw-bold px-4">Send Message</button>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- Google Map -->
<!-- <section class="container py-5">
  <h3 class="text-center text-danger fw-bold mb-4">🌍 Find Us on Map</h3>
  <div class="ratio ratio-16x9 shadow rounded">
    <iframe 
      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3915.123456789!2d76.98765!3d11.02345!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ba857123456789%3A0xabcdef123456789!2sCoimbatore!5e0!3m2!1sen!2sin!4v1679999999999" 
      width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy">
    </iframe>
  </div>
</section> -->

<?php include 'includes/footer.php'; ?>
