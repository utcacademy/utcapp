<?php
$conn = new mysqli("localhost", "root", "", "aakkamkcs_db");
if ($conn->connect_error) {
    die("DB Connection Failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $conn->prepare("DELETE FROM userreg WHERE userid=?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: promotion.php?msg=Record deleted successfully");
    } else {
        header("Location: promotion.php?msg=Error deleting record");
    }
} else {
    header("Location: promotion.php?msg=Invalid Request");
}
$conn->close();
exit;
?>
