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
    <h2>Welcome, <?= htmlspecialchars($_SESSION['name']); ?></h2>

    <!-- ===================== Workshops Section ===================== -->
    <h4 class="mt-4">Your Registered Workshops</h4>
    <div class="row g-4">
<?php
$sql = "SELECT w.* 
        FROM workshops1 w 
        JOIN registrations r ON w.id = r.workshop_id
        WHERE r.user_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();

$current_time = date("Y-m-d H:i:s");

if($res->num_rows > 0){
    while($row = $res->fetch_assoc()){
        $start = strtotime($row['date'].' '.$row['time']);
        $end   = strtotime($row['date'].' '.$row['time'].' +2 hours');
        $now   = strtotime($current_time);

        $is_started   = $now >= $start;
        $is_completed = $now > $end;
        ?>

        <div class="col-md-6">
          <div class="card shadow-lg border-0 h-100">
            <div class="card-body">
              <div class="d-flex justify-content-end mb-2">
                <?php if(!$is_started): ?>
                    <span class="badge bg-warning"><i class="bi bi-hourglass-split"></i> Upcoming</span>
                <?php elseif($is_started && !$is_completed): ?>
                    <span class="badge bg-success"><i class="bi bi-broadcast-pin"></i> Live</span>
                <?php else: ?>
                    <span class="badge bg-danger"><i class="bi bi-check-circle-fill"></i> Completed</span>
                <?php endif; ?>
              </div>

              <h5 class="card-title mb-3 text-center"><?= htmlspecialchars($row['title']); ?></h5>
              <p><strong>Date:</strong> <?= date("d M Y", strtotime($row['date'])); ?></p>
              <p><strong>Time:</strong> <?= date("h:i A", strtotime($row['time'])); ?></p>

              <?php
              if(!$is_completed){
                  if($is_started){
                      echo '<a href="join.php?id='.$row['id'].'" class="btn btn-success me-2">Join Session</a>';
                  } else {
                      echo '<button class="btn btn-outline-secondary me-2" disabled>Join Session</button>';
                  }
              } else {
                  echo '<a href="certigen.php?workshop_id='.$row['id'].'" target="_blank" class="btn btn-primary mb-2 me-2"><i class="bi bi-award-fill"></i> Certificate</a>';
                  echo !empty($row['notes']) 
                        ? '<a href="'.htmlspecialchars($row['notes']).'" class="btn btn-info mb-2 me-2" target="_blank"><i class="bi bi-file-earmark-text"></i> Notes</a>'
                        : '<button class="btn btn-outline-info mb-2 me-2" disabled>No Notes</button>';
                  echo !empty($row['video_link'])
                        ? '<button class="btn btn-danger mb-2" data-bs-toggle="modal" data-bs-target="#videoModalW'.$row['id'].'"><i class="bi bi-play-circle-fill"></i> Video</button>'
                        : '<button class="btn btn-outline-danger mb-2" disabled>No Video</button>';
              }
              ?>
            </div>
          </div>
        </div>

        <?php if($is_completed && !empty($row['video_link'])): ?>
            <div class="modal fade" id="videoModalW<?= $row['id']; ?>" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title"><?= htmlspecialchars($row['title']); ?> - Video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body text-center">
                    <?php
                    if (strpos($row['video_link'], 'youtube.com') !== false || strpos($row['video_link'], 'youtu.be') !== false) {
                        if (strpos($row['video_link'], 'watch?v=') !== false) {
                            parse_str(parse_url($row['video_link'], PHP_URL_QUERY), $params);
                            $videoId = $params['v'] ?? '';
                        } else {
                            $videoId = basename(parse_url($row['video_link'], PHP_URL_PATH));
                        }
                        echo '<iframe width="100%" height="500" src="https://www.youtube-nocookie.com/embed/'.$videoId.'?rel=0&modestbranding=1&showinfo=0&controls=1" frameborder="0" allowfullscreen></iframe>';
                    } else {
                        echo '<video width="100%" height="500" controls><source src="'.htmlspecialchars($row['video_link']).'" type="video/mp4"></video>';
                    }
                    ?>
                  </div>
                </div>
              </div>
            </div>
        <?php endif; ?>

        <?php
    }
} else {
    echo '<p>You have not registered for any workshops yet.</p>';
}
?>
    </div>

    <!-- ===================== Courses Section ===================== -->
    <h4 class="mt-5">Your Enrolled Courses</h4>
    <div class="row g-4">
<?php
$sql = "SELECT c.* 
        FROM courses12 c 
        JOIN course_registrations r ON c.id = r.course_id
        WHERE r.user_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();

if($res->num_rows > 0){
    while($row = $res->fetch_assoc()){
       
        ?>

        <div class="col-md-6">
          <div class="card shadow-lg border-0 h-100">
            <div class="card-body">
              <div class="d-flex justify-content-end mb-2">
                
              </div>

              <h5 class="card-title mb-3 text-center"><?= htmlspecialchars($row['title']); ?></h5>
              <p><strong></strong> <?= htmlspecialchars($row['subtitle']); ?></p>

             <?php
if (!$is_completed) {
    if ($is_started) {
        echo '<a href="join_course.php?id=' . intval($row['id']) . '" class="btn btn-success me-2">Join Session</a>';
    } else {
        echo '<button class="btn btn-outline-secondary me-2" disabled>Join Session</button>';
    }
} else {
    // Certificate button
    echo '<a href="course_certigen.php?course_id=' . intval($row['id']) . '" target="_blank" class="btn btn-primary mb-2 me-2">
            <i class="bi bi-award-fill"></i> Certificate
          </a>';

    // Notes button
    if (!empty($row['notes'])) {
        echo '<a href="' . htmlspecialchars($row['notes']) . '" class="btn btn-info mb-2 me-2" target="_blank">
                <i class="bi bi-file-earmark-text"></i> Notes
              </a>';
    } else {
        echo '<button class="btn btn-outline-info mb-2 me-2" disabled>No Notes</button>';
    }

    // Video button --> REDIRECT INSTEAD OF MODAL
  
        echo '<a href="course_vid.php?course_id=' . intval($row['id']) . '" class="btn btn-danger mb-2" target="_blank">
                <i class="bi bi-play-circle-fill"></i> Video
              </a>';
    
}
?>

            </div>
          </div>
        </div>

        <?php if($is_completed && !empty($row['video_link'])): ?>
            <div class="modal fade" id="videoModalC<?= $row['id']; ?>" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title"><?= htmlspecialchars($row['title']); ?> - Video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body text-center">
                    <?php
                    if (strpos($row['video_link'], 'youtube.com') !== false || strpos($row['video_link'], 'youtu.be') !== false) {
                        if (strpos($row['video_link'], 'watch?v=') !== false) {
                            parse_str(parse_url($row['video_link'], PHP_URL_QUERY), $params);
                            $videoId = $params['v'] ?? '';
                        } else {
                            $videoId = basename(parse_url($row['video_link'], PHP_URL_PATH));
                        }
                        echo '<iframe width="100%" height="500" src="https://www.youtube-nocookie.com/embed/'.$videoId.'?rel=0&modestbranding=1&showinfo=0&controls=1" frameborder="0" allowfullscreen></iframe>';
                    } else {
                        echo '<video width="100%" height="500" controls><source src="'.htmlspecialchars($row['video_link']).'" type="video/mp4"></video>';
                    }
                    ?>
                  </div>
                </div>
              </div>
            </div>
        <?php endif; ?>

        <?php
    }
} else {
    echo '<p>You have not enrolled in any courses yet.</p>';
}
?>
    </div>
</section>

<script>
document.querySelectorAll('.modal').forEach(modal => {
  modal.addEventListener('hidden.bs.modal', () => {
    let iframe = modal.querySelector('iframe');
    let video = modal.querySelector('video');
    if (iframe) iframe.src = iframe.src;
    if (video) { video.pause(); video.currentTime = 0; }
  });
});
</script>

<?php include('includes/footer.php'); ?>
