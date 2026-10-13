<?php

namespace frontend\models;

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
 * @property integer $CreatedBy
 * @property integer $UpdatedBy
 * @property string $Created
 * @property string $Updated
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
            [['VideoID', 'CreatedBy', 'UpdatedBy'], 'integer'],
            [['ScheduleDate', 'ScheduleTime', 'Created', 'Updated'], 'safe'],
            [['Status'], 'string'],
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
            'ScheduleDate' => 'Schedule Date',
            'ScheduleTime' => 'Schedule Time',
            'Status' => 'Status',
            'CreatedBy' => 'Created By',
            'UpdatedBy' => 'Updated By',
            'Created' => 'Created',
            'Updated' => 'Updated',
        ];
    }
}
