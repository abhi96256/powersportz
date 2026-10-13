<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "customadplaylist".
 *
 * @property integer $CustomAdPlaylistID
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
            'CustomAdPlaylistID' => Yii::t('frontend', 'Custom Ad Playlist ID'),
            'CustomAdvertiseID' => Yii::t('frontend', 'Custom Advertise ID'),
            'PlaylistID' => Yii::t('frontend', 'Playlist ID'),
            'IsDelete' => Yii::t('frontend', 'Is Delete'),
            'Created' => Yii::t('frontend', 'Created'),
        ];
    }
}
