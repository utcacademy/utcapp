<?php
// DB Connection
$conn = new mysqli("localhost", "root", "", "aakkamkcs_db");
if ($conn->connect_error) {
    die("DB Connection Failed: " . $conn->connect_error);
}

// Fetch data
$sql = "SELECT userid, name, gender, role, year_desg, dept, col_org, state, city FROM userreg";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Registration Data</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <h3 class="mb-4 text-center">User Registration Details</h3>

  <table class="table table-bordered table-hover table-striped shadow-sm">
    <thead class="table-dark">
      <tr>
        <th>Name</th>
        <th>Gender</th>
        <th>Role</th>
        <th>Year/Designation</th>
        <th>Department</th>
        <th>College / Organization</th>
        <th>Whatsapp</th>
        
        <th>City</th>
        <th>Action</th>
        
      </tr>
    </thead>
    <tbody>
      <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['gender']) ?></td>
            <td><?= htmlspecialchars($row['role']) ?></td>
            <td><?= htmlspecialchars($row['year_desg']) ?></td>
            <td><?= htmlspecialchars($row['dept']) ?></td>
            <td><?= htmlspecialchars($row['col_org']) ?></td>      
            <td><a
  class="btn btn-success"
  href="https://wa.me/919952382360?text=%F0%9F%8E%93%20Kovai%20Consultancy%20Services%20Presents%20%E2%80%93%20FREE%20Workshop%0A%F0%9F%90%8D%20Python%20with%20Data%20Science%20%26%20Streamlit%0A%0A%F0%9F%9A%80%20Learn%20to%20create%20interactive%20dashboards%20%26%20real-time%20data%20apps%20in%20just%201%20hour%21%0A%0A%F0%9F%93%85%20Date%3A%2031st%20August%202025%0A%F0%9F%95%9A%20Time%3A%2011%3A00%20AM%20%E2%80%93%2012%3A00%20PM%0A%F0%9F%92%BB%20Mode%3A%20Online%20%28Google%20Meet%29%0A%0A%F0%9F%92%B0%20Fee%3A%20FREE%20%28No%20charges%29%0A%0A%E2%9C%85%20Limited%20seats%20available%21%0A%F0%9F%91%89%20Register%20now%3A%20https%3A%2F%2Faakkamkcs.com%2Fworkshops%0A%0A%E2%9C%A8%20Don%E2%80%99t%20miss%20this%20chance%20to%20boost%20your%20Data%20Science%20%26%20Dashboarding%20skills%21"
  target="_blank"
  rel="noopener"
>
  Share on WhatsApp
</a>
</td>      
            <td><?= htmlspecialchars($row['city']) ?></td>
            <td>
              <a href="edit_user.php?id=<?= $row['userid'] ?>" class="btn btn-sm btn-warning">Edit</a>
            /  <a href="delete_user.php?id=<?= $row['userid'] ?>" class="btn btn-sm btn-danger"
                 onclick="return confirm('Are you sure you want to delete this record?');">
                 Delete
              </a>
            
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="9" class="text-center">No records found</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

</body>
</html>

<?php $conn->close(); ?>
