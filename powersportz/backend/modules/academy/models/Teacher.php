<?php

namespace backend\modules\academy\models;

use yii\db\ActiveRecord;

class Teacher extends ActiveRecord
{
    public static function tableName()
    {
        return 'academy_teacher';
    }

    public function rules()
    {
        return [
            [['school_id', 'name', 'email'], 'required'],
            [['school_id', 'status'], 'integer'],
            [['date_of_completion', 'created_at', 'updated_at'], 'safe'],
            [['name', 'email', 'school_name', 'levels_covered', 'cpd_hours', 'programme_name', 'academic_year'], 'string', 'max' => 255],
            [['certificate_id'], 'string', 'max' => 64],
            [['certificate_pdf_path'], 'string', 'max' => 512],
            [['download_token'], 'string', 'max' => 64],
            [['download_token_expires_at'], 'safe'],
            ['email', 'email'],
        ];
    }
}

