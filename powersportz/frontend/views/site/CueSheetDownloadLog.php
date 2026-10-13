<?php

namespace frontend\models;

use yii\db\ActiveRecord;

class CueSheetDownloadLog extends ActiveRecord
{
    public static function tableName()
    {
        return 'academy_cue_sheet_download_log';
    }

    public static function record($cueSheetId, $teacherEmail, $teacherName = '', $sheetName = '')
    {
        $log = new self();
        $log->cue_sheet_id = $cueSheetId;
        $log->teacher_email = $teacherEmail;
        $log->teacher_name = $teacherName;
        $log->sheet_name = $sheetName;
        $log->downloaded_at = date('Y-m-d H:i:s');
        $log->save(false);
    }
}
