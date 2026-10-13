<?php

namespace frontend\models;

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
            'CustomAdTopicsID' => Yii::t('frontend', 'Custom Ad Topics ID'),
            'CustomAdvertiseID' => Yii::t('frontend', 'Custom Advertise ID'),
            'VideoID' => Yii::t('frontend', 'Video ID'),
            'IsDelete' => Yii::t('frontend', 'Is Delete'),
            'Created' => Yii::t('frontend', 'Created'),
        ];
    }
}
