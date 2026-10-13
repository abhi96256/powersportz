<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "playlistvideo".
 *
 * @property integer $ID
 * @property integer $PlayListID
 * @property integer $VideoID
 * @property integer $CreatedBy
 * @property string $Created
 * @property integer $deleted
 */
class Playlistvideo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'playlistvideo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['PlayListID','DisplayIndex', 'VideoID', 'CreatedBy'], 'integer'],
            [['Created'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'PlayListID' => 'Play List ID',
            'VideoID' => 'Video ID',
            'DisplayIndex'=>'Display Index',
            'CreatedBy' => 'Created By',
            'Created' => 'Created',
            'deleted' => 'Deleted',
        ];
    }
}
