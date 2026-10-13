<?php

namespace frontend\models;

use yii\db\ActiveRecord;

class AcademyOtp extends ActiveRecord
{
    public static function tableName()
    {
        return 'academy_otp';
    }
}
