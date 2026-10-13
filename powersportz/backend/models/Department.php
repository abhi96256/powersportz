<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user_role".
 *
 * @property integer $id
 * @property integer $parent_id 
 * @property string $role_name
 * @property string $child_id
 * @property string $status
 */
class Department extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_role';
    }
      public function rules()
    {
        return [
            [['role_name'], 'required'],
        ];
    }
    
      public function attributeLabels()
    {
        return [
            'role_name' => 'Department Name',
        ];
    }
}