<?php

namespace backend\models;
use yii\data\SpDataProvider;

use Yii;

/**
 * This is the model class for table "schedule".
 *
 * @property integer $ScheduleID
 * @property integer $VideoID
 * @property string $ProgramTitle
 * @property string $ScheduleDate
 * @property string $ScheduleTime
 * @property string $Status
 */
class Schedule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'schedule';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['VideoID'], 'integer'],
            [['VideoURL'], 'safe'],
            [['ScheduleDate'], 'required','on'=>'update'],
            [['ProgramTitle', 'ScheduleFromTime','ScheduleTime'], 'safe'],
            [['ProgramTitle', 'ScheduleFromTime','ScheduleTime'], 'required', 'on'=>'update'],
            ['ScheduleTime', 'checkDate','skipOnEmpty' => true,'on'=>'update'],
            [['ScheduleFromTime','ScheduleTime'],'required'],
            [['VideoURL'], 'safe', 'on'=>'update'],
            [['ProgramTitle'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ScheduleID' => 'Schedule ID',
            'VideoID' => 'Video ID',
            'ProgramTitle' => 'Program Title',
            'ScheduleDate' => '',
            'ScheduleTime' => 'Schedule Time',
            'Status' => 'Status',
        ];
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

    public function checkDate() {
      if (($this->ScheduleFromTime != '') && ($this->ScheduleTime != '')) {
        $ScheduleFromTime =$this->ScheduleFromTime ;
        $ScheduleTime = $this->ScheduleTime; 
        if (strtotime($ScheduleFromTime) >= strtotime($ScheduleTime)) {
          $this->addError('ScheduleTime', '"To Date & Time" must be after "From Date & Time ".');
        }
      }
    }
}
