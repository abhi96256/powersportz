#!/bin/bash
set -e
# Clear opcache / restart PHP
if command -v systemctl >/dev/null; then
  sudo systemctl restart php7.0-fpm 2>/dev/null || sudo systemctl restart php5.6-fpm 2>/dev/null || sudo systemctl restart php-fpm 2>/dev/null || true
  sudo systemctl reload apache2 2>/dev/null || sudo service apache2 reload 2>/dev/null || true
fi
# Also try reset via php
php -r 'if (function_exists("opcache_reset")) { var_export(opcache_reset()); } else { echo "no_opcache\n"; }'

php <<'PHP'
<?php
$c = require '/var/www/html/common/config/main-local.php';
$p = new PDO($c['components']['db']['dsn'], $c['components']['db']['username'], $c['components']['db']['password']);
$n = $p->exec("UPDATE video SET PublishDate = COALESCE(NULLIF(Created,'0000-00-00 00:00:00'), UTC_TIMESTAMP()) WHERE PublishDate IS NULL OR PublishDate='' OR PublishDate LIKE '0000-00-00%'");
echo "fixed=$n\n";
echo "15845=".json_encode($p->query("SELECT ID,PublishDate,Created FROM video WHERE ID=15845")->fetch(PDO::FETCH_ASSOC))."\n";
PHP
