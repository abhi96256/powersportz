<?php

namespace frontend\models;

use yii\db\ActiveRecord;

class TeacherCueSheet extends ActiveRecord
{
    public static function tableName()
    {
        return 'academy_teacher_cue_sheet';
    }

    public static function getUploadPath()
    {
        return '/var/www/html/upload/teacher-cue-sheet/';
    }
}