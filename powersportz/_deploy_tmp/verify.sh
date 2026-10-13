#!/bin/bash
grep -n "ConvertDateTolocaltime\|0000-00-00" /var/www/html/common/config/commonfunctions.php | head -20
grep -n "beforeSubmit\|Update request failed\|IsRelatedVideoId\|IsDefaultthumbnail" /var/www/html/backend/views/layouts/main.php | head -25
php <<'PHP'
<?php
$c = require '/var/www/html/common/config/main-local.php';
$p = new PDO($c['components']['db']['dsn'], $c['components']['db']['username'], $c['components']['db']['password']);
foreach ($p->query("SELECT ID, Title, PublishDate FROM video WHERE ID IN (15842,15843)") as $x) {
  echo json_encode($x) . "\n";
}
PHP
