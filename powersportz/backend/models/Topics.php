<?php

namespace backend\models;

use Yii;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "category".
 *
 * @property integer $ID
 * @property integer $ParentCategID
 * @property string $CategName
 * @property string $CategThumb
 * @property integer $DisplayIndex
 * @property string $Status
 * @property integer $LangID
 * @property integer $CreatedBy
 * @property integer $UpdatedBy
 * @property string $Created
 * @property string $Updated
 * @property integer $Type
 */
class Topics extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }
    
            /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'CategName',
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
            [['ParentCategID', 'DisplayIndex', 'LangID', 'CreatedBy', 'UpdatedBy', 'Type'], 'integer'],
            [['Status'], 'string'],
             [['CategName','Status'], 'required'],
            [['Created', 'Updated'], 'safe'],
            [['CategName'], 'string', 'max' => 512],
            [['CategThumb'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'ParentCategID' => 'Parent Categ ID',
            'CategName' => 'Topic Name',
            'CategThumb' => 'Topic Thumb',
            'DisplayIndex' => 'Display Index',
            'Status' => 'Status',
             'LangID' => 'Language',
            'CreatedBy' => 'Created By',
            'UpdatedBy' => 'Updated By',
            'Created' => 'Created',
            'Updated' => 'Updated',
            'Type' => 'Type',
        ];
    }
}
