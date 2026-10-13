#!/bin/bash
php <<'PHP'
<?php
$c = require '/var/www/html/common/config/main-local.php';
$p = new PDO($c['components']['db']['dsn'], $c['components']['db']['username'], $c['components']['db']['password']);
$col = $p->query("SHOW COLUMNS FROM video LIKE 'PublishDate'")->fetch(PDO::FETCH_ASSOC);
echo "col=" . json_encode($col) . "\n";
// Simulate normalize + ConvertDateToUTC like create
function ConvertDateToUTC($date, $format = 'Y-m-d H:i:s') {
    $dt = new DateTime($date, new DateTimeZone('Asia/Kolkata'));
    $dt->setTimeZone(new DateTimeZone('UTC'));
    return $dt->format($format);
}
$samples = array('', '2026-8-10 1:09 AM', '2026-08-10 01:09 AM', '0000-00-00 00:00:00', 'Select Publish Date ...');
foreach ($samples as $raw) {
  $raw2 = trim((string)$raw);
  $ts = $raw2 !== '' ? strtotime($raw2) : false;
  if ($ts === false || $ts <= 0) {
    $out = gmdate('Y-m-d H:i:s');
    $via = 'gmdate';
  } else {
    try {
      $out = ConvertDateToUTC(date('Y-m-d H:i:s', $ts));
      $via = 'convert';
    } catch (Exception $e) {
      $out = gmdate('Y-m-d H:i:s');
      $via = 'catch';
    }
  }
  echo "raw=[$raw] ts=[$ts] via=$via out=$out\n";
}
// Fix 15844 and all zeros now
$n = $p->exec("UPDATE video SET PublishDate = COALESCE(NULLIF(Created,'0000-00-00 00:00:00'), UTC_TIMESTAMP()) WHERE PublishDate IS NULL OR PublishDate LIKE '0000-00-00%'");
echo "fixed=$n\n";
echo "15844=" . json_encode($p->query("SELECT ID,PublishDate,Created FROM video WHERE ID=15844")->fetch(PDO::FETCH_ASSOC)) . "\n";
PHP
