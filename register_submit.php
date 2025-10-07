<?php
include "db.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $workshop_id = intval($_POST['workshop_id']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    // 1. Check if workshop exists
    $stmt = $conn->prepare("SELECT id FROM workshops1 WHERE id = ?");
    $stmt->bind_param("i", $workshop_id);
    $stmt->execute();
    $workshop = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$workshop) {
        die("Invalid workshop.");
    }

    // 2. Check if user already registered
    $stmt = $conn->prepare("SELECT id FROM workshop_registrations WHERE workshop_id = ? AND email = ?");
    $stmt->bind_param("is", $workshop_id, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        die("You have already registered for this workshop.");
    }
    $stmt->close();

    // 3. Insert registration safely
    $stmt = $conn->prepare("INSERT INTO workshop_registrations (workshop_id, name, email, phone) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $workshop_id, $name, $email, $phone);
    $stmt->execute();

    // Get registration ID
    $reg_id = $stmt->insert_id;

    $stmt->close();

    // 4. Redirect to thank you page
    header("Location: thankyou.php?workshop_id=$workshop_id&reg_id=$reg_id");
    exit;
}
?>
