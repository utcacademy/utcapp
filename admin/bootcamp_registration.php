<?php

include('../db.php');

// fetch registrations
$result = $conn->query("SELECT id, name, email, phone, plan, razorpay_payment_id FROM bootcampregistrations");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Bootcamp Registrations - Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h2 class="mb-4">📋 Bootcamp Registrations</h2>
  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>#</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Plan</th>
        <th>Payment ID</th>
        <th>Confirmation</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result->num_rows > 0): 
        $i=1;
        while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $i++ ?></td>
          <td><?= htmlspecialchars($row['name']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td><?= htmlspecialchars($row['phone']) ?></td>
          <td><?= htmlspecialchars($row['plan']) ?></td>
          <td><?= htmlspecialchars($row['razorpay_payment_id']) ?></td>
          <td>
            <!-- WhatsApp confirmation -->
        <?php
$bootcampName = "Python + Streamlit + ML Bootcamp";
$planText = ($row['plan'] == "499") ? "499(Recorded Session)" : (($row['plan'] == "999") ? "999(Live Session)" : $row['plan']);
?>

<a 
  class="btn btn-success btn-sm"
  href="https://wa.me/<?= htmlspecialchars($row['phone']) ?>?text=✅%20Hello%20<?= urlencode($row['name']) ?>,%0A%0A🎉%20Thank%20you%20for%20registering%20for%20our%20<?= urlencode($bootcampName) ?>!%0A%0A📌%20Plan:%20<?= urlencode($planText) ?>%0A💳%20Payment%20ID:%20<?= urlencode($row['razorpay_payment_id']) ?>%0A%0A📅%20Classes%20start%20from%205th%20September.%0A📝%20We%20will%20send%20you%20further%20details%20soon.%0A%0ARegards,%0AAakkam%20KCS"
  target="_blank">
  Send WhatsApp
</a>


           
          </td>
        </tr>
      <?php endwhile; else: ?>
        <tr><td colspan="7" class="text-center">No registrations found.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
</body>
</html>
