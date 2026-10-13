<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "videouploadbysubscribers".
 *
 * @property integer $ID
 * @property integer $VideoID
 * @property integer $MemberID
 * @property string $VideoTitle
 * @property string $ApproveStatus
 * @property string $VideoFile
 * @property integer $CreatedBy
 * @property integer $UpdatedBy
 * @property string $Created
 * @property string $Updated
 *
 * @property Member $member
 * @property Video $video
 */
class Videouploadbysubscribers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'videouploadbysubscribers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['VideoID', 'MemberID', 'CreatedBy', 'UpdatedBy'], 'integer'],
            [['ApproveStatus', 'VideoFile'], 'string'],
            [['Created', 'Updated'], 'safe'],
            [['VideoTitle'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'VideoID' => 'Video ID',
            'MemberID' => 'Member ID',
            'VideoTitle' => 'Video Title',
            'ApproveStatus' => 'Approve Status',
            'VideoFile' => 'Video File',
            'CreatedBy' => 'Created By',
            'UpdatedBy' => 'Updated By',
            'Created' => 'Created',
            'Updated' => 'Updated',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMember()
    {
        return $this->hasOne(Member::className(), ['MemberID' => 'MemberID']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['UserID' => 'CreatedBy']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVideo()
    {
        return $this->hasOne(Video::className(), ['ID' => 'VideoID']);
    }
}
