<?php
include 'db.php';
?>

<?php include('includes/header.php'); ?>

<div class="container py-5">
    <h2 class="mb-4">Certificate Verification</h2>
    <form method="get" class="mb-4">
        <div class="input-group">
            <input type="text" name="cert_no" class="form-control" placeholder="Enter Certificate Number (e.g., KCS252600001)" required>
            <button class="btn btn-primary" type="submit">Verify</button>
        </div>
    </form>

<?php
if (isset($_GET['cert_no'])) {
    $cert_no = trim($_GET['cert_no']);

    $sql = "SELECT c.cert_no, c.issued_at, u.name, u.email, w.title, w.date
            FROM certificates c
            JOIN users u ON c.user_id = u.id
            JOIN workshops1 w ON c.workshop_id = w.id
            WHERE c.cert_no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $cert_no);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        echo '<div class="alert alert-success">
                ✅ <strong>Valid Certificate</strong><br><br>
                <strong>Certificate No:</strong> '.htmlspecialchars($row['cert_no']).'<br>
                <strong>Issued To:</strong> '.htmlspecialchars($row['name']).' ('.htmlspecialchars($row['email']).')<br>
                <strong>Workshop:</strong> '.htmlspecialchars($row['title']).'<br>
                <strong>Date:</strong> '.date("d M Y", strtotime($row['date'])).'<br>
                <strong>Issued At:</strong> '.date("d M Y", strtotime($row['issued_at'])).'
              </div>';
    } else {
        echo '<div class="alert alert-danger">❌ Invalid or Not Found</div>';
    }

    $stmt->close();
}
$conn->close();
?>
</div>

<?php include('includes/footer.php'); ?>
