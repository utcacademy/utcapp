<?php
$conn = new mysqli("localhost", "root", "", "aakkamkcs_db");
if ($conn->connect_error) {
    die("DB Connection Failed: " . $conn->connect_error);
}

// Get user details
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM userreg WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
} else {
    die("Invalid Request");
}

// Update on submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $role = $_POST['role'];
    $year_desg = $_POST['year_desg'];
    $dept = $_POST['dept'];
    $col_org = $_POST['col_org'];
    $state = $_POST['state'];
    $city = $_POST['city'];

    $stmt = $conn->prepare("UPDATE userreg SET name=?, gender=?, role=?, year_desg=?, dept=?, col_org=?, state=?, city=? WHERE userid=?");
    $stmt->bind_param("ssssssssi", $name, $gender, $role, $year_desg, $dept, $col_org, $state, $city, $id);

    if ($stmt->execute()) {
        header("Location: users.php?msg=updated");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit User</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <h3 class="mb-4">Edit User</h3>
  <form method="POST" class="card p-4 shadow">
    <div class="mb-3">
      <label class="form-label">Name</label>
      <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name']) ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Gender</label>
      <select name="gender" class="form-control" required>
        <option value="Male" <?= $user['gender']=="Male"?"selected":"" ?>>Male</option>
        <option value="Female" <?= $user['gender']=="Female"?"selected":"" ?>>Female</option>
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">Role</label>
      <input type="text" name="role" class="form-control" value="<?= htmlspecialchars($user['role']) ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Year/Designation</label>
      <input type="text" name="year_desg" class="form-control" value="<?= htmlspecialchars($user['year_desg']) ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Department</label>
      <input type="text" name="dept" class="form-control" value="<?= htmlspecialchars($user['dept']) ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">College/Organization</label>
      <input type="text" name="col_org" class="form-control" value="<?= htmlspecialchars($user['col_org']) ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">State</label>
      <input type="text" name="state" class="form-control" value="<?= htmlspecialchars($user['state']) ?>" required>
    </div>
    <div class="mb-3">
      <label class="form-label">City</label>
      <input type="text" name="city" class="form-control" value="<?= htmlspecialchars($user['city']) ?>" required>
    </div>
    <button type="submit" class="btn btn-success">Update</button>
    <a href="users.php" class="btn btn-secondary">Cancel</a>
  </form>
</div>

</body>
</html>
