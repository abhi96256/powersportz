<?php

namespace backend\modules\academy\models;

use yii\db\ActiveRecord;

class Otp extends ActiveRecord
{
    public static function tableName()
    {
        return 'academy_otp';
    }

    public function rules()
    {
        return [
            [['player_id', 'email', 'otp', 'expires_at'], 'required'],
            [['player_id'], 'integer'],
            [['email'], 'string', 'max' => 255],
            [['otp'], 'string', 'max' => 10],
            [['expires_at', 'consumed_at', 'created_at'], 'safe'],
            ['email', 'email'],
        ];
    }
}
