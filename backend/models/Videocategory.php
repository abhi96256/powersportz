<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "videocategory".
 *
 * @property integer $ID
 * @property integer $VideoID
 * @property integer $CategID
 * @property integer $CreatedBy
 * @property string $Created
 */
class Videocategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'videocategory';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['VideoID', 'CategID', 'CreatedBy'], 'integer'],
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
            'VideoID' => 'Video ID',
            'CategID' => 'Categ ID',
            'CreatedBy' => 'Created By',
            'Created' => 'Created',
        ];
    }
    
   /** 
    * @return \yii\db\ActiveQuery 
    */ 
   public function getCateg() 
   { 
       return $this->hasOne(Category::className(), ['ID' => 'CategID']); 
   } 
}
