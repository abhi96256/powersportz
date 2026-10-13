<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "customadvideo".
 *
 * @property integer $CustomAdTopicsID
 * @property integer $CustomAdvertiseID
 * @property integer $VideoID
 * @property integer $IsDelete
 * @property string $Created
 */
class Customadvideo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customadvideo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CustomAdvertiseID', 'VideoID', 'IsDelete'], 'integer'],
            [['Created'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CustomAdTopicsID' => 'Custom Ad Topics ID',
            'CustomAdvertiseID' => 'Custom Advertise ID',
            'VideoID' => 'Video ID',
            'IsDelete' => 'Is Delete',
            'Created' => 'Created',
        ];
    }
}
