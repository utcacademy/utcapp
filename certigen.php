<?php
session_start();
include 'db.php';
require('fpdf/fpdf.php');

class PDF extends FPDF {
    function Header() {
        // Background certificate template (A4 Landscape)
        $this->Image('certi.png', 0, 0, 297, 210);
    }
}

// ✅ Get participant name
if (!isset($_SESSION['user_id']) || !isset($_SESSION['name'])) {
    die("Unauthorized access. Please log in.");
}
$user_id = $_SESSION['user_id'];
$participantName = strtoupper($_SESSION['name']);

// ✅ Get workshop id
$workshop_id = $_GET['workshop_id'] ?? null;
if (!$workshop_id) {
    die("Missing workshop ID.");
}

// Check if certificate already exists
$stmt = $conn->prepare("SELECT cert_no FROM certificates WHERE user_id=? AND workshop_id=?");
$stmt->bind_param("ii", $user_id, $workshop_id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows > 0) {
    $cert_no = $res->fetch_assoc()['cert_no']; // Already issued
} else {
    // Generate new cert number: KCS + year + week + padded ID
    $year = date("y"); // e.g., 25
    $week = str_pad(date("W"), 2, "0", STR_PAD_LEFT); // e.g., 26
    // Get next sequence
    $res2 = $conn->query("SELECT MAX(id) AS max_id FROM certificates");
    $nextId = ($res2->fetch_assoc()['max_id'] ?? 0) + 1;
    $sequence = str_pad($nextId, 5, "0", STR_PAD_LEFT);
    $cert_no = "KCS" . $year . $week . $sequence;

    // Insert into DB
    $stmt2 = $conn->prepare("INSERT INTO certificates (user_id, workshop_id, cert_no) VALUES (?, ?, ?)");
    $stmt2->bind_param("iis", $user_id, $workshop_id, $cert_no);
    $stmt2->execute();
    $stmt2->close();
}
$stmt->close();

// Fetch workshop details
$stmt = $conn->prepare("SELECT title, date FROM workshops1 WHERE id=?");
$stmt->bind_param("i", $workshop_id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $workshopTitle = $row['title'];
    $workshopDate  = date("d M Y", strtotime($row['date']));
} else {
    $workshopTitle = "Workshop";
    $workshopDate = "";
}
$stmt->close();
$conn->close();

// Create PDF
$pdf = new PDF('L', 'mm', 'A4');
$pdf->AddPage();

// ===== Participant Name =====
$pdf->SetFont('Times', 'B', 32);
$pdf->SetXY(0, 94);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(297, 10, $participantName, 0, 1, 'C');

// ===== Workshop Title with 10mm extra margin =====
$pdf->SetFont('Arial', 'B', 20);
$pdf->SetTextColor(0, 0, 128);
$pdf->SetXY(0, 118); // was 126 → now 126 + 10 margin
$pdf->Cell(297, 10, $workshopTitle . " held on " . $workshopDate, 0, 1, 'C');

// ===== Certificate Number at Bottom Left =====
$pdf->SetFont('Arial', 'B', 14); // Increased font
$pdf->SetTextColor(50, 50, 50);
$pdf->SetXY(10, 170); // Bottom left margin
$pdf->Cell(0, 10, "Certificate No: " . $cert_no, 0, 0, 'L');

// ===== Filename =====
$date = date("Y-m-d");
$cleanName = preg_replace('/[^A-Za-z0-9]/', '_', $participantName);
$filename = "certificate_" . $cleanName . "_" . $date . ".pdf";

// Output
$pdf->Output('D', $filename);
?>
