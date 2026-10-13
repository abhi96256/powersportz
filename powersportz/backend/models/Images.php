<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "images".
 *
 * @property integer $ImageID
 * @property integer $VideoID
 * @property string $Title
 * @property string $ImageName
 * @property integer $IsThumb
 * @property string $ImageType
 * @property string $Created
 * @property integer $CreatedBy
 */
class Images extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['VideoID', 'IsThumb', 'CreatedBy'], 'integer'],
            [['ImageType'], 'string'],
            [['Created'], 'safe'],
            [['Title', 'ImageName'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ImageID' => 'Image ID',
            'VideoID' => 'Video ID',
            'Title' => 'Title',
            'ImageName' => 'Image Name',
            'IsThumb' => 'Is Thumb',
            'ImageType' => 'Image Type',
            'Created' => 'Created',
            'CreatedBy' => 'Created By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVideo()
    {
        return $this->hasOne(Video::className(), ['ID' => 'VideoID']);
    }
}
