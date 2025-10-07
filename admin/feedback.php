<?php
include('../db.php');

// Handle delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM feedback WHERE id = $id");
    header("Location: feedback.php"); 
    exit;
}

// Fetch feedback
$result = $conn->query("SELECT * FROM feedback ORDER BY timestamp DESC");

function getCategory($row) {
    if (stripos($row['next_offer'], "yes") !== false || stripos($row['objection'], "willing") !== false) {
        return "willing";
    } elseif (stripos($row['objection'], "time") !== false) {
        return "time";
    } elseif (stripos($row['objection'], "price") !== false) {
        return "price";
    } elseif (stripos($row['objection'], "skilled") !== false) {
        return "skilled";
    } else {
        return "other";
    }
}

function getMessageTemplate($category, $name) {
    switch ($category) {
        case "willing":
            return "Hi $name, thank you for your feedback 🙏 Glad to know you're interested. Here’s the link to join our 5-Day Bootcamp starts at 5th sep 2025 for just ₹499 👉 https://aakkamkcs.com/kcs/bootcamp";
        case "time":
            return "Hi $name, I noticed you mentioned time constraints. No worries 😊 we also provide recorded sessions so you can learn at your own pace.  Here’s the link to join our 5-Day Bootcamp starts at 5th sep 2025 recorded Session for just ₹499 👉 https://aakkamkcs.com/kcs/bootcamp";
        case "price":
            return "Hi $name, I understand price can be a concern. We’re currently running an offer 🎉 – you can access recordings  and the full Bootcamp with live support is ₹499 starts at 5th sep 2025. Would you be interested?";
        case "skilled":
            return "Hi $name, thanks for sharing! Since you’re already skilled, you might enjoy our advanced projects & networking opportunities. Want me to share details?";
        default:
            return "Hi $name, thanks a lot for your feedback 🙏 Can you share a bit more about your learning needs? I’d love to guide you.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Workshop Feedback - Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script>
    function filterCategory(cat) {
      let rows = document.querySelectorAll("#feedbackTable tbody tr");
      rows.forEach(row => {
        let val = row.getAttribute("data-category");
        row.style.display = (cat === "all" || val === cat) ? "" : "none";
      });
    }
  </script>
</head>
<body class="bg-light">
  <div class="container mt-5">
    <h2 class="mb-4">📋 Workshop Feedback</h2>

    <!-- Category Filter -->
    <div class="mb-3">
      <button class="btn btn-secondary btn-sm" onclick="filterCategory('all')">All</button>
      <button class="btn btn-success btn-sm" onclick="filterCategory('willing')">✅ Willing</button>
      <button class="btn btn-warning btn-sm" onclick="filterCategory('time')">⏰ Time Issue</button>
      <button class="btn btn-danger btn-sm" onclick="filterCategory('price')">💰 Price Issue</button>
      <button class="btn btn-info btn-sm" onclick="filterCategory('skilled')">🎓 Already Skilled</button>
      <button class="btn btn-dark btn-sm" onclick="filterCategory('other')">❓ Other</button>
    </div>

    <div class="table-responsive shadow-sm">
      <table id="feedbackTable" class="table table-bordered table-hover table-striped align-middle">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>WhatsApp</th>
            <th>Rating ⭐</th>
            <th>Takeaway</th>
            <th>Built</th>
            <th>Confidence</th>
            <th>Next Offer</th>
            <th>Objection</th>
            <th>Testimonial</th>
            <th>Submitted At</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
              <?php
                $category = getCategory($row);
                $msg = urlencode(getMessageTemplate($category, $row['name']));
              ?>
              <tr data-category="<?= $category ?>">
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td>
                  <a href="https://wa.me/<?= $row['whatsapp'] ?>?text=<?= $msg ?>" 
                     target="_blank" 
                     class="btn btn-sm btn-success">📲 WhatsApp</a>
                  <div class="small text-muted"><?= htmlspecialchars($row['whatsapp']) ?></div>
                </td>
                <td><?= $row['next_offer'] ?></td>
                <td><?= $row['objection'] ?></td>
                <td><?= $row['rating'] ?> / 5</td>
                <td><?= nl2br(htmlspecialchars($row['takeaway'])) ?></td>
                <td><?= nl2br(htmlspecialchars($row['built'])) ?></td>
                <td><?= $row['confidence'] ?></td>
                
                <td><?= nl2br(htmlspecialchars($row['testimonial'])) ?></td>
                <td><?= $row['timestamp'] ?></td>
                <td>
                  <a href="?delete=<?= $row['id'] ?>" 
                     class="btn btn-sm btn-danger"
                     onclick="return confirm('Are you sure you want to delete this feedback?')">
                     Delete
                  </a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr><td colspan="12" class="text-center text-muted">No feedback submitted yet.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
