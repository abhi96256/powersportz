#!/bin/bash
php <<'PHP'
<?php
$c = require '/var/www/html/common/config/main-local.php';
$p = new PDO($c['components']['db']['dsn'], $c['components']['db']['username'], $c['components']['db']['password']);
echo "zero_dates=".$p->query("SELECT COUNT(*) FROM video WHERE PublishDate LIKE '0000-00-00%' OR PublishDate IS NULL OR PublishDate=''")->fetchColumn()."\n";
foreach ($p->query("SELECT ID,Title,PublishDate,Created,Updated FROM video WHERE ID>=15840 ORDER BY ID DESC LIMIT 8") as $r) {
  echo json_encode($r)."\n";
}
PHP
echo "=== CODE ==="
grep -n 'ensurePublishDateInDb\|UPDATE video SET PublishDate' /var/www/html/backend/controllers/VideoController.php | head -8
grep -n 'Never persist MySQL' /var/www/html/backend/models/Video.php | head -2
grep -n 'isset($getSharedIcon' /var/www/html/backend/views/video/_form.php | head -2
stat -c '%y %s %n' /var/www/html/backend/controllers/VideoController.php /var/www/html/backend/models/Video.php
