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
            <div style="font-family:'Libre Baskerville',serif;font-size:28px;font-weight:700;letter-spacing:1px;margin:32px 0px 13px;"><?php echo $name; ?></div>

            <div style="font-family:'Libre Baskerville',serif;font-size:15px;font-weight:700;letter-spacing:1px;">(<?php echo $school; ?>)</div>
        
            <div style="width:100%;margin:357px auto 8px;font-size:9px;">
                <table style="width:100%;border-collapse:collapse;font-family:'Libre Baskerville';">
                    <tr>
                        <td style="text-align:left;padding-left:90px;font-size:12px;">
                            <span style="visibility:hidden;">Date of Completion:</span>
                            <?php echo $completion !== '' ? $completion : $issued; ?>
                        </td>

                        <td style="text-align:left;padding-left:66px;font-size:12px;">
                            <span style="visibility:hidden;">Certificate ID:</span>
                            <?php echo $certificateId; ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
