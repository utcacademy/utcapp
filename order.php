<?php
require('razorpay-php/Razorpay.php'); // Razorpay PHP SDK

use Razorpay\Api\Api;

// Your Razorpay Key ID and Secret
$keyId = "rzp_live_wjqoqyQckgiqxo";  
$keySecret = "ymCgRCrFfOxTJsq2oZGZ6UxW";  

// Create API instance
$api = new Api($keyId, $keySecret);

// Get POSTed data
$input = json_decode(file_get_contents("php://input"), true);

if (!$input || !isset($input['amount'])) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid request"]);
    exit;
}

// Razorpay accepts amount in paise (INR * 100)
$orderData = [
    'receipt'         => 'bootcamp_rcpt_'.rand(1000,9999),
    'amount'          => $input['amount'], 
    'currency'        => 'INR',
    'payment_capture' => 1 // auto capture
];

$order = $api->order->create($orderData);

// Return order details to frontend
echo json_encode([
    'id' => $order['id'],
    'amount' => $order['amount'],
    'currency' => $order['currency']
]);
