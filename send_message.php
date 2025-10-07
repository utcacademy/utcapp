<?php
// DB Connection
$conn = new mysqli("localhost", "root", "", "aakkamkcs_db");
if ($conn->connect_error) {
    die("DB Connection Failed: " . $conn->connect_error);
}

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = $conn->real_escape_string($_POST['name']);
    $email   = $conn->real_escape_string($_POST['email']);
    $phone   = $conn->real_escape_string($_POST['phone']);
    $message = $conn->real_escape_string($_POST['message']);

    $sql = "INSERT INTO messages (name, email, phone, message) 
            VALUES ('$name', '$email', '$phone', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                alert('✅ Thank you! Your message has been sent successfully.');
                window.location.href='contact.php';
              </script>";
    } else {
        echo "<script>
                alert('❌ Error saving message. Please try again.');
                window.location.href='contact.php';
              </script>";
    }
}

$conn->close();
?>
