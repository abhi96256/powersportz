<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "breakingnews".
 *
 * @property integer $ID
 * @property string $Title
 * @property string $ReleaseScheduled
 * @property string $ExpiryDateTime
 * @property integer $LangID
 * @property string $Status
 * @property integer $CreatedBy
 * @property integer $UpdatedBy
 * @property string $Created
 * @property string $Updated
 */
class Breakingnews extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'breakingnews';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'LangID', 'CreatedBy', 'UpdatedBy'], 'integer'],
            [['ReleaseScheduled', 'ExpiryDateTime', 'Created', 'Updated','LandingLink'], 'safe'],
            [['Status'], 'string'],
            [['LandingLink'],'url', 'defaultScheme' => 'http'],
            [['Title'], 'string', 'max' => 512],
            [['Title','Status'], 'required'],
            [['LandingLink'], 'string', 'max' => 300]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'Title' => 'Content',
            'LandingLink' => 'Landing Link',
            'ScrollTime'=>'Scroll Time (In Seconds)',
            'ReleaseScheduled' => 'Release Scheduled',
            'ExpiryDateTime' => 'Expiry Date Time',
            'LangID' => 'Lang ID',
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
