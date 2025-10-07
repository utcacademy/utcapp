<?php
// DB Connection
$conn = new mysqli("localhost","root","","aakkamkcs_db");

//$conn = new mysqli("localhost","aakkam_kcs","Aakkam@kcs","aakkam_kcs");
if ($conn->connect_error) {
    die("DB Connection Failed: " . $conn->connect_error);
}
?>