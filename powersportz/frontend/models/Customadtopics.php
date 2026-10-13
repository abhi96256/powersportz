<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "customadtopics".
 *
 * @property integer $CustomAdTopicsID
 * @property integer $CustomAdvertiseID
 * @property integer $TopicsID
 * @property integer $IsDelete
 * @property string $Created
 */
class Customadtopics extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customadtopics';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CustomAdvertiseID', 'TopicsID', 'IsDelete'], 'integer'],
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
            'TopicsID' => Yii::t('frontend', 'Topics ID'),
            'IsDelete' => Yii::t('frontend', 'Is Delete'),
            'Created' => Yii::t('frontend', 'Created'),
        ];
    }
}
