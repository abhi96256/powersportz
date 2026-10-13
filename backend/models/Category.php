<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use backend\models\Category;
use yii\helpers\ArrayHelper;
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
 */
class Category extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            [
                'class' => SluggableBehavior::className(),
                'attribute' => 'CategName',
                'ensureUnique' => true,
            // 'slugAttribute' => 'slug',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['ParentCategID', 'DisplayIndex', 'LangID', 'CreatedBy', 'UpdatedBy'], 'integer'],
            [['CategName', 'Status'], 'required'],
            [['Status'], 'string'],
            [['Created', 'Updated'], 'safe'],
            [['CategName'], 'string', 'max' => 512],
            [['CategThumb'], 'string', 'max' => 255],
            ['CategName', 'unique', 'targetClass' => '\backend\models\Category', 'message' => 'This Category has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'ID' => 'ID',
            'ParentCategID' => 'ParentCategID',
            'CategName' => 'Category Name',
            'CategThumb' => 'Category Thumb',
            'DisplayIndex' => 'Display Index',
            'Status' => 'Status',
            'LangID' => 'Language',
            'CreatedBy' => 'Created By',
            'UpdatedBy' => 'Updated By',
            'Created' => 'Created',
            'Updated' => 'Updated'
        ];
    }

    public static function getCategoryList($type) {
        $categoryData = Category::find()->select('ID,CategName')->where(array('Status' => '1', 'Type' => $type))->orderBy(['Updated' => SORT_DESC])->all();
        $listData = ArrayHelper::map($categoryData, 'ID', 'CategName');
        return $listData;
    }

}
