<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "video".
 *
 * @property integer $ID
 * @property string $Title
 * @property string $Description
 * @property string $GeneratedThumbnailTime
 * @property string $ChangeThumbnailTime
 * @property string $VideoURL
 * @property string $VideoStreamURL
 * @property string $MetaKeywords
 * @property string $PreAdvertisementTagURL
 * @property string $MidAdvertisementTagURL
 * @property integer $StartMidAdvertisementTime
 * @property string $PostAdvertisementTagURL
 * @property integer $is_skip_adv
 * @property integer $skip_adv_time
 * @property string $PublishDate
 * @property integer $FullVideoId
 * @property string $FullVideoURL
 * @property string $FullVideoStreamURL
 * @property integer $DisplayIndex
 * @property integer $LikeCount
 * @property integer $ViewCount
 * @property boolean $IsFBShareEnabled
 * @property boolean $IsTwitterShareEnabled
 * @property string $AllowDownload
 * @property integer $LangID
 * @property string $Status
 * @property string $shared_on
 * @property integer $CreatedBy
 * @property integer $UpdatedBy
 * @property string $Created
 * @property string $Updated
 *
 * @property RelatedVideos[] $relatedVideos
 * @property RelatedVideos[] $relatedVideos0
 * @property Video $fullVideo
 * @property Video[] $videos
 * @property VideoThumbnailImages[] $videoThumbnailImages
 */
class Video extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'video';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Description', 'AllowDownload', 'Status'], 'string'],
            [['StartMidAdvertisementTime', 'is_skip_adv', 'skip_adv_time', 'FullVideoId', 'DisplayIndex', 'LikeCount', 'ViewCount', 'LangID', 'CreatedBy', 'UpdatedBy'], 'integer'],
            [['PublishDate', 'Created', 'Updated'], 'safe'],
            [['IsFBShareEnabled', 'IsTwitterShareEnabled'], 'boolean'],
            [['Title'], 'string', 'max' => 512],
            [['GeneratedThumbnailTime', 'ChangeThumbnailTime', 'VideoURL', 'VideoStreamURL', 'MetaKeywords', 'PreAdvertisementTagURL', 'MidAdvertisementTagURL', 'PostAdvertisementTagURL', 'FullVideoURL', 'FullVideoStreamURL', 'shared_on'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => Yii::t('frontend', 'ID'),
            'Title' => Yii::t('frontend', 'Title'),
            'Description' => Yii::t('frontend', 'Description'),
            'GeneratedThumbnailTime' => Yii::t('frontend', 'Generated Thumbnail Time'),
            'ChangeThumbnailTime' => Yii::t('frontend', 'Change Thumbnail Time'),
            'VideoURL' => Yii::t('frontend', 'Video Url'),
            'VideoStreamURL' => Yii::t('frontend', 'Video Stream Url'),
            'MetaKeywords' => Yii::t('frontend', 'Meta Keywords'),
            'PreAdvertisementTagURL' => Yii::t('frontend', 'Pre Advertisement Tag Url'),
            'MidAdvertisementTagURL' => Yii::t('frontend', 'Mid Advertisement Tag Url'),
            'StartMidAdvertisementTime' => Yii::t('frontend', 'Start Mid Advertisement Time'),
            'PostAdvertisementTagURL' => Yii::t('frontend', 'Post Advertisement Tag Url'),
            'is_skip_adv' => Yii::t('frontend', 'Is Skip Adv'),
            'skip_adv_time' => Yii::t('frontend', 'Skip Adv Time'),
            'PublishDate' => Yii::t('frontend', 'Publish Date'),
            'FullVideoId' => Yii::t('frontend', 'Full Video ID'),
            'FullVideoURL' => Yii::t('frontend', 'Full Video Url'),
            'FullVideoStreamURL' => Yii::t('frontend', 'Full Video Stream Url'),
            'DisplayIndex' => Yii::t('frontend', 'Display Index'),
            'LikeCount' => Yii::t('frontend', 'Like Count'),
            'ViewCount' => Yii::t('frontend', 'View Count'),
            'IsFBShareEnabled' => Yii::t('frontend', 'Is Fbshare Enabled'),
            'IsTwitterShareEnabled' => Yii::t('frontend', 'Is Twitter Share Enabled'),
            'AllowDownload' => Yii::t('frontend', 'Allow Download'),
            'LangID' => Yii::t('frontend', 'Lang ID'),
            'Status' => Yii::t('frontend', 'Status'),
            'shared_on' => Yii::t('frontend', 'Shared On'),
            'CreatedBy' => Yii::t('frontend', 'Created By'),
            'UpdatedBy' => Yii::t('frontend', 'Updated By'),
            'Created' => Yii::t('frontend', 'Created'),
            'Updated' => Yii::t('frontend', 'Updated'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelatedVideos()
    {
        return $this->hasMany(RelatedVideos::className(), ['video_id' => 'ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelatedVideos0()
    {
        return $this->hasMany(RelatedVideos::className(), ['related_video' => 'ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFullVideo()
    {
        return $this->hasOne(Video::className(), ['ID' => 'FullVideoId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVideos()
    {
        return $this->hasMany(Video::className(), ['FullVideoId' => 'ID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVideoThumbnailImages()
    {
        return $this->hasMany(VideoThumbnailImages::className(), ['video_id' => 'ID']);
    }
}
