<?php
include "../db.php"; // adjust path if needed

// Fetch all workshops for filter dropdown
$workshops = $conn->query("SELECT id, title FROM workshops1 ORDER BY date ASC");

// Handle filters
$filter = "WHERE 1=1";

if (isset($_GET['workshop_id']) && $_GET['workshop_id'] != '') {
    $wid = intval($_GET['workshop_id']);
    $filter .= " AND r.workshop_id = $wid";
}

$search = "";
if (isset($_GET['search']) && $_GET['search'] != '') {
    $search = $conn->real_escape_string($_GET['search']);
    $filter .= " AND (r.name LIKE '%$search%' OR r.email LIKE '%$search%' OR r.phone LIKE '%$search%')";
}

// Fetch registrations
$query = "
    SELECT r.id, r.name, r.email, r.phone, r.registered_at, w.title, w.date, w.time
    FROM workshop_registrations r
    JOIN workshops1 w ON r.workshop_id = w.id
    $filter
    ORDER BY r.registered_at DESC
";
$registrations = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Workshop Registrations</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4 text-primary">📋 Workshop Registrations</h2>

    <!-- Filter & Search Form -->
    <form method="get" class="mb-3">
        <div class="row g-2">
            <div class="col-md-4">
                <select name="workshop_id" class="form-control">
                    <option value="">-- All Workshops --</option>
                    <?php while($w = $workshops->fetch_assoc()) { ?>
                        <option value="<?php echo $w['id']; ?>"
                            <?php if(isset($wid) && $wid == $w['id']) echo "selected"; ?>>
                            <?php echo $w['title']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" 
                       placeholder="Search by name, email or phone" 
                       value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
            <div class="col-md-2">
                <a href="registrations_export.php?<?php echo http_build_query($_GET); ?>" 
                   class="btn btn-success w-100">⬇ Export CSV</a>
            </div>
        </div>
    </form>

    <!-- Registrations Table -->
    <div class="table-responsive bg-white shadow rounded p-3">
        <table class="table table-bordered table-hover">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Workshop</th>
                    <th>Date & Time</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Registered At</th>
                </tr>
            </thead>
            <tbody>
                <?php if($registrations->num_rows > 0) { 
                    $i=1;
                    while($row = $registrations->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo date("d M Y", strtotime($row['date'])) . " " . date("h:i A", strtotime($row['time'])); ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td><?php echo date("d M Y h:i A", strtotime($row['registered_at'])); ?></td>
                    <td>
       <td>
   <td>
    <a href="https://wa.me/<?php echo $row['phone']; ?>?text=<?php 
        echo urlencode(
            'Hello ' . $row['name'] . ",\n\n" .
            'Thank you for registering for our workshop: ' . $row['title'] . "\n" .
            '📅 Date: ' . date("d M Y", strtotime($row['date'])) . "\n" .
            '⏰ Time: ' . date("h:i A", strtotime($row['time'])) . "\n\n" .
            'We look forward to seeing you!\n\n- Kovai Consultancy Services'
        ); 
    ?>"
    target="_blank"
    class="btn btn-success btn-sm">📲 Send WhatsApp</a>
</td>

</td>

    </td>
                    </tr>
                <?php }} else { ?>
                    <tr><td colspan="7" class="text-center text-muted">No registrations found</td></tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
