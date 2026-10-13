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
class Homepagegeographic extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'homepagegeographic';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'CountryID', 'CreatedBy'], 'integer'],
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
            'CountryID' => 'Country ID',
            'Created' => 'Created',
            'CreatedBy' => 'Created By',
        ];
    }
}
