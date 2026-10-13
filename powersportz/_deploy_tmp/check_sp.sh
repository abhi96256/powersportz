#!/bin/bash
php <<'PHP'
<?php
$c = require '/var/www/html/common/config/main-local.php';
$p = new PDO($c['components']['db']['dsn'], $c['components']['db']['username'], $c['components']['db']['password']);
$rows = $p->query("SHOW PROCEDURE STATUS WHERE Db = DATABASE() AND Name LIKE '%Video%'")->fetchAll(PDO::FETCH_ASSOC);
foreach ($rows as $r) echo $r['Name']."\n";
// show SP body if AdminVideoPlaylistAddOrUpdate exists
$st = $p->prepare("SHOW CREATE PROCEDURE AdminVideoPlaylistAddOrUpdate");
try {
  $st->execute();
  $row = $st->fetch(PDO::FETCH_ASSOC);
  $body = isset($row['Create Procedure']) ? $row['Create Procedure'] : '';
  if (preg_match_all('/PublishDate|UPDATE\s+`?video`?/i', $body, $m)) {
    echo "SP_mentions: ".implode(',', $m[0])."\n";
  }
  echo "SP_len=".strlen($body)."\n";
  // print lines with UPDATE
  foreach (explode("\n", $body) as $line) {
    if (stripos($line, 'update') !== false || stripos($line, 'PublishDate') !== false) {
      echo "  ".trim($line)."\n";
    }
  }
} catch (Exception $e) {
  echo "no_sp: ".$e->getMessage()."\n";
}
PHP
