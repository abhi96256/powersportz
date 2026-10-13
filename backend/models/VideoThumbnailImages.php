<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "video_thumbnail_images".
 *
 * @property integer $id
 * @property integer $video_id
 * @property integer $images_id
 * @property integer $type
 * @property string $created_date
 *
 * @property Video $video
 */
class VideoThumbnailImages extends \yii\db\ActiveRecord
{
    public $concat_images_id;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'video_thumbnail_images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['video_id', 'images_id'], 'integer'],
            [['created_date','type'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'video_id' => Yii::t('app', 'Video ID'),
            'images_id' => Yii::t('app', 'Images ID'),
            'created_date' => Yii::t('app', 'Created Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVideo()
    {
        return $this->hasOne(Video::className(), ['ID' => 'video_id']);
    }
}
