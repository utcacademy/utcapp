<?php
include '../db.php';

// Fetch all courses
$coursesResult = $conn->query("SELECT id, title, description FROM courses1 ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Courses / Days / Videos Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="p-4">
    <h2 class="mb-4">Courses / Days / Videos Dashboard</h2>

    <a href="add_course.php" class="btn btn-success mb-3"><i class="bi bi-plus-circle"></i> Add New Course</a>

    <div class="accordion" id="coursesAccordion">
        <?php if ($coursesResult && $coursesResult->num_rows > 0): ?>
            <?php while ($course = $coursesResult->fetch_assoc()): ?>
                <?php
                    $course_id = $course['id'];
                    // Fetch days for this course
                    $stmtDays = $conn->prepare("SELECT day_order, day_title FROM days WHERE course_id = ? ORDER BY day_order ASC");
                    $stmtDays->bind_param("i", $course_id);
                    $stmtDays->execute();
                    $daysResult = $stmtDays->get_result();
                ?>
                <div class="accordion-item mb-2">
                    <h2 class="accordion-header" id="heading<?= $course_id ?>">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $course_id ?>" aria-expanded="false" aria-controls="collapse<?= $course_id ?>">
                            <?= htmlspecialchars($course['title']) ?> (<?= htmlspecialchars($course['description']) ?>)
                        </button>
                    </h2>
                    <div id="collapse<?= $course_id ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $course_id ?>" data-bs-parent="#coursesAccordion">
                        <div class="accordion-body">
                            <!-- Course Actions -->
                            <div class="mb-2">
                                <a href="edit_course.php?id=<?= $course_id ?>" class="btn btn-sm btn-warning me-2"><i class="bi bi-pencil-square"></i> Edit Course</a>
                                <a href="delete_course.php?id=<?= $course_id ?>" class="btn btn-sm btn-danger me-2" onclick="return confirm('Delete this course?');"><i class="bi bi-trash"></i> Delete Course</a>
                                <a href="add_day.php?course_id=<?= $course_id ?>" class="btn btn-sm btn-success"><i class="bi bi-plus-circle"></i> Add Day</a>
                            </div>

                            <!-- Days Table -->
                            <?php if ($daysResult && $daysResult->num_rows > 0): ?>
                                <div class="accordion mt-3" id="daysAccordion<?= $course_id ?>">
                                    <?php while($day = $daysResult->fetch_assoc()): ?>
                                        <?php
                                            $day_id = $day['day_order'];
                                            // Fetch videos for this day
                                            $stmtVideos = $conn->prepare("SELECT video_id, video_title, youtube_id, video_order FROM videos WHERE day_id = ? ORDER BY video_order ASC");
                                            $stmtVideos->bind_param("i", $day_id);
                                            $stmtVideos->execute();
                                            $videosResult = $stmtVideos->get_result();
                                        ?>
                                        <div class="accordion-item mb-2">
                                            <h2 class="accordion-header" id="headingDay<?= $course_id ?><?= $day_id ?>">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDay<?= $course_id ?><?= $day_id ?>" aria-expanded="false">
                                                    Day <?= $day['day_order'] ?>: <?= htmlspecialchars($day['day_title']) ?>
                                                </button>
                                            </h2>
                                            <div id="collapseDay<?= $course_id ?><?= $day_id ?>" class="accordion-collapse collapse" aria-labelledby="headingDay<?= $course_id ?><?= $day_id ?>" data-bs-parent="#daysAccordion<?= $course_id ?>">
                                                <div class="accordion-body">
                                                    <!-- Day Actions -->
                                                    <div class="mb-2">
                                                        <a href="edit_day.php?course_id=<?= $course_id ?>&day_id=<?= $day_id ?>" class="btn btn-sm btn-warning me-2"><i class="bi bi-pencil-square"></i> Edit Day</a>
                                                        <a href="delete_day.php?course_id=<?= $course_id ?>&day_id=<?= $day_id ?>" class="btn btn-sm btn-danger me-2" onclick="return confirm('Delete this day?');"><i class="bi bi-trash"></i> Delete Day</a>
                                                        <a href="add_video.php?day_id=<?= $day_id ?>" class="btn btn-sm btn-success"><i class="bi bi-plus-circle"></i> Add Video</a>
                                                    </div>

                                                    <!-- Videos Table -->
                                                    <table class="table table-bordered table-striped mt-2">
                                                        <thead class="table-dark">
                                                            <tr>
                                                                <th>Order</th>
                                                                <th>Title</th>
                                                                <th>Youtube ID</th>
                                                                <th style="width:150px;">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if ($videosResult && $videosResult->num_rows > 0): ?>
                                                                <?php while($video = $videosResult->fetch_assoc()): ?>
                                                                    <tr>
                                                                        <td><?= $video['video_order'] ?></td>
                                                                        <td><?= htmlspecialchars($video['video_title']) ?></td>
                                                                        <td><?= htmlspecialchars($video['youtube_id']) ?></td>
                                                                        <td>
                                                                            <a href="edit_video.php?video_id=<?= $video['video_id'] ?>" class="btn btn-sm btn-warning me-2"><i class="bi bi-pencil-square"></i></a>
                                                                            <a href="delete_video.php?video_id=<?= $video['video_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this video?');"><i class="bi bi-trash"></i></a>
                                                                        </td>
                                                                    </tr>
                                                                <?php endwhile; ?>
                                                            <?php else: ?>
                                                                <tr><td colspan="4" class="text-center">No videos added yet</td></tr>
                                                            <?php endif; ?>
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                        </div>
                                    <?php endwhile; ?>
                                </div>
                            <?php else: ?>
                                <p>No days added yet.</p>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="alert alert-info">No courses found. Please add a course.</div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
