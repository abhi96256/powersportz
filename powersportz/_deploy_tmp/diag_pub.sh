#!/bin/bash
php <<'PHP'
<?php
$c = require '/var/www/html/common/config/main-local.php';
$p = new PDO($c['components']['db']['dsn'], $c['components']['db']['username'], $c['components']['db']['password']);
foreach ($p->query("SELECT ID, Title, PublishDate, Created, Updated FROM video WHERE ID>=15840 ORDER BY ID DESC LIMIT 10") as $r) {
  echo json_encode(array('ID'=>$r['ID'],'Title'=>$r['Title'],'PublishDate'=>$r['PublishDate'],'Created'=>$r['Created'],'Updated'=>$r['Updated'])) . "\n";
}
echo "zero_total=" . $p->query("SELECT COUNT(*) FROM video WHERE PublishDate LIKE '0000-00-00%' OR PublishDate IS NULL")->fetchColumn() . "\n";
PHP
# check if live create uses normalize
grep -n "normalizePublishDateUtc\|PublishDate" /var/www/html/backend/controllers/VideoController.php | head -30
# also check model rules / beforeSave
grep -rn "PublishDate" /var/www/html/backend/models/Video.php 2>/dev/null | head -20
grep -rn "PublishDate" /var/www/html/common/models/Video.php 2>/dev/null | head -20
