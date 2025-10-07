<?php
include('db.php');
$res = $conn->query("SELECT id, email FROM users");
while ($row = $res->fetch_assoc()) {
    $plain = substr($row['email'], 0, 4) . "_kcs";
    $hashed = password_hash($plain, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE users SET password=? WHERE id=?");
    $stmt->bind_param("si", $hashed, $row['id']);
    $stmt->execute();
}

?>
