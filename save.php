<?php
// save.php
header('Content-Type: application/json');

include('db.php');

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "DB Connection failed"]);
    exit;
}

// Read JSON body
$data = json_decode(file_get_contents("php://input"), true);

$name    = $conn->real_escape_string($data['name'] ?? '');
$email   = $conn->real_escape_string($data['email'] ?? '');
$phone   = $conn->real_escape_string($data['phone'] ?? '');
$plan    = $conn->real_escape_string($data['plan'] ?? '');
$amount  = intval($data['amount'] ?? 0);
$payment = $conn->real_escape_string($data['payment_id'] ?? '');

// Insert into DB
$sql = "INSERT INTO bootcampregistrations (name, email, phone, plan, amount, razorpay_payment_id) 
        VALUES ('$name','$email','$phone','$plan','$amount','$payment')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["success" => true, "message" => "Registration saved"]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "Failed to save registration"]);
}

$conn->close();
?>
