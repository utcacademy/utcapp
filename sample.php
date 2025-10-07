<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Python + Streamlit Bootcamp</title>
  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
  <style>
    body { font-family: Arial, sans-serif; text-align: center; padding: 20px; }
    .price-box { border: 2px solid #3399cc; border-radius: 12px; padding: 20px; margin: 20px; display: inline-block; width: 260px; }
    .price { font-size: 24px; color: #3399cc; margin: 10px 0; }
    .btn { background: #3399cc; color: white; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-size: 16px; }
    .btn:disabled { background: #ccc; cursor: not-allowed; }
    #timer { font-size: 18px; color: red; margin-top: 10px; }
  </style>
</head>
<body>

  <h1>🚀 Python + Streamlit Bootcamp</h1>
  <p>5 Days • Hands-on Projects • Live Mentorship</p>

  <h2>Choose Your Plan</h2>

  <!-- Early Bird Offer -->
  <div class="price-box" id="early-bird-box">
    <h3>Early Bird Offer</h3>
    <p class="price">₹999</p>
    <p>Valid until <b>31st Aug</b> OR first 30 seats</p>
    <p><b>Seats left:</b> <span id="seats-left">Loading...</span></p>
    <div id="timer">Offer ends in: --:--:--</div>
    <button class="btn" id="early-bird-btn" onclick="bookSeat(99900)">Join at ₹999</button>
  </div>

  <!-- Regular Price -->
  <div class="price-box">
    <h3>Regular Price</h3>
    <p class="price">₹1,499</p>
    <p>After Early Bird ends</p>
    <button class="btn" onclick="payNow(149900)">Join at ₹1,499</button>
  </div>

  <script>
    // Fetch seats from backend
    async function fetchSeats() {
      let res = await fetch("seats.php");
      let data = await res.json();
      let left = data.total_seats - data.booked_seats;
      document.getElementById("seats-left").textContent = left;
      if (left <= 0) {
        document.getElementById("early-bird-btn").disabled = true;
        document.getElementById("early-bird-box").style.opacity = "0.6";
        document.getElementById("timer").innerHTML = "Seats Sold Out!";
      }
    }

    // Call Razorpay payment
    function payNow(amount) {
      var options = {
        "key": "rzp_live_wjqoqyQckgiqxo", // Replace with your Razorpay Key ID
        "amount": amount,
        "currency": "INR",
        "name": "Python + Streamlit Bootcamp",
        "description": "5-Day Intensive Bootcamp",
        "handler": function (response){
            alert("Payment successful! Payment ID: " + response.razorpay_payment_id);
            fetchSeats(); // Refresh seat count after payment
        },
        "prefill": {
            "name": "Participant Name",
            "email": "test@example.com",
            "contact": "9999999999"
        },
        "theme": { "color": "#3399cc" }
      };
      var rzp1 = new Razorpay(options);
      rzp1.open();
    }

    // Early Bird booking
    function bookSeat(amount) {
      payNow(amount);
    }

    // Countdown Timer
    var countDownDate = new Date("Aug 31, 2025 23:59:59").getTime();
    var x = setInterval(function() {
      var now = new Date().getTime();
      var distance = countDownDate - now;
      if (distance < 0) {
        document.getElementById("timer").innerHTML = "Early Bird Expired!";
        document.getElementById("early-bird-btn").disabled = true;
        clearInterval(x);
        return;
      }
      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);
      document.getElementById("timer").innerHTML = 
        days + "d " + hours + "h " + minutes + "m " + seconds + "s";
    }, 1000);

    // On page load
    fetchSeats();
  </script>

</body>
</html>
