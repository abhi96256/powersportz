<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "forgotpassword".
 *
 * @property integer $ID
 * @property integer $RefID
 * @property string $RefTableID
 * @property string $UniqueCode
 * @property integer $Status
 * @property string $Created
 */
class Forgotpassword extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'forgotpassword';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['RefID', 'UniqueCode', 'Status'], 'required'],
            [['RefID', 'Status'], 'integer'],
            [['RefTableID'], 'string'],
            [['Created'], 'safe'],
            [['UniqueCode'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'RefID' => 'Ref ID',
            'RefTableID' => 'Ref Table ID',
            'UniqueCode' => 'Unique Code',
            'Status' => 'Status',
            'Created' => 'Created',
        ];
    }
}
