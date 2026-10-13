<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "customadplaylist".
 *
 * @property integer $CustomAdTopicsID
 * @property integer $CustomAdvertiseID
 * @property integer $PlaylistID
 * @property integer $IsDelete
 * @property string $Created
 */
class Customadplaylist extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customadplaylist';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CustomAdvertiseID', 'PlaylistID', 'IsDelete'], 'integer'],
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
            'PlaylistID' => 'Playlist ID',
            'IsDelete' => 'Is Delete',
            'Created' => 'Created',
        ];
    }
}
