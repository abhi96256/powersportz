<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "homepage".
 *
 * @property integer $HomeID
 * @property string $MainVideoType
 * @property string $VideoID
 * @property string $ExternalVideoURL
 * @property string $AccompanyingID
 * @property string $NewsOrAdd
 * @property string $AdvertisementID
 * @property string $CategoryID
 */
class Homepage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'homepage';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MainVideoType', 'NewsOrAdd'], 'string'],
            [['VideoID', 'ExternalVideoURL', 'AccompanyingID', 'AdvertisementID', 'CategoryID'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'HomeID' => 'Home ID',
            'MainVideoType' => 'Main Video Type',
            'VideoID' => 'Video ID',
            'ExternalVideoURL' => 'External Video Url',
            'AccompanyingID' => 'Accompanying ID',
            'NewsOrAdd' => 'News Or Add',
            'AdvertisementID' => 'Advertisement ID',
            'CategoryID' => 'Category ID',
        ];
    }
}
