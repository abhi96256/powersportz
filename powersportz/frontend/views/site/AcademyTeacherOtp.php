<?php

namespace frontend\models;

use yii\db\ActiveRecord;

class AcademyTeacherOtp extends ActiveRecord
{
    public static function tableName()
    {
        return 'academy_teacher_otp';
    }
}
