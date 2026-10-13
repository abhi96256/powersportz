<?php

use yii\helpers\Html;

/* @var $record object */
/* @var $type string */
/* @var $schoolName string */

$title = 'CERTIFICATE';
$name = Html::encode($record->name);
$school = Html::encode((string) $schoolName);
$year = Html::encode((string) $record->academic_year);
$completion = Html::encode((string) $record->date_of_completion);
$certificateId = Html::encode((string) $record->certificate_id);
$principalName = '';
if ($type !== 'teacher' && property_exists($record, 'principal')) {
    $principalName = Html::encode((string) $record->principal);
}
if ($principalName === '' && isset($schoolPrincipal)) {
    $principalName = Html::encode((string) $schoolPrincipal);
}
$issued = date('d / m / Y');

if ($type === 'teacher') {
    $programme = Html::encode((string) $record->programme_name);
    $levels = Html::encode((string) $record->levels_covered);
    $cpdHours = Html::encode((string) $record->cpd_hours);
    $programCoordinator = "Dummy Name";
} else {
    $class = Html::encode((string) $record->class);
    $section = Html::encode((string) $record->section);
    $level = Html::encode((string) $record->level_completed);
    $programme = Html::encode((string) $record->programme_name);
}
?>
<?php
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
</head>
<body style="margin:0 auto !important;padding: 0 !important; box-sizing:border-box !important;font-family:'Times New Roman',Times,serif;color:#3b3028;">
    <div style="width:800px;height:1400px; margin: auto; background: url('/images/certificate-bg-n.png');background-repeat: no-repeat; background-position: center center;background-size: contain;">
        <!-- Adjusted the top position to move the content lower on the certificate -->
        <div style="margin-top:308px;padding: 354px 53px 0;text-align:center;width:100%;height: 100%">
            <!-- <img src="/images/certificate-bg.png" alt="Certificate Background" style="position: absolute;width:100%;height:100%;top:0;left:0;z-index: -1;"> -->
            <?php if ($type === 'teacher'): ?>
                <div style="font-family:'Libre Baskerville',serif;font-size:28px;font-weight:700;letter-spacing:1px;margin:-2px 0px 30px;"><?php echo $name; ?></div>

                <div style="font-family:'Libre Baskerville',serif;font-size:15px;font-weight:700;letter-spacing:1px;">(<?php echo $school; ?>)</div>
            
               
                <div style="width:100%;margin:470px auto 8px;font-size:9px;">
                    <table style="width:100%;border-collapse:collapse;font-family:'Libre Baskerville';">
                        <tr>
                            <td style="text-align:left;padding-left:58px;font-size:12px;">
                                <span style="visibility:hidden;">Date of Completion:</span>
                                <?php echo $completion !== '' ? $completion : $issued; ?>
                            </td>

                            <td style="text-align:left;padding-left:-80px;font-size:12px;">
                                <span style="visibility:hidden;">Certificate ID:</span>
                                <?php echo $certificateId; ?>
                            </td>
                        </tr>
                    </table>
                </div>
            <?php else: ?>
                <div style="font-family:'Libre Baskerville',serif;font-size:28px;font-weight:700;letter-spacing:1px;margin:-4px 0px 28px;"><?php echo $name; ?></div>

                <div style="font-family:'Libre Baskerville',serif;font-size:15px;font-weight:700;letter-spacing:1px;">(<?php echo $school; ?>)</div>

                <div style="font-family:'Libre Baskerville';margin:408px 0px 0px 150px;text-align:left;box-sizing:border-box;"><?php echo $completion !== '' ? $completion : $issued; ?></div>
            
                <div style="font-family:'Libre Baskerville';margin:12.5px 0px 0px 150px;text-align:left;"><?php echo $certificateId; ?></div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>
