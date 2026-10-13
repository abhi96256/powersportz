<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "related_videos".
 *
 * @property integer $id
 * @property integer $video_id
 * @property integer $related_video
 * @property string $created_date
 *
 * @property Video $relatedVideo
 * @property Video $video
 */
class RelatedVideos extends \yii\db\ActiveRecord
{
    public $concat_related_video;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'related_videos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['video_id', 'related_video'], 'integer'],
            [['created_date'], 'safe']
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
            'related_video' => Yii::t('app', 'Related Video'),
            'created_date' => Yii::t('app', 'Created Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelatedVideo()
    {
        return $this->hasOne(Video::className(), ['ID' => 'related_video']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVideo()
    {
        return $this->hasOne(Video::className(), ['ID' => 'video_id']);
    }
}
