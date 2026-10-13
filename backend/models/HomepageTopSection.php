<?php

namespace backend\models;

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
 * @property integer $scroll_time 
 */
class HomepageTopSection extends \yii\db\ActiveRecord
{

    public $TagMessage;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'homepage_top_section';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['MainVideoType'], 'required'],
            [['VideoID',  'ExternalVideoURL', 'ExternalRedirectLink'], 'string', 'max' => 255],
            // ['CategoryID', 'categoryLength'],
            // ['AccompanyingID', 'required'],
            [['MainVideoType'], 'mainVideoValidator'],
            // [['ScheduleVideoID'], 'scheduleVideoValidator'],
            [['ExternalRedirectLink'], 'url'],
            [['MainVideoType', 'ExternalVideoURL', 'ExternalVideoThumb', 'ExternalRedirectLink', 'ImageID', 'status'], 'safe'],
            //    ['ExternalVideoThumbFireTv', 'safe'],
        ];
    }

    function mainVideoValidator($attribute, $params)
    {
        if ($this->MainVideoType == 3) {
            if (empty($this->ImageID)) {
                $this->addError('ImageID', 'Please select Banner Image');
            }
            if (empty($this->ExternalRedirectLink)) {
                $this->addError('ExternalRedirectLink', 'Redirection Link cannot be blank');
            }
        }

        if ($this->MainVideoType == 2) {
            if (empty($this->ImageID)) {
                $this->addError('ImageID', 'Please select Thumb Image');
            }
            if (empty($this->ExternalVideoURL)) {
                $this->addError('ExternalVideoURL', 'External Video URL cannot be blank');
            }
        }

        if ($this->MainVideoType == 1) {
            if (empty($this->VideoID)) {
                $this->addError('VideoID', 'Please select Recorded Video');
            }
        }
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'HomeID' => 'Home ID',
            'MainVideoType' => 'Main Video',
            'VideoID' => 'Video ID',
            'ExternalVideoURL' => 'External Video URL',
        ];
    }
}
