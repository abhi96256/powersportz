<?php

namespace backend\models;

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
            'CustomAdTopicsID' => 'Custom Ad Topics ID',
            'CustomAdvertiseID' => 'Custom Advertise ID',
            'TopicsID' => 'Topics ID',
            'IsDelete' => 'Is Delete',
            'Created' => 'Created',
        ];
    }
}
