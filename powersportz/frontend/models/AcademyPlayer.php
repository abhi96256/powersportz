<?php

namespace frontend\models;

use yii\db\ActiveRecord;

class AcademyPlayer extends ActiveRecord
{
    public static function tableName()
    {
        return 'academy_player';
    }

    public function rules()
    {
        return [
            [['principal'], 'safe'],
        ];
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['principal']);
    }
}
