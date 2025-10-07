<?php
include "../db.php";

$filter = "";
if (isset($_GET['workshop_id']) && $_GET['workshop_id'] != '') {
    $wid = intval($_GET['workshop_id']);
    $filter = "WHERE r.workshop_id = $wid";
}

$query = "
    SELECT w.title, w.date, w.time, r.name, r.email, r.phone, r.registered_at
    FROM workshop_registrations r
    JOIN workshops w ON r.workshop_id = w.id
    $filter
    ORDER BY r.registered_at DESC
";
$result = $conn->query($query);

// Headers for CSV download
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="registrations.csv"');

$output = fopen("php://output", "w");
fputcsv($output, ['Workshop', 'Date', 'Time', 'Name', 'Email', 'Phone', 'Registered At']);

while($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}

fclose($output);
exit;
?>
