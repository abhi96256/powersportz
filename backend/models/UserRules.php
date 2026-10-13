<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user_rules".
 *
 * @property integer $id
 * @property integer $role_id
 * @property string $controller_name
 * @property string $action_name
 * @property string $created_date
 * @property string $updated_date
 */
class UserRules extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_rules';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_id'], 'required'],
            [['role_id'], 'integer'],
            [['action_name'], 'string'],
            [['created_date', 'updated_date'], 'safe'],
            [['controller_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'role_id' => Yii::t('app', 'Role ID'),
            'controller_name' => Yii::t('app', 'Contoller Name'),
            'action_name' => Yii::t('app', 'Action Name'),
            'created_date' => Yii::t('app', 'Created Date'),
            'updated_date' => Yii::t('app', 'Updated Date'),
        ];
    }
}
