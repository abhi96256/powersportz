#!/bin/bash
grep -n "normalizePublishDateUtc\|PublishDate" /var/www/html/backend/controllers/VideoController.php | head -40
php <<'PHP'
<?php
// Simulate what normalize does - read function from file
$c = require '/var/www/html/common/config/main-local.php';
$p = new PDO($c['components']['db']['dsn'], $c['components']['db']['username'], $c['components']['db']['password']);
echo "15843=" . json_encode($p->query("SELECT PublishDate FROM video WHERE ID=15843")->fetch(PDO::FETCH_ASSOC)) . "\n";
echo "zero_count=" . $p->query("SELECT COUNT(*) FROM video WHERE PublishDate LIKE '0000-00-00%'")->fetchColumn() . "\n";
// fix ALL remaining zero dates so Update forms work
$n = $p->exec("UPDATE video SET PublishDate = COALESCE(NULLIF(Created,'0000-00-00 00:00:00'), UTC_TIMESTAMP()) WHERE PublishDate IS NULL OR PublishDate LIKE '0000-00-00%'");
echo "fixed_all=$n\n";
PHP
# show snippet of normalize function
sed -n '1060,1075p' /var/www/html/backend/controllers/VideoController.php
