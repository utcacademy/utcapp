<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

if(!isset($_GET['id']) || empty($_GET['id'])){
    header("Location: workshops.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$workshop_id = intval($_GET['id']);

// Check if already registered
$stmt = $conn->prepare("SELECT * FROM registrations WHERE user_id=? AND workshop_id=?");
$stmt->bind_param("ii",$user_id,$workshop_id);
$stmt->execute();
$res = $stmt->get_result();
if($res->num_rows > 0){
    header("Location: thankyou.php?id=$workshop_id");
    exit;
}

// Insert registration
$stmt = $conn->prepare("INSERT INTO registrations(user_id, workshop_id, reg_date) VALUES(?,?,NOW())");
$stmt->bind_param("ii",$user_id,$workshop_id);
$stmt->execute();

header("Location: thankyou.php?id=$workshop_id");
exit;
?>
