<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "playlistgeographic".
 *
 * @property integer $ID
 * @property integer $PlayListID
 * @property integer $CountryID
 * @property integer $CreatedBy
 * @property integer $UpdatedBy
 * @property string $Created
 * @property string $Updated
 */
class Playlistgeographic extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'playlistgeographic';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ID', 'PlayListID', 'CountryID', 'CreatedBy', 'UpdatedBy'], 'integer'],
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
            'PlayListID' => 'Play List ID',
            'CountryID' => 'Country ID',
            'CreatedBy' => 'Created By',
            'UpdatedBy' => 'Updated By',
            'Created' => 'Created',
            'Updated' => 'Updated',
        ];
    }
}
