<?php
$conn = new mysqli("localhost", "root", "", "aakkamkcs_db");
if ($conn->connect_error) {
    die("DB Connection Failed: " . $conn->connect_error);
}
if (isset($_POST['add'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $link = $_POST['link'];

    $conn->query("INSERT INTO workshops1 (title, description, date, time, register_link) 
                  VALUES ('$title','$description','$date','$time','$link')");
}


// Delete workshop
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM workshops1 WHERE id=$id");
}

// Fetch all
$result = $conn->query("SELECT * FROM workshops1 ORDER BY date ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>KCS Admin - Workshops</title>
  <link href="../css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">
  <h2 class="mb-4 text-primary">Manage Workshops</h2>

  <!-- Add Workshop -->
  <form method="POST" class="mb-5 p-4 border rounded bg-light">
    <h4>Add New Workshop</h4>
    <input type="text" name="title" class="form-control mb-2" placeholder="Workshop Title" required>
    <textarea name="description" class="form-control mb-2" placeholder="Description"></textarea>
    <input type="date" name="date" class="form-control mb-2" required>
    <input type="time" name="time" class="form-control mb-2" required>

    <input type="url" name="link" class="form-control mb-2" placeholder="Registration Link">
    <button type="submit" name="add" class="btn btn-success">Add Workshop</button>
  </form>

  <!-- List Workshops -->
  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Date</th>
         <th>Time</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['title']; ?></td>
        <td><?php echo $row['date']; ?></td>
        <td><?php echo date("h:i A", strtotime($row['time'])); ?></td>

        <td>
          <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this workshop?')">Delete</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</body>
</html>
