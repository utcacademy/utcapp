<?php
include 'db.php';

$q = $_GET['q'] ?? '';
$q = $conn->real_escape_string($q);

if(strlen($q) >= 2){
    $sql = "SELECT id, title, description, 'course' AS type FROM courses1 WHERE title LIKE '%$q%' 
            UNION
            SELECT id, title, description, 'workshop' AS type FROM workshops1 WHERE title LIKE '%$q%' 
            LIMIT 5";
    $res = $conn->query($sql);

    if($res->num_rows > 0){
        while($row = $res->fetch_assoc()){
            $url = ($row['type']=='course') ? 'course-detail.php?id='.$row['id'] : 'workshop-detail.php?id='.$row['id'];
            $icon = ($row['type']=='course') ? '🎓' : '🛠️';
            echo "<div class='result-item'>
                    <a href='$url'><span>$icon</span>{$row['title']} <small class='text-muted'>({$row['type']})</small></a>
                  </div>";
        }
    } else {
        echo "<div class='result-item'><p class='text-center mb-0'>No results found.</p></div>";
    }
}
?>
