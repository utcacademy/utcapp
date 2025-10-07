<?php
session_start();
include 'db.php';
require('fpdf/fpdf.php');

class PDF extends FPDF {
    function Header() {
        // Background certificate template for courses (A4 Landscape)
        $this->Image('course_certi.png', 0, 0, 297, 210);
    }
}

// ✅ Ensure user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['name'])) {
    die("Unauthorized access. Please log in.");
}
$user_id = $_SESSION['user_id'];
$participantName = strtoupper($_SESSION['name']);

// ✅ Get course ID from URL
$course_id = $_GET['course_id'] ?? null;
if (!$course_id) {
    die("Missing course ID.");
}

// Check if certificate already exists
$stmt = $conn->prepare("SELECT cert_no FROM course_certifications WHERE user_id=? AND course_id=?");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("ii", $user_id, $course_id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows > 0) {
    $cert_no = $res->fetch_assoc()['cert_no']; // Already issued
} else {
    // Generate new certificate number: KCS + year + week + padded ID
    $year = date("y"); // e.g., 25
    $week = str_pad(date("W"), 2, "0", STR_PAD_LEFT); // e.g., 26
    $res2 = $conn->query("SELECT MAX(id) AS max_id FROM course_certifications");
    $nextId = ($res2->fetch_assoc()['max_id'] ?? 0) + 1;
    $sequence = str_pad($nextId, 5, "0", STR_PAD_LEFT);
    $cert_no = "KCS" . $year . $week . $sequence;

    // Insert into DB
    $stmt2 = $conn->prepare("INSERT INTO course_certifications (user_id, course_id, cert_no) VALUES (?, ?, ?)");
    $stmt2->bind_param("iis", $user_id, $course_id, $cert_no);
    $stmt2->execute();
    $stmt2->close();
}
$stmt->close();

// Fetch course details
$stmt = $conn->prepare("SELECT title FROM courses12 WHERE id=?");
$stmt->bind_param("i", $course_id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $courseTitle = $row['title'];
   // $courseDate  = date("d M Y", strtotime($row['date']));
} else {
    $courseTitle = "Course";
    $courseDate = "";
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

// // ===== Course Title =====
// $pdf->SetFont('Arial', 'B', 20);
// $pdf->SetTextColor(0, 0, 128);
// $pdf->SetXY(0, 118);
// $pdf->Cell(297, 10, $courseTitle . " held on " . $courseDate, 0, 1, 'C');

// ===== Certificate Number =====
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetTextColor(50, 50, 50);
$pdf->SetXY(110, 177);
$pdf->Cell(0, 10, "Certificate No: " . $cert_no, 0, 0, 'L');

// ===== Output PDF =====
$date = date("Y-m-d");
$cleanName = preg_replace('/[^A-Za-z0-9]/', '_', $participantName);
$filename = "certificate_" . $cleanName . "_" . $date . ".pdf";

$pdf->Output('D', $filename);
?>
