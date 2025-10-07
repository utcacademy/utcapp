<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id']) || !isset($_POST['workshop_id'])){
    echo 'error';
    exit;
}

$user_id = $_SESSION['user_id'];
$workshop_id = intval($_POST['workshop_id']);

// Check if already registered
$check = $conn->prepare("SELECT id FROM workshop_registrations WHERE user_id=? AND workshop_id=?");
$check->bind_param("ii", $user_id, $workshop_id);
$check->execute();
$res = $check->get_result();
if($res->num_rows > 0){
    echo 'success';
    exit;
}

// Fetch user info
$stmt = $conn->prepare("SELECT name, email, phone, organization FROM users WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Insert registration
$stmt2 = $conn->prepare("INSERT INTO workshop_registrations (workshop_id, user_id, name, email, phone, organization) VALUES (?, ?, ?, ?, ?, ?)");
$stmt2->bind_param("iissss", $workshop_id, $user_id, $user['name'], $user['email'], $user['phone'], $user['organization']);

if($stmt2->execute()){
    echo 'success';
} else {
    echo 'error';
}
?>
