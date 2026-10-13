<?php

namespace backend\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "advertisemnts".
 *
 * @property integer $ID
 * @property string $ImagePath
 * @property string $Content
 * @property string $LandingLink
 * @property integer $ScrollTime
 * @property string $FromDate
 * @property string $Todate
 * @property integer $Status
 * @property integer $CreatedBy
 * @property integer $UpdatedBy
 * @property string $Created
 * @property string $Updated
 */
class Advertisements extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'advertisements';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['Status', 'CreatedBy', 'UpdatedBy'], 'integer'],
            [['FromDate', 'ToDate', 'Created','Updated'], 'safe'],
            [['Status'], 'string'],
            [['LandingLink'],'url', 'defaultScheme' => 'http'],
            [['Content', 'Status', 'FromDate', 'ToDate'], 'required'],
            [['LandingLink'], 'string', 'max' => 250],
            ['FromDate','checkDate'],
            ['ToDate','checkDate'],
        ];
    }
    public function checkDate() {
        if((isset($_POST['Advertisements']['FromDate']) && $_POST['Advertisements']['FromDate']!='') && (isset($_POST['Advertisements']['ToDate']) && $_POST['Advertisements']['ToDate']!='')) {
            $fromDate = $_POST['Advertisements']['FromDate'];
            $toDate = $_POST['Advertisements']['ToDate'];
            if(strtotime($fromDate)>=strtotime($toDate)) {
                $this->addError('ToDate','Todate should have to be greater than from date');
            }
        } else if((isset($_POST['Advertisements']['FromDate']) && $_POST['Advertisements']['FromDate']!='') && ($_POST['Advertisements']['ToDate'] == '')) {
            $this->addError('ToDate','Please select to date');
        } else if((isset($_POST['Advertisements']['ToDate']) && $_POST['Advertisements']['ToDate']!='') && ($_POST['Advertisements']['FromDate'] == '' )) {
            $this->addError('FromDate','Please select from date');
        }
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'ID' => 'ID',
            'ImagePath' => 'Image',
            'Content' => 'Title',
            'LandingLink' => 'Landing Link',
            'ScrollTime' => 'Scroll Time',
            'FromDate' => 'From Date',
            'ToDate' => 'To Date',
            'Status' => 'Status',
            'CreatedBy' => 'Created By',
            'UpdatedBy' => 'Updated By',
            'Created' => 'Created',
            'Updated' => 'Updated',
        ];
    }

    public static function getStatusValue($id) {
        $status = array("1" => "Active", "2" => "Inactive", "" => "Not Set");
        return $status[$id];
    }

}
