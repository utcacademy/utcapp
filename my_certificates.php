<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
?>

<?php include('includes/header.php'); ?>

<section class="container py-5">
    <h2>🎓 My Certificates</h2>
    <p class="text-muted" style="color:green;">Here you can download certificates for workshops and courses.</p>

    <div class="row g-4">
        <?php
        // ===================== WORKSHOP CERTIFICATES =====================
        $sql = "SELECT w.id, w.title, w.date, r.feedback_given 
                FROM workshops1 w 
                JOIN registrations r ON w.id = r.workshop_id
                WHERE r.user_id=? AND r.feedback_given=1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $res = $stmt->get_result();

        if($res->num_rows > 0){
            echo '<h4 class="mb-3">Workshop Certificates</h4>';
            while($row = $res->fetch_assoc()){ ?>
                <div class="col-md-6">
                  <div class="card shadow border-0 h-100">
                    <div class="card-body">
                      <h5 class="card-title"><?= htmlspecialchars($row['title']); ?></h5>
                      <p><strong>Date:</strong> <?= date("d M Y", strtotime($row['date'])); ?></p>
                      <a href="certigen.php?workshop_id=<?= $row['id']; ?>" target="_blank" class="btn btn-primary">
                        Download Certificate
                      </a>
                    </div>
                  </div>
                </div>
        <?php }
        } else {
            echo '<p class="text-muted">No workshop certificates available yet.</p>';
        }

        // ===================== COURSE CERTIFICATES =====================
        $sqlC = "SELECT c.id, c.title, c.date 
                 FROM courses12 c
                 JOIN course_registrations cr ON c.id = cr.course_id
                 WHERE cr.user_id=?";
        $stmtC = $conn->prepare($sqlC);
        $stmtC->bind_param("i", $user_id);
        $stmtC->execute();
        $resC = $stmtC->get_result();

        if($resC->num_rows > 0){
            echo '<h4 class="mt-5 mb-3">Course Certificates</h4>';
            while($rowC = $resC->fetch_assoc()){ ?>
                <div class="col-md-6">
                  <div class="card shadow border-0 h-100">
                    <div class="card-body">
                      <h5 class="card-title"><?= htmlspecialchars($rowC['title']); ?></h5>
                      
                      <a href="course_certigen.php?course_id=<?= $rowC['id']; ?>" target="_blank" class="btn btn-primary">
                        Download Certificate
                      </a>
                    </div>
                  </div>
                </div>
        <?php }
        } else {
            echo '<p class="text-muted">No course certificates available yet.</p>';
        }
        ?>
    </div>
</section>

<?php include('includes/footer.php'); ?>
