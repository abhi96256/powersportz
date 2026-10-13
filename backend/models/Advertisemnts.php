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
class Advertisemnts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'advertisemnts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ScrollTime', 'Status', 'CreatedBy', 'UpdatedBy'], 'integer'],
            [['FromDate', 'ToDate', 'Created', 'Updated'], 'safe'],
             [['Content','Status','LandingLink','FromDate', 'ToDate'], 'required'],
             ['ImagePath','checkImage','skipOnEmpty'=> false,'on'=>'create'],
            [['LandingLink'], 'string', 'max' => 250]
        ];
    }
/*--
 check custom image validation
 * */

    
      public function checkImage() {
  if(isset($_FILES['Advertisemnts']['name']['ImagePath']) && count($_FILES['Advertisemnts']['name']['ImagePath'])>0) {
                for($n=0;$n<count(count($_FILES['Advertisemnts']['name']['ImagePath']));$n++) {
                    $fileName = $_FILES['Advertisemnts']['name']['ImagePath'][$n];
                    $extension = pathinfo($fileName, PATHINFO_EXTENSION);
                    if($extension != 'jpg' && $extension != 'png' && $extension != 'jpeg') {
                        return $this->addError('ImagePath', 'Please upload valid image');
                    }
                }    
             
        }    
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'ImagePath' => 'Image',
            'Content' => 'Content',
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
}
