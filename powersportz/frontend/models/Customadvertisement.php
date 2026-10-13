<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "customadvertisement".
 *
 * @property integer $CustomAdvertiseID
 * @property string $Title
 * @property string $URL
 * @property string $LandingLink
 * @property string $FromDate
 * @property string $ToDate
 * @property string $XML
 * @property integer $IsAll
 * @property string $Status
 * @property string $Created
 * @property integer $CreatedBy
 * @property string $Updated
 * @property integer $UpdatedBy
 */
class Customadvertisement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'customadvertisement';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['FromDate', 'ToDate', 'Created', 'Updated'], 'safe'],
            [['IsAll', 'CreatedBy', 'UpdatedBy'], 'integer'],
            [['Status'], 'string'],
            [['Title', 'URL', 'LandingLink', 'XML'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CustomAdvertiseID' => Yii::t('frontend', 'Custom Advertise ID'),
            'Title' => Yii::t('frontend', 'Title'),
            'URL' => Yii::t('frontend', 'Url'),
            'LandingLink' => Yii::t('frontend', 'Landing Link'),
            'FromDate' => Yii::t('frontend', 'From Date'),
            'ToDate' => Yii::t('frontend', 'To Date'),
            'XML' => Yii::t('frontend', 'Xml'),
            'IsAll' => Yii::t('frontend', 'Is All'),
            'Status' => Yii::t('frontend', 'Status'),
            'Created' => Yii::t('frontend', 'Created'),
            'CreatedBy' => Yii::t('frontend', 'Created By'),
            'Updated' => Yii::t('frontend', 'Updated'),
            'UpdatedBy' => Yii::t('frontend', 'Updated By'),
        ];
    }
}
