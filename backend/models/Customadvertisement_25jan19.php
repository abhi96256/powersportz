<?php

namespace backend\models;

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
    
    public $Topics;
    public $Playlist;
    public $CustomPlaylist;
    public $CustomTopics;
    public $Custom;
    public $VideosID;
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
            [['Title','Type'], 'required'],
            ['URL', 'required', 'when' => function ($model) {
                return $model->IsExternal == '1';
            }, 'whenClient' => "function (attribute, value) {
             var selected = $('#customadvertisement-isexternal input[type=\"radio\"]:checked').val();

             return selected == '1';
         }"],
         [['URL', 'LandingLink'],'url', 'defaultScheme' => 'http'],
         ['FromDate','checkDate'],
         [['Status','IsHomePage'],'safe'],
         ['ToDate','checkDate'],
     ];
 }

 public function checkDate() {
    if(!empty($_POST['Customadvertisement']['FromDate'])  && !empty($_POST['Customadvertisement']['ToDate'])) {
      $fromDate = strtotime($_POST['Customadvertisement']['FromDate']);
      $toDate =   strtotime($_POST['Customadvertisement']['ToDate']);
      if($fromDate >= $toDate) {
        $this->addError('ToDate','"To Date" must be after "From Date"');
    }
    else if(time() >=  $toDate){
     $this->addError('ToDate','"To Date" must be after Current Time');
 }
} else if(!empty($_POST['Customadvertisement']['FromDate']) && empty($_POST['Customadvertisement']['ToDate'])) {
    $this->addError('ToDate','Please select To date');
} else if(!empty($_POST['Customadvertisement']['ToDate'])&& empty($_POST['Customadvertisement']['FromDate'])) {
    $this->addError('FromDate','Please select From date');
}

}

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CustomAdvertiseID' => 'Custom Advertise ID',
            'Title' => 'Title',
            'URL' => 'Ads URL',
            'LandingLink' => 'Landing Link',
            'FromDate' => 'From Date',
            'ToDate' => 'To Date',
            'IsAll' => 'Select All',
            'Status' => 'Status',
            'Created' => 'Created',
            'CreatedBy' => 'Created By',
            'Updated' => 'Updated',
            'UpdatedBy' => 'Updated By',
            'IsSkip'=>'Allow Skip Ad',
            'IsHomePage'=>'Live Tv'
        ];
    }
    
    public function changeThumbnailTime() {
        return \SecondConvert(5,50);
    }
}
