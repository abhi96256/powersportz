#!/bin/bash
set -e
sudo cp /home/ubuntu/VideoController.php /var/www/html/backend/controllers/VideoController.php
sudo cp /home/ubuntu/main.php /var/www/html/backend/views/layouts/main.php
sudo cp /home/ubuntu/video.js /var/www/html/backend/web/js/video.js
sudo cp /home/ubuntu/commonfunctions.php /var/www/html/common/config/commonfunctions.php
sudo chown www-data:www-data \
  /var/www/html/backend/controllers/VideoController.php \
  /var/www/html/backend/views/layouts/main.php \
  /var/www/html/backend/web/js/video.js \
  /var/www/html/common/config/commonfunctions.php
php -l /var/www/html/backend/controllers/VideoController.php
php -l /var/www/html/common/config/commonfunctions.php
grep -n "normalizePublishDateUtc\|saveRelatedAndThumbnails\|IsDefaultthumbnailVideoId%5D\|addgeneratedthumbimages" /var/www/html/backend/controllers/VideoController.php /var/www/html/backend/views/layouts/main.php /var/www/html/backend/web/js/video.js | head -30
php <<'PHP'
<?php
$c = require '/var/www/html/common/config/main-local.php';
$p = new PDO($c['components']['db']['dsn'], $c['components']['db']['username'], $c['components']['db']['password']);
$n = $p->exec("UPDATE video SET PublishDate = UTC_TIMESTAMP() WHERE PublishDate IS NULL OR PublishDate LIKE '0000-00-00%'");
echo "fixed_zero_dates=$n\n";
foreach (array(15842, 15843) as $id) {
  $v = $p->query("SELECT ID, PublishDate, Title FROM video WHERE ID=$id")->fetch(PDO::FETCH_ASSOC);
  echo json_encode($v) . "\n";
  echo "related=" . $p->query("SELECT GROUP_CONCAT(related_video) FROM related_videos WHERE video_id=$id")->fetchColumn() . "\n";
  echo "defThumbs=" . $p->query("SELECT GROUP_CONCAT(images_id) FROM video_thumbnail_images WHERE video_id=$id AND type='0'")->fetchColumn() . "\n";
  echo "libThumbs=" . $p->query("SELECT GROUP_CONCAT(images_id) FROM video_thumbnail_images WHERE video_id=$id AND type='1'")->fetchColumn() . "\n";
}
PHP
echo DONE
