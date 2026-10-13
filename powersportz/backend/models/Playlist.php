<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\SluggableBehavior;

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
class Playlist extends \yii\db\ActiveRecord
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
    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'Title',
                'ensureUnique'=>true,
                // 'slugAttribute' => 'slug',
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['NoOfVideos', 'DisplayIndex', 'LangID', 'CreatedBy', 'UpdatedBy'], 'integer'],
            [['ScheduledRelease', 'Created', 'Updated'], 'safe'],
            [['Title','Status','ScheduledRelease'], 'required'],
            [['Status'], 'string'],
            [['Title'], 'string', 'max' => 512],
            [['Description'], 'string', 'max' => 5000],
            [['VideoThumb', 'VideoURL'], 'string', 'max' => 255]
        ];
    }
/*--
 check custom image validation
 * */

    
public function checkImage() {
if(isset($_FILES['Playlist']['name']['VideoThumb']) && count($_FILES['Playlist']['name']['VideoThumb'])>0)
{
 $fileName = $_FILES['Playlist']['name']['VideoThumb'];
 $extension = pathinfo($fileName, PATHINFO_EXTENSION);
  if($extension != 'jpg' && $extension != 'png' && $extension != 'jpeg') 
 {
     return $this->addError('VideoThumb', 'Please upload valid image');
     }   
 }
        else
        {
           return $this->addError('VideoThumb', 'Please upload an image'); 
        }
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'Title' => 'Playlist Title',
            'Description' => 'Description',
            'VideoThumb' => 'Video Thumb',
            'VideoURL' => 'Video Url',
            'NoOfVideos' => 'No Of Videos',
            'DisplayIndex' => 'Display Index',
            'ScheduledRelease' => 'Publish Date and Time',
            'LangID' => 'Language',
            'Status' => 'Status',
            'CreatedBy' => 'Created By',
            'UpdatedBy' => 'Updated By',
            'Created' => 'Created',
            'Updated' => 'Updated',
        ];
    }
      public static function getStatusValue($id) {
        $status = array("1"=>"Active","2"=>"Inactive",""=>"Not Set");
        return $status[$id];
    }
    
    public function getPlayList() {
        $playListData = Playlist::find()->select('ID,Title')->where(array('Status'=>'1'))->orderBy(['Title' => SORT_ASC])->all();
        $listData=ArrayHelper::map($playListData,'ID','Title');
        return $listData;
    }

    
    
    public function beforeSave($insert) {
        if (parent::beforeSave($insert) && !$this->isNewRecord) { 
            $this->Updated =  new \yii\db\Expression('NOW()');
            return true;
        } elseif (parent::beforeSave($insert) && $this->isNewRecord) {
            $this->Updated =  new \yii\db\Expression('NOW()');
            return true;
        }
        return true;
    }
}
