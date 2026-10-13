<?php

namespace frontend\models;

use Yii;
use yii\helpers\ArrayHelper;
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
 * @property string $Type
 */
class Sports extends \yii\db\ActiveRecord
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
    public function rules()
    {
        return [
            [['ParentCategID', 'DisplayIndex', 'LangID', 'CreatedBy', 'UpdatedBy'], 'integer'],
            [['Status', 'Type'], 'string'],
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
            'CategName' => 'Categ Name',
            'CategThumb' => 'Categ Thumb',
            'DisplayIndex' => 'Display Index',
            'Status' => 'Status',
            'LangID' => 'Lang ID',
            'CreatedBy' => 'Created By',
            'UpdatedBy' => 'Updated By',
            'Created' => 'Created',
            'Updated' => 'Updated',
            'Type' => 'Type',
        ];
    }
      /**
     * @inheritdoc
     */
    public function getSportsList($countryid) {
        $ONE=1;
        $TWO=2;
        $categoryData = Sports::find()->select('category.ID,category.CategName')
        ->where('category.Status=:ONE', [':ONE' => $ONE])
        ->andWhere('category.Type = :TWO', [':TWO' => $TWO])
        ->andWhere('category.ID NOT IN (SELECT cg.CategID FROM categorygeographic AS cg WHERE cg.CountryID =:CountryID)', [':CountryID' => $countryid])
        ->andWhere('category.ID IN (SELECT CategID FROM videocategory)')
		->all();
        $listData=ArrayHelper::map($categoryData,'ID','CategName');
        return $listData;
    }
    
    /**
     * @inheritdoc
     */
    public function getSportsListWithSlug($countryid) {
        $ONE=1;
        $TWO=2;
        $categoryData = Sports::find()->select('category.ID,category.CategName,category.slug')
        ->where('category.Status=:ONE', [':ONE' => $ONE])
        ->andWhere('category.Type = :TWO', [':TWO' => $TWO])
        ->andWhere('category.ID NOT IN (SELECT cg.CategID FROM categorygeographic AS cg WHERE cg.CountryID =:CountryID)', [':CountryID' => $countryid])
        ->andWhere('category.ID IN (SELECT CategID FROM videocategory)')
        ->indexBy('ID')->all();
        //$listData=ArrayHelper::map($categoryData,'ID','CategName');
        return  $categoryData ;
    }
      /**
     * @inheritdoc
     */
    public function getTalkingPointsList($countryid) {
        $ONE=1;
        $TWO=3;
        $categoryData = Sports::find()->select('category.ID,category.CategName')
        ->where('category.Status=:ONE', [':ONE' => $ONE])
        ->andWhere('category.Type = :TWO', [':TWO' => $TWO])
        ->andWhere('category.ID NOT IN (SELECT cg.CategID FROM categorygeographic AS cg WHERE cg.CountryID =:CountryID)', [':CountryID' => $countryid])
        ->andWhere('category.ID IN (SELECT CategID FROM videocategory)')
        ->all();
        $listData=ArrayHelper::map($categoryData,'ID','CategName');
        return $listData;
    }
    /**
     * @inheritdoc
     */
    public function getTalkingPointsListWithSlug($countryid) {
        $ONE=1;
        $TWO=3;
        $categoryData = Sports::find()->select('category.ID,category.CategName,category.slug')
        ->where('category.Status=:ONE', [':ONE' => $ONE])
        ->andWhere('category.Type = :TWO', [':TWO' => $TWO])
        ->andWhere('category.ID NOT IN (SELECT cg.CategID FROM categorygeographic AS cg WHERE cg.CountryID =:CountryID)', [':CountryID' => $countryid])
        ->andWhere('category.ID IN (SELECT CategID FROM videocategory)')
         ->indexBy('ID')->all();
        //$listData=ArrayHelper::map($categoryData,'ID','CategName');
        return  $categoryData ;
    }
    
}
