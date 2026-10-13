<?php

use yii\helpers\Html;

/* @var $record object */
/* @var $type string */
/* @var $schoolName string */
/* @var $schoolPrincipal string */

$name = Html::encode($record->name);
$school = Html::encode((string) $schoolName);
$year = Html::encode((string) $record->academic_year);
$completion = Html::encode((string) $record->date_of_completion);
$certificateId = Html::encode((string) $record->certificate_id);

$issued = date('d / m / Y');

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body style="margin:0 auto !important;padding: 0 !important; box-sizing:border-box !important;font-family:'Times New Roman',Times,serif;color:#3b3028;">
    <div style="width:800px;height:1400px; margin: auto;">
        <div style="margin-top:308px;padding: 308px 80px 0;text-align:center;width:100%;height: 100%">
            <div style="font-family:'Libre Baskerville',serif;font-size:28px;font-weight:700;letter-spacing:1px;margin:-4px 0px 28px;"><?php echo $name; ?></div>

            <div style="font-family:'Libre Baskerville',serif;font-size:15px;font-weight:700;letter-spacing:1px;">(<?php echo $school; ?>)</div>

            <div style="font-family:'Times New Roman',Times,serif;margin:408px 0px 0px 150px;text-align:left;box-sizing:border-box;"><?php echo $completion !== '' ? $completion : $issued; ?></div>
        
            <div style="font-family:'Times New Roman',Times,serif;margin:12.5px 0px 0px 150px;text-align:left;"><?php echo $certificateId; ?></div>
        </div>
    </div>
</body>
</html>
