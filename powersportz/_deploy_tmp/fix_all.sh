#!/bin/bash
set -e
sudo cp /home/ubuntu/_form.php /var/www/html/backend/views/video/_form.php
sudo cp /home/ubuntu/VideoController.php /var/www/html/backend/controllers/VideoController.php
sudo cp /home/ubuntu/Video.php /var/www/html/backend/models/Video.php
sudo cp /home/ubuntu/main.php /var/www/html/backend/views/layouts/main.php
sudo cp /home/ubuntu/video.js /var/www/html/backend/web/js/video.js
sudo cp /home/ubuntu/commonfunctions.php /var/www/html/common/config/commonfunctions.php
sudo chown www-data:www-data \
  /var/www/html/backend/views/video/_form.php \
  /var/www/html/backend/controllers/VideoController.php \
  /var/www/html/backend/models/Video.php \
  /var/www/html/backend/views/layouts/main.php \
  /var/www/html/backend/web/js/video.js \
  /var/www/html/common/config/commonfunctions.php

# Fix all zero publish dates
php <<'PHP'
<?php
$c = require '/var/www/html/common/config/main-local.php';
$p = new PDO($c['components']['db']['dsn'], $c['components']['db']['username'], $c['components']['db']['password']);
$n = $p->exec("UPDATE video SET PublishDate = COALESCE(NULLIF(Created,'0000-00-00 00:00:00'), UTC_TIMESTAMP()) WHERE PublishDate IS NULL OR PublishDate='' OR PublishDate LIKE '0000-00-00%'");
echo "fixed_dates=$n\n";
$r = $p->query("SELECT ID, Title, PublishDate, shared_on FROM video WHERE ID=15813")->fetch(PDO::FETCH_ASSOC);
echo "15813=".json_encode($r)."\n";
PHP

# Restart apache to clear opcode cache
sudo service apache2 restart || true
sleep 2
grep -n 'isset($getSharedIcon\|Never persist\|Repair zero PublishDate\|Force PublishDate\|UPDATE video SET PublishDate' /var/www/html/backend/views/video/_form.php /var/www/html/backend/controllers/VideoController.php /var/www/html/backend/models/Video.php | head -20
php -l /var/www/html/backend/views/video/_form.php
php -l /var/www/html/backend/controllers/VideoController.php
echo DONE
