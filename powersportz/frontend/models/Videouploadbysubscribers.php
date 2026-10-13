<?php

namespace frontend\models;

use Yii;
use yii\web\UploadedFile;


/**
 * This is the model class for table "videouploadbysubscribers".
 *
 * @property integer $ID
 * @property integer $VideoID
 * @property integer $MemberID
 * @property string $ApproveStatus
 * @property integer $CreatedBy
 * @property integer $UpdatedBy
 * @property string $Created
 * @property string $Updated
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
            [['ApproveStatus'], 'string'],
            [['Created', 'Updated'], 'safe']
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
            'ApproveStatus' => 'Approve Status',
            'CreatedBy' => 'Created By',
            'UpdatedBy' => 'Updated By',
            'Created' => 'Created',
            'Updated' => 'Updated',
        ];
    }
    
  public function upload()
    {
        if ($this->validate()) {
            $this->VideoFile->saveAs('uploads/' . $this->VideoFile->baseName . '.' . $this->VideoFile->extension);
            return true;
        } else {
            return false;
        }
    }
}
