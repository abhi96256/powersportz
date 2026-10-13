<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "playlist".
 *
 * @property integer $ID
 * @property string $Title
 * @property string $Description
 * @property string $VideoThumb
 * @property string $VideoURL
 * @property integer $NoOfVideos
 * @property integer $DisplayIndex
 * @property string $ScheduledRelease
 * @property integer $LangID
 * @property string $Status
 * @property integer $CreatedBy
 * @property integer $UpdatedBy
 * @property string $Created
 * @property string $Updated
 */
class Playlists extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'playlist';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NoOfVideos', 'DisplayIndex', 'LangID', 'CreatedBy', 'UpdatedBy'], 'integer'],
            [['ScheduledRelease', 'Created', 'Updated'], 'safe'],
            [['Status'], 'string'],
            [['Title'], 'string', 'max' => 512],
            [['Description'], 'string', 'max' => 5000],
            [['VideoThumb', 'VideoURL'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'Title' => 'Title',
            'Description' => 'Description',
            'VideoThumb' => 'Video Thumb',
            'VideoURL' => 'Video Url',
            'NoOfVideos' => 'No Of Videos',
            'DisplayIndex' => 'Display Index',
            'ScheduledRelease' => 'Scheduled Release',
            'LangID' => 'Lang ID',
            'Status' => 'Status',
            'CreatedBy' => 'Created By',
            'UpdatedBy' => 'Updated By',
            'Created' => 'Created',
            'Updated' => 'Updated',
        ];
    }
}
