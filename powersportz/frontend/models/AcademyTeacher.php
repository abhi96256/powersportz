<?php

namespace frontend\models;

use yii\db\ActiveRecord;

class AcademyTeacher extends ActiveRecord
{
    public static function tableName()
    {
        return 'academy_teacher';
    }
}
