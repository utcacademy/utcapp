<?php
// course_videos.php
// Single-file responsive player + collapsible playlist grouped by Day

// --- DB connection (update with your credentials) ---
// $host = "localhost";
// $user = "root";
// $pass = "";
// $db   = "your_db";   // <<< change this
// $conn = new mysqli($host, $user, $pass, $db);
include('db.php');

if ($conn->connect_error) die("DB connection failed: " . $conn->connect_error);

// --- get course id from query ---
$course_id = isset($_GET['course_id']) ? intval($_GET['course_id']) : 0;
if ($course_id <= 0) {
    die("Please provide a valid course_id in the URL, e.g. ?course_id=1");
}

// --- fetch course ---
$courseStmt = $conn->prepare("SELECT * FROM courses12 WHERE id = ?");
$courseStmt->bind_param("i", $course_id);
$courseStmt->execute();
$courseRes = $courseStmt->get_result();
$course = $courseRes->fetch_assoc();
if (!$course) {
    die("Course not found");
}

// --- fetch days for the course ordered by day_order or id ---
$daysStmt = $conn->prepare("SELECT * FROM days WHERE course_id = ? ORDER BY day_order ASC, day_id ASC");
$daysStmt->bind_param("i", $course_id);
$daysStmt->execute();
$daysRes = $daysStmt->get_result();

$days = [];
while ($d = $daysRes->fetch_assoc()) {
    $days[$d['day_id']] = $d;
    $days[$d['day_id']]['videos'] = [];
}

// --- fetch all videos for course, grouped by day_id, ordered by video_order ---
$videosStmt = $conn->prepare("
    SELECT v.* 
    FROM videos v
    JOIN days d ON v.day_id = d.day_id
    WHERE d.course_id = ?
    ORDER BY d.day_order ASC, d.day_id ASC, v.video_order ASC, v.video_id ASC
");
$videosStmt->bind_param("i", $course_id);
$videosStmt->execute();
$videosRes = $videosStmt->get_result();

while ($v = $videosRes->fetch_assoc()) {
    $did = $v['day_id'];
    if (!isset($days[$did])) {
        // fallback: create day entry if missing
        $days[$did] = ['day_id'=>$did, 'day_title'=>$v['day_title'] ?? 'Day', 'day_order'=>0, 'videos'=>[]];
    }
    $days[$did]['videos'][] = $v;
}

// Flatten days into sequential array (preserve order)
$daysList = array_values($days);

// Build a flat video list (for next/prev and indexing)
$flatVideos = [];
foreach ($daysList as $day) {
    foreach ($day['videos'] as $video) {
        $flatVideos[] = [
            'day_id' => $day['day_id'],
            'day_title' => $day['day_title'],
            'video_id' => $video['video_id'],
            'video_title' => $video['video_title'],
            'youtube_id' => $video['youtube_id'],
            'video_order' => $video['video_order']
        ];
    }
}

// choose initial video (first in flat list)
$initial = $flatVideos[0] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title><?= htmlspecialchars($course['title']) ?> — Videos</title>
  <style>
    :root{
      --bg:#0f172a; --panel:#0b1220; --card:#0f172a; --muted:#9ca3af; --accent:#22d3ee; --accent-2:#c62828;
      --text:#e6eef6;
    }
    *{box-sizing:border-box}
    body{margin:0;font-family:Inter, Roboto, Arial, sans-serif;background:linear-gradient(180deg,#071126 0%, #07111b 100%);color:var(--text);min-height:100vh}
    .container{max-width:1200px;margin:20px auto;padding:16px;display:grid;grid-template-columns: 320px 1fr;gap:18px}
    header.course-head{grid-column:1/-1;background:var(--card);padding:18px;border-radius:12px;display:flex;align-items:center;gap:16px;box-shadow:0 8px 30px rgba(2,6,23,0.6)}
    header h1{margin:0;font-size:20px}
    header p{margin:0;color:var(--muted)}
    /* Playlist sidebar */
    .sidebar{background:#071022;border-radius:12px;padding:10px;height:calc(80vh);overflow:auto;border:1px solid rgba(255,255,255,0.03)}
    .day{margin-bottom:8px}
    .day-header{display:flex;justify-content:space-between;align-items:center;padding:10px;border-radius:8px;cursor:pointer;user-select:none;background:linear-gradient(180deg, rgba(255,255,255,0.01), transparent)}
    .day-header:hover{background:rgba(255,255,255,0.02)}
    .day-title{font-weight:700;color:var(--accent)}
    .day-toggle{font-size:14px;color:var(--muted)}
    .video-list{margin-top:8px;padding-left:6px}
    .video-card{display:flex;gap:10px;align-items:center;padding:8px;border-radius:8px;margin-bottom:8px;cursor:pointer;transition:transform .18s, box-shadow .18s, background .18s}
    .video-card:hover{transform:translateY(-4px);box-shadow:0 8px 20px rgba(0,0,0,0.6);background:linear-gradient(90deg, rgba(232, 242, 255, 0.02), rgba(34,211,238,0.02))}
    .video-card.active{background:linear-gradient(90deg, rgba(34,211,238,0.12), rgba(34,211,238,0.04));box-shadow:0 10px 24px rgba(3,9,21,0.6)}
    .thumb{width:110px;height:64px;border-radius:6px;overflow:hidden;background:#000;flex:0 0 auto}
    .thumb img{width:100%;height:100%;object-fit:cover;display:block}
    .meta{min-width:0}
    .v-title{font-size:13px;margin:0 0 6px 0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;color:var(--text)}
    .v-sub{font-size:12px;color:var(--muted);margin:0}
    /* Player area */
    .player-area{background:linear-gradient(180deg, rgba(255,255,255,0.02), transparent);padding:12px;border-radius:12px;min-height:60vh;border:1px solid rgba(255,255,255,0.03);display:flex;flex-direction:column;gap:12px}
    .video-wrap{background:#000;border-radius:10px;overflow:hidden;display:flex;align-items:center;justify-content:center;min-height:360px}
    .video-wrap iframe{width:100%;height:420px;border:0}
    .controls{display:flex;gap:10px;align-items:center}
    .btn{background:var(--accent-2);color:#fff;padding:8px 12px;border-radius:8px;cursor:pointer;border:0;font-weight:600}
    .btn.secondary{background:transparent;border:1px solid rgba(255,255,255,0.06);color:var(--text)}
    .video-info h3{margin:0;font-size:18px}
    .video-info p{margin:4px 0 0;color:var(--muted)}
    /* responsive */
    @media (max-width: 980px){
      .container{grid-template-columns:1fr; padding:10px}
      .sidebar{height:auto;order:2}
      .player-area{order:1}
      .video-wrap iframe{height:320px}
    }
  </style>
</head>
<body>
  <div class="container">
    <header class="course-head">
      <div style="flex:1">
        <h1><?= htmlspecialchars($course['title']) ?></h1>
        <p><?= htmlspecialchars($course['description'] ?? '') ?></p>
      </div>
     
    </header>

    <!-- Sidebar: Collapsible days & videos -->
    <aside class="sidebar" id="sidebar">
      <?php if (empty($daysList)): ?>
        <p style="color:var(--muted);padding:12px">No videos found for this course.</p>
      <?php else: ?>
        <?php foreach ($daysList as $di => $day): ?>
          <div class="day" data-day-index="<?= $di ?>">
            <div class="day-header" role="button" aria-expanded="true" onclick="toggleDay(<?= $di ?>)">
              <div class="day-title"><?= htmlspecialchars($day['day_title']) ?></div>
              <div class="day-toggle" id="toggle-<?= $di ?>">▾</div>
            </div>

            <div class="video-list" id="day-<?= $di ?>">
              <?php foreach ($day['videos'] as $vi => $video): 
                // compute flat index for this video
                // find index in flatVideos by matching video_id
                $flatIndex = null;
                foreach ($flatVideos as $findex => $f) {
                    if ($f['video_id'] == $video['video_id']) { $flatIndex = $findex; break; }
                }
                ?>
                <div class="video-card" data-index="<?= $flatIndex ?>" data-yid="<?= htmlspecialchars($video['youtube_id']) ?>" data-title="<?= htmlspecialchars($video['video_title']) ?>" onclick="playByIndex(<?= $flatIndex ?>)">
                  <div class="thumb">
                    <img src="https://i.ytimg.com/vi/<?= htmlspecialchars($video['youtube_id']) ?>/hqdefault.jpg" alt="">
                  </div>
                  <div class="meta">
                    <p class="v-title"><?= htmlspecialchars($video['video_title']) ?></p>
                    <p class="v-sub"><?= htmlspecialchars($day['day_title']) ?></p>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </aside>

    <!-- Main player -->
    <main class="player-area">
         <div class="video-info">
        <h3 id="mainTitle"><?= htmlspecialchars($initial['video_title'] ?? '—') ?></h3>
        <p id="mainDay"><?= htmlspecialchars($initial['day_title'] ?? '') ?></p>
      </div>

      <div class="controls">
        <button class="btn" id="prevBtn">⟨ Prev</button>
        <button class="btn" id="nextBtn">Next ⟩</button>
        <button class="btn secondary" id="expandAll">Expand All</button>
        <div style="flex:1"></div>
      </div>
      <div class="video-wrap">
        <?php if ($initial): ?>
          <iframe id="mainIframe" src="https://www.youtube.com/embed/<?= htmlspecialchars($initial['youtube_id']) ?>?rel=0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; picture-in-picture" allowfullscreen></iframe>
        <?php else: ?>
          <div style="color:var(--muted);padding:30px">No video to play</div>
        <?php endif; ?>
      </div>

     
    </main>
  </div>

<script>
  // Build flatVideos array in JS from PHP flatVideos
  const flatVideos = <?= json_encode($flatVideos, JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_AMP|JSON_HEX_QUOT) ?>;
  let currentIndex = 0;
  if (flatVideos.length > 0) {
    // find initial index by matching iframe src if provided
    const initialYid = document.getElementById('mainIframe') ? new URL(document.getElementById('mainIframe').src).pathname.split('/').pop() : null;
    if (initialYid) {
      const idx = flatVideos.findIndex(f => f.youtube_id === initialYid);
      currentIndex = idx >= 0 ? idx : 0;
    } else {
      currentIndex = 0;
    }
  }

  const mainIframe = document.getElementById('mainIframe');
  const mainTitle = document.getElementById('mainTitle');
  const mainDay = document.getElementById('mainDay');
  const videoCards = Array.from(document.querySelectorAll('.video-card'));

  function highlightActive() {
    videoCards.forEach(c => c.classList.remove('active'));
    const el = document.querySelector('.video-card[data-index="'+currentIndex+'"]');
    if (el) {
      el.classList.add('active');
      // ensure visible in sidebar
      el.scrollIntoView({block:'nearest', behavior:'smooth'});
    }
    const cur = flatVideos[currentIndex];
    if (cur) {
      mainTitle.textContent = cur.video_title;
      mainDay.textContent = cur.day_title;
    }
  }

  function playByIndex(idx) {
    if (!flatVideos[idx]) return;
    const yid = flatVideos[idx].youtube_id;
    // update iframe (reload)
    if (mainIframe) {
      mainIframe.src = `https://www.youtube.com/embed/${yid}?rel=0`;
    }
    currentIndex = idx;
    highlightActive();
    // update URL hash for shareability
    history.replaceState(null, '', '#'+yid);
  }

  // prev / next handlers
  document.getElementById('prevBtn').addEventListener('click', ()=>{
    if (currentIndex > 0) {
      playByIndex(currentIndex - 1);
    }
  });
  document.getElementById('nextBtn').addEventListener('click', ()=>{
    if (currentIndex < flatVideos.length - 1) {
      playByIndex(currentIndex + 1);
    }
  });

  // keyboard navigation
  document.addEventListener('keydown', (e)=>{
    if (e.key === 'ArrowLeft') {
      if (currentIndex > 0) playByIndex(currentIndex - 1);
    } else if (e.key === 'ArrowRight') {
      if (currentIndex < flatVideos.length - 1) playByIndex(currentIndex + 1);
    } else if (e.key === 'ArrowUp') {
      // move up the playlist (previous)
      const idx = Math.max(0, currentIndex - 1);
      playByIndex(idx);
    } else if (e.key === 'ArrowDown') {
      const idx = Math.min(flatVideos.length - 1, currentIndex + 1);
      playByIndex(idx);
    }
  });

  // toggle day collapse
  function toggleDay(dayIndex) {
    const list = document.getElementById('day-' + dayIndex);
    const togg = document.getElementById('toggle-' + dayIndex);
    if (!list) return;
    const isHidden = list.style.display === 'none';
    list.style.display = isHidden ? 'block' : 'none';
    togg.textContent = isHidden ? '▾' : '▸';
  }

  // Expand / Collapse all
  document.getElementById('expandAll').addEventListener('click', ()=>{
    const lists = document.querySelectorAll('.video-list');
    const toggles = document.querySelectorAll('[id^="toggle-"]');
    let anyClosed = Array.from(lists).some(l => l.style.display === 'none' || getComputedStyle(l).display === 'none');
    lists.forEach((l, i) => {
      l.style.display = anyClosed ? 'block' : 'none';
      toggles[i].textContent = anyClosed ? '▾' : '▸';
    });
  });

  // initialize default collapsed/expanded state: expand first day, collapse others (mobile friendly)
  (function initDays() {
    const lists = document.querySelectorAll('.video-list');
    lists.forEach((l, idx) => {
      if (idx === 0) {
        l.style.display = 'block';
        document.getElementById('toggle-' + idx).textContent = '▾';
      } else {
        l.style.display = 'none';
        document.getElementById('toggle-' + idx).textContent = '▸';
      }
    });
  })();

  // mark active video on load
  if (flatVideos.length > 0) {
    // if URL hash present, prefer that
    const h = location.hash.replace('#','');
    const hi = flatVideos.findIndex(f => f.youtube_id === h);
    if (hi >= 0) currentIndex = hi;
    playByIndex(currentIndex);
  }
</script>
</body>
</html>
