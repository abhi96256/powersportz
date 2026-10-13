#!/bin/bash
php <<'PHP'
<?php
$c = require '/var/www/html/common/config/main-local.php';
$p = new PDO($c['components']['db']['dsn'], $c['components']['db']['username'], $c['components']['db']['password']);
$id = 15843;
$v = $p->query("SELECT ID, Title, PublishDate, Updated FROM video WHERE ID=$id")->fetch(PDO::FETCH_ASSOC);
echo "video=" . json_encode($v) . "\n";
echo "related=" . $p->query("SELECT GROUP_CONCAT(related_video) FROM related_videos WHERE video_id=$id")->fetchColumn() . "\n";
echo "defThumbs=" . $p->query("SELECT GROUP_CONCAT(images_id) FROM video_thumbnail_images WHERE video_id=$id AND type='0'")->fetchColumn() . "\n";
echo "libThumbs=" . $p->query("SELECT GROUP_CONCAT(images_id) FROM video_thumbnail_images WHERE video_id=$id AND type='1'")->fetchColumn() . "\n";
echo "generated_images=" . $p->query("SELECT COUNT(*) FROM images WHERE VideoID=$id AND ImageType='1'")->fetchColumn() . "\n";
// fix again if zero
$n = $p->exec("UPDATE video SET PublishDate = COALESCE(NULLIF(Created,'0000-00-00 00:00:00'), UTC_TIMESTAMP()) WHERE ID=$id AND (PublishDate IS NULL OR PublishDate LIKE '0000-00-00%')");
echo "fixed_rows=$n\n";
$v2 = $p->query("SELECT ID, PublishDate FROM video WHERE ID=$id")->fetch(PDO::FETCH_ASSOC);
echo "after=" . json_encode($v2) . "\n";
PHP
