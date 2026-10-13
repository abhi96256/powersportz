<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "subscribervideosetting".
 *
 * @property integer $SID
 * @property string $FromDate
 * @property string $ToDate
 * @property string $Type
 * @property integer $CreatedBy
 * @property integer $UpdatedBy
 * @property string $Created
 * @property string $Updated
 */
class Subscribervideosetting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'subscribervideosetting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['FromDate', 'ToDate', 'Created', 'Updated'], 'safe'],
            [['Type'], 'string'],
            [['CreatedBy', 'UpdatedBy'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'SID' => 'Sid',
            'FromDate' => 'From Date',
            'ToDate' => 'To Date',
            'Type' => 'Type',
            'CreatedBy' => 'Created By',
            'UpdatedBy' => 'Updated By',
            'Created' => 'Created',
            'Updated' => 'Updated',
        ];
    }
}
