<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "categorygeographic".
 *
 * @property integer $ID
 * @property integer $CategID
 * @property integer $CountryID
 * @property integer $CreatedBy
 * @property integer $UpdatedBy
 * @property string $Created
 * @property string $Updated
 */
class Categorygeographic extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'categorygeographic';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CategID', 'CountryID', 'CreatedBy', 'UpdatedBy'], 'integer'],
            [['Created', 'Updated'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'CategID' => 'Categ ID',
            'CountryID' => 'Country ID',
            'CreatedBy' => 'Created By',
            'UpdatedBy' => 'Updated By',
            'Created' => 'Created',
            'Updated' => 'Updated',
        ];
    }
}
