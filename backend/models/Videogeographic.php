<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "videogeographic".
 *
 * @property integer $VideoGeographicID
 * @property integer $VideoID
 * @property integer $CountryID
 * @property string $Created
 * @property integer $CreatedBy
 */
class Videogeographic extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'videogeographic';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['VideoID', 'CountryID', 'CreatedBy'], 'integer'],
            [['Created'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'VideoGeographicID' => 'Video Geographic ID',
            'VideoID' => 'Video ID',
            'CountryID' => 'Country ID',
            'Created' => 'Created',
            'CreatedBy' => 'Created By',
        ];
    }
}
