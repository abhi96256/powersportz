<?php
/**
 * ONE-TIME FIX: Repair ALL zero PublishDate values.
 * DELETE THIS FILE IMMEDIATELY AFTER USE.
 */
$c = require dirname(__DIR__) . '/../common/config/main-local.php';
$p = new PDO(
    $c['components']['db']['dsn'],
    $c['components']['db']['username'],
    $c['components']['db']['password']
);

$before = $p->query(
    "SELECT COUNT(*) FROM video WHERE PublishDate IS NULL OR PublishDate = '' OR PublishDate LIKE '0000-00-00%'"
)->fetchColumn();

$n = $p->exec(
    "UPDATE video SET PublishDate = COALESCE(NULLIF(Created,'0000-00-00 00:00:00'), NULLIF(Updated,'0000-00-00 00:00:00'), UTC_TIMESTAMP()) WHERE PublishDate IS NULL OR PublishDate = '' OR PublishDate LIKE '0000-00-00%'"
);

echo '<h2>Publish Date Fix (ALL videos)</h2>';
echo '<p>Before: ' . (int) $before . ' videos with zero date</p>';
echo '<p>Fixed: ' . (int) $n . ' rows updated</p>';
echo '<h3>Check video 15813:</h3><pre>';
$row = $p->query('SELECT ID, Title, PublishDate, Created, Updated FROM video WHERE ID = 15813')->fetch(PDO::FETCH_ASSOC);
print_r($row);
echo '</pre>';
echo '<h3>Recent videos:</h3><pre>';
foreach ($p->query('SELECT ID, Title, PublishDate, Created FROM video WHERE ID >= 15810 ORDER BY ID DESC LIMIT 15') as $r) {
    echo $r['ID'] . ' | ' . $r['Title'] . ' | Pub=' . $r['PublishDate'] . ' | Created=' . $r['Created'] . "\n";
}
echo '</pre>';
echo '<p><strong>DELETE fix_dates.php from server NOW!</strong></p>';
