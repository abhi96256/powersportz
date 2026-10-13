<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "gamerule".
 *
 * @property integer $ID
 * @property string $GameName
 * @property string $Title
 * @property string $Description
 * @property string $Thumb
 * @property integer $DisplayIndex
 * @property string $ReleaseDate
 * @property integer $LangID
 * @property string $Status
 * @property integer $CreatedBy
 * @property integer $UpdatedBy
 * @property string $Created
 * @property string $Updated
 */
class Gamerule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gamerule';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Description', 'Status'], 'string'],
            [['DisplayIndex', 'LangID', 'CreatedBy', 'UpdatedBy'], 'integer'],
            [['ReleaseDate', 'Created', 'Updated'], 'safe'],
            [['GameName', 'Thumb'], 'string', 'max' => 255],
            [['Title'], 'string', 'max' => 512]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'GameName' => 'Game Name',
            'Title' => 'Title',
            'Description' => 'Description',
            'Thumb' => 'Thumb',
            'DisplayIndex' => 'Display Index',
            'ReleaseDate' => 'Release Date',
            'LangID' => 'Lang ID',
            'Status' => 'Status',
            'CreatedBy' => 'Created By',
            'UpdatedBy' => 'Updated By',
            'Created' => 'Created',
            'Updated' => 'Updated',
        ];
    }
}
