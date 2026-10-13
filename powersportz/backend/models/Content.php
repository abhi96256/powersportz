<?php

namespace backend\models;

use Yii;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "gamerule".
 *
 * @property integer $ID 
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
class Content extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'content';
    }
        /**
     * @inheritdoc
     */
        public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'Title',
                'ensureUnique'=>true,
                // 'slugAttribute' => 'slug',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Description', 'Status'], 'string'],
            [['Title','Description','Status'], 'required','on' => 'create'],
            [['Title','Description','Status'], 'required','on' => 'update'],
            [['DisplayIndex', 'LangID', 'CreatedBy', 'UpdatedBy'], 'integer'],
            [['ReleaseDate', 'Created', 'Updated'], 'safe'],
            [['Thumb'], 'string', 'max' => 255],
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
