<?php
session_start();
include 'db.php';

if(!isset($_GET['id'])) header("Location: workshops.php");

$workshop_id = intval($_GET['id']);

// Get workshop info
$stmt = $conn->prepare("SELECT * FROM workshops1 WHERE id=?");
$stmt->bind_param("i",$workshop_id);
$stmt->execute();
$workshop = $stmt->get_result()->fetch_assoc();
?>

<?php include('includes/header.php'); ?>
<section class="container py-5 text-center">
  <h2>Thank you for registering!</h2>
  <p>You have successfully registered for <strong><?php echo $workshop['title']; ?></strong>.</p>
  <a href="workshops.php" class="btn btn-primary mt-3">Back to Workshops</a>
</section>

<section class="container py-5">
<h3>Other Workshops You May Like</h3>
<div class="row g-4">
<?php
$sql = "SELECT * FROM workshops1 WHERE id != $workshop_id and highlighted=1 LIMIT 3";
$res = $conn->query($sql);
while($row = $res->fetch_assoc()){
    echo '<div class="col-lg-4 col-md-6">
    <div class="p-3 bg-dark text-white rounded-3">
      <h5>'.$row['title'].'</h5>
      <p>'.substr($row['description'],0,80).'...</p>
      <a href="workshop-detail.php?id='.$row['id'].'" class="btn btn-primary mt-2">View Details</a>
    </div></div>';
}
?>
</div>
</section>
<?php include('includes/footer.php'); ?>
