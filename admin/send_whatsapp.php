<?php
include "../db.php";

// Get registration details
if (!isset($_GET['id'])) {
    die("Invalid request");
}
$id = intval($_GET['id']);

$query = $conn->query("
    SELECT r.name, r.phone, w.title, w.date, w.time 
    FROM workshop_registrations r
    JOIN workshops w ON r.workshop_id = w.id
    WHERE r.id = $id
");

if ($query->num_rows == 0) {
    die("No registration found");
}

$reg = $query->fetch_assoc();

// WhatsApp Cloud API credentials
$token = "YOUR_PERMANENT_ACCESS_TOKEN"; 
$phone_number_id = "YOUR_PHONE_NUMBER_ID"; 

// Prepare message
$message = "Hello {$reg['name']} 👋,\n\n".
           "Thank you for registering for our workshop:\n".
           "📘 {$reg['title']}\n".
           "📅 " . date("d M Y", strtotime($reg['date'])) . "\n".
           "⏰ " . date("h:i A", strtotime($reg['time'])) . "\n\n".
           "Stay tuned for further updates!\n\n".
           "- Kovai Consultancy Services";

// Send via WhatsApp Cloud API
$url = "https://graph.facebook.com/v17.0/$phone_number_id/messages";

$data = [
    "messaging_product" => "whatsapp",
    "to" => $reg['phone'], // must include country code, e.g. 919876543210
    "type" => "text",
    "text" => [ "body" => $message ]
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $token",
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);

echo "<h3>✅ WhatsApp message sent to {$reg['name']} ({$reg['phone']})</h3>";
echo "<pre>$response</pre>";
echo "<a href='registrations.php' class='btn btn-primary mt-3'>⬅ Back to Registrations</a>";
?>
