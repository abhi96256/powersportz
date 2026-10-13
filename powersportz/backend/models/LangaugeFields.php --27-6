<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "langauge_fields".
 *
 * @property integer $id
 * @property string $lang_code
 * @property integer $from_table_id
 * @property string $from_table_name
 * @property string $field_name
 * @property string $value
 */
class LangaugeFields extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'langauge_fields';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from_table_id', 'from_table_name'], 'required'],
            [['from_table_id'], 'integer'],
            [['lang_code'], 'string', 'max' => 20],
            [['from_table_name', 'field_name', 'value'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lang_code' => 'Lang Code',
            'from_table_id' => 'From Table ID',
            'from_table_name' => 'From Table Name',
            'field_name' => 'Field Name',
            'value' => 'Value',
        ];
    }
    /**
    * This function used to update or add language fields into db
    * $requestArr = set array as per language_fields table fields
    * $requestArr[] = ["id"=>'',"from_table_id"=>"","from_table_name"=>"","field_name"=>"","value"=>"","lang_id"=>""]
    */
    public static function SaveLanguageFields($requestArr){
        if(!empty($requestArr)){
           //print_r($requestArr["LanguageFieldsArr"]);die;
            if(!empty($requestArr['LanguageFieldsArr'])){
                foreach ($requestArr['LanguageFieldsArr'] as $key => $value) {
                   if(($model = LangaugeFields::find()->where(["id"=>$value['id']])->one()) === null){
                        $model = new LangaugeFields();
                   }
                   $model->field_name = $value['field_name'];
                   $model->value = $value['value'];
                   $model->lang_id = $requestArr['lang_id'];
                   $model->from_table_name = $requestArr['from_table_name'];
                   $model->from_table_id = $requestArr['from_table_id'];
                   $model->save(false);
                  
                }
            }
        }
        return true;
    }
}
