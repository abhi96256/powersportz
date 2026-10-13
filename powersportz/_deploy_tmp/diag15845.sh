#!/bin/bash
set -e
echo "=== DB 15845 ==="
php <<'PHP'
<?php
$c = require '/var/www/html/common/config/main-local.php';
$p = new PDO($c['components']['db']['dsn'], $c['components']['db']['username'], $c['components']['db']['password']);
foreach ($p->query("SELECT ID, Title, PublishDate, Created, Updated, VideoURL, VideoStreamURL FROM video WHERE ID>=15842 ORDER BY ID") as $r) {
  echo json_encode(array(
    'ID'=>$r['ID'],'Title'=>$r['Title'],'PublishDate'=>$r['PublishDate'],
    'Created'=>$r['Created'],'Updated'=>$r['Updated'],
    'hasURL'=>!empty($r['VideoURL']),'hasStream'=>!empty($r['VideoStreamURL'])
  ))."\n";
}
echo "zero_count=".$p->query("SELECT COUNT(*) FROM video WHERE PublishDate LIKE '0000-00-00%' OR PublishDate IS NULL OR PublishDate=''")->fetchColumn()."\n";
PHP

echo "=== LIVE CODE MARKERS ==="
grep -n "Force PublishDate\|Never persist MySQL\|normalizePublishDateUtc\|videoData->save" /var/www/html/backend/controllers/VideoController.php | head -20
grep -n "Never persist MySQL\|PublishDate === null" /var/www/html/backend/models/Video.php | head -10

echo "=== FILE MTIMES ==="
stat -c '%y %n' /var/www/html/backend/controllers/VideoController.php /var/www/html/backend/models/Video.php

echo "=== TRIGGERS ==="
php <<'PHP'
<?php
$c = require '/var/www/html/common/config/main-local.php';
$p = new PDO($c['components']['db']['dsn'], $c['components']['db']['username'], $c['components']['db']['password']);
foreach ($p->query("SHOW TRIGGERS WHERE `Table`='video'") as $t) {
  echo json_encode($t)."\n";
}
echo "sql_mode=".$p->query("SELECT @@sql_mode")->fetchColumn()."\n";
PHP
