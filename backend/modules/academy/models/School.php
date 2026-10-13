<?php

namespace backend\modules\academy\models;

use yii\db\ActiveRecord;

class School extends ActiveRecord
{
    public $password;

    public static function tableName()
    {
        return 'academy_school';
    }

    public function rules()
    {
        return [
            [['name', 'contact_email', 'phone', 'principal', 'address'], 'required'],
            [['password'], 'required', 'on' => 'create'],
            [['password'], 'safe'],
            [['user_id', 'status'], 'integer'],
            [['name', 'contact_email'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 10],
            [['address'], 'string', 'max' => 1000],
            ['contact_email', 'email'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'contact_email' => 'Email',
        ];
    }

    public static function findByUserId($userId)
    {
        return static::find()->where(['user_id' => $userId])->one();
    }
}
