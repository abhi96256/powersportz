#!/bin/bash
echo "=== 15846 DB ==="
php <<'PHP'
<?php
$c = require '/var/www/html/common/config/main-local.php';
$p = new PDO($c['components']['db']['dsn'], $c['components']['db']['username'], $c['components']['db']['password']);
$r = $p->query("SELECT ID, Title, PublishDate, Created, Updated, shared_on FROM video WHERE ID=15846")->fetch(PDO::FETCH_ASSOC);
echo json_encode($r)."\n";
echo "related=".$p->query("SELECT GROUP_CONCAT(related_video) FROM related_videos WHERE video_id=15846")->fetchColumn()."\n";
echo "defThumbs=".$p->query("SELECT GROUP_CONCAT(images_id) FROM video_thumbnail_images WHERE video_id=15846 AND type='0'")->fetchColumn()."\n";
echo "libThumbs=".$p->query("SELECT GROUP_CONCAT(images_id) FROM video_thumbnail_images WHERE video_id=15846 AND type='1'")->fetchColumn()."\n";
PHP
echo "=== LIVE CODE CHECK ==="
grep -n "UPDATE video SET PublishDate\|Repair zero PublishDate\|Never persist MySQL\|isset(\$getSharedIcon" /var/www/html/backend/controllers/VideoController.php /var/www/html/backend/models/Video.php /var/www/html/backend/views/video/_form.php 2>/dev/null | head -20
echo "=== FILE DATES ==="
stat -c '%y %n' /var/www/html/backend/controllers/VideoController.php /var/www/html/backend/models/Video.php /var/www/html/backend/views/video/_form.php
