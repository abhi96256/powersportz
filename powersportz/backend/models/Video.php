<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use backend\models\Images;

/**
 * This is the model class for table "video".
 *
 * @property integer $ID
 * @property string $Title
 * @property string $Description
 * @property string $GeneratedThumbnailTime
 * @property string $ChangeThumbnailTime
 * @property string $VideoURL
 * @property string $VideoStreamURL
 * @property string $MetaKeywords
 * @property string $ExternalVideoURL
 * @property string $PreAdvertisementTagURL
 * @property string $MidAdvertisementTagURL
 * @property string $StartMidAdvertisementTime
 * @property string $PostAdvertisementTagURL
 * @property string $PublishDate
 * @property integer $FullVideoId;
 * @property string $FullVideoURL
 * @property string $FullVideoStreamURL
 * @property integer $is_skip_adv 
 * @property integer $DisplayIndex
 * @property integer $LikeCount
 * @property integer $ViewCount
 * @property boolean $IsFBShareEnabled
 * @property boolean $IsTwitterShareEnabled
 * @property string $AllowDownload
 * @property integer $LangID
 * @property string $Status
 * @property integer $CreatedBy
 * @property integer $UpdatedBy
 * @property string $Created
 * @property string $shared_on;
 * @property string $Updated
 */
class Video extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $Playlist;
    public $Topics;
    public $Category;
    public $CountryRestrictions ,$isRelatedVideo,$IsRelatedVideoId,$IsthumbnailVideoId,$IsDefaultthumbnailVideoId;

    public static function tableName()
    {
        return 'video';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['GeneratedThumbnailTime','MetaKeywords','PublishDate','Title','Description', 'AllowDownload', 'Status','PublishDate'], 'required','on'=>'create'],
            [['MetaKeywords','PublishDate','Title','Description', 'AllowDownload', 'Status','PublishDate'], 'required','on'=>'update'],
            ['Topics','TopicsValidate'],
            ['Category','CategoryValidate'],
            ['Playlist','PlaylistValidate'],
            ['StartMidAdvertisementTime', 'required', 'when' => function ($model) {
                    return $model->MidAdvertisementTagURL != '';
                }, 'whenClient' => "function (attribute, value) {
                    return $('#video-midadvertisementtagurl').val() != '';
                }"],
            ['CountryRestrictions','CountryRestrictionsValidate'],
            [['PreAdvertisementTagURL', 'MidAdvertisementTagURL', 'PostAdvertisementTagURL'],'url', 'defaultScheme' => 'http'],
            [['GeneratedThumbnailTime', 'ChangeThumbnailTime', 'VideoURL', 'VideoStreamURL', 'MetaKeywords', 'PreAdvertisementTagURL', 'MidAdvertisementTagURL', 'PostAdvertisementTagURL', 'FullVideoURL', 'FullVideoStreamURL'], 'string', 'max' => 255],
            [['StartMidAdvertisementTime','FullVideoId','shared_on', 'is_skip_adv', 'skip_adv_time','VideoURL','IsRelatedVideoId','IsthumbnailVideoId','IsDefaultthumbnailVideoId'],'safe'],
        ];
    }
    
  

    function CountryRestrictionsValidate() {
        $CountryRestrictions = isset($_POST['Video']['CountryRestrictions']) ? $_POST['Video']['CountryRestrictions'] : array();
        if (!is_array($CountryRestrictions) || count($CountryRestrictions) == 0) {
            return $this->addError('CountryRestrictions', 'Please select country restrictions');
        }
    }
    
    function TopicsValidate() {
        $Topics = isset($_POST['Video']['Topics']) ? $_POST['Video']['Topics'] : array();
        if (!is_array($Topics) || count($Topics) == 0) {
            return $this->addError('Topics', 'Please select topics');
        }
    }
    
    function CategoryValidate() {
        $Category = isset($_POST['Video']['Category']) ? $_POST['Video']['Category'] : array();
        if (!is_array($Category) || count($Category) == 0) {
            return $this->addError('Category', 'Please select category');
        }
    }
    
    function PlaylistValidate() {
        $Playlist = isset($_POST['Video']['Playlist']) ? $_POST['Video']['Playlist'] : array();
        if (!is_array($Playlist) || count($Playlist) == 0) {
            return $this->addError('Playlist', 'Please select playlist');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'Title' => 'Title',
            'Description' => 'Description',
            'GeneratedThumbnailTime' => 'Generated Thumbnail Time',
            'ChangeThumbnailTime' => 'Change Thumbnail Time',
            'VideoURL' => 'Video Upload',
            'VideoStreamURL' => 'Video Stream Url',
            'MetaKeywords' => 'Meta Keywords',
            'PreAdvertisementTagURL' => 'Pre Advertisement Tag URL',
            'MidAdvertisementTagURL' => 'Mid Advertisement Tag URL',
            'PostAdvertisementTagURL' => 'Post Advertisement Tag URL',
            'is_skip_adv' => 'Allow Skip Ad After',
            'skip_adv_time' => 'Skip Time',
            'PublishDate' => 'Publish Date',
            'FullVideoURL' => 'Full Video',
            'FullVideoId'   => 'Full Video',
            'FullVideoStreamURL' => 'Full Video Stream URL',
            'DisplayIndex' => 'Display Index',
            'LikeCount' => 'Like Count',
            'ViewCount' => 'View Count',
            'IsFBShareEnabled' => 'Is Fbshare Enabled',
            'IsTwitterShareEnabled' => 'Is Twitter Share Enabled',
            'AllowDownload' => 'Allow Download',
            'LangID' => 'Language',
            'shared_on'=>'Share it on',
            'Status' => 'Status',
            'CreatedBy' => 'Author',
            'UpdatedBy' => 'Updated By',
            'Created' => 'Created',
            'Updated' => 'Updated',
            'isRelatedVideo'=>'Related Video',
        ];
    }
    
    public function getImages(){
        return $this->hasOne(Images::className(), ['VideoID' => 'ID']);
    }

    public function getUserName(){
        return $this->hasOne(User::className(), ['UserID' => 'CreatedBy'])->select(['AES_DECRYPT(UserName,PASSWORD("'.AESKEY.'")) as UserName']);
    }

    public function getGenerateThumbnailImage(){
        return $this->hasOne(Images::className(), ['VideoID' => 'ID'])->where(['IsThumb'=>1,'ImageType'=>1]);
    }
    /**
    * @return \yii\db\ActiveQuery
    */
    public function getFullVideo()
    {
       return $this->hasOne(Video::className(), ['ID' => 'FullVideoId']);
    }
    public function generatedThumbnailTime() {
       /* for ($i=30; $i < 7200; $i++) { 
            $str = '';
            $str .= (!empty(floor($i / 3600))) ? floor($i / 3600) .' Hours ' : "";
            $str .= (!empty(floor(($i / 60) % 60))) ? floor(($i / 60) % 60) .' Min ' : "";
            $str .= (!empty(floor($i % 60))) ? ($i % 60).' Sec' : "";
            $arr[$i] = $str;
            $i += 29;
        }*/

        return \SecondConvert(120,900);
        //return array("30"=>"30 Sec","60"=>"1 Min","90"=>"1 Min 30 Sec","120"=>"2 Min","150"=>"2 Min 30 sec","180"=>"3 Min","210"=>"3 Min 30 Sec","240"=>"4 Min","270"=>"4 Min 30 Sec","300"=>"5 Min");
    }
    
    public function getGeneratedThumbnailTime($id) {
        /*$time  = array("30"=>"30 Sec","60"=>"1 Min","90"=>"1 Min 30 Sec","120"=>"2 Min","150"=>"2 Min 30 sec","180"=>"3 Min","210"=>"3 Min 30 Sec","240"=>"4 Min","270"=>"4 Min 30 Sec","300"=>"5 Min");*/
        $time = \SecondConvert(30,300);
        return $time[$id];
    }
    
    public function changeThumbnailTime() {
        //return array("1"=>"30 Min","2"=>"1 Hour","3"=>"1 Hour 30 Min","4"=>"2 Hour","5"=>"2 Hour 30 Mins","6"=>"3 Hour","7"=>"3 Hour 30 Mins","8"=>"4 Hour","9"=>"4 Hour 30 Mins","10"=>"5 Hour");
        return \SecondConvert(1800,18000);
    }
     public function changeThumbnailTimeAd() {
        //return array("1"=>"30 Min","2"=>"1 Hour","3"=>"1 Hour 30 Min","4"=>"2 Hour","5"=>"2 Hour 30 Mins","6"=>"3 Hour","7"=>"3 Hour 30 Mins","8"=>"4 Hour","9"=>"4 Hour 30 Mins","10"=>"5 Hour");
        return \SecondConvert(60,3650);
    }
    
    public function getChangeThumbnailTime($id) {
     //   $time = array("1"=>"30 Min","2"=>"1 Hour","3"=>"1 Hour 30 Min","4"=>"2 Hour","5"=>"2 Hour 30 Mins","6"=>"3 Hour","7"=>"3 Hour 30 Mins","8"=>"4 Hour","9"=>"4 Hour 30 Mins","10"=>"5 Hour");
        $time = \SecondConvert(30,18000);
        return $time[$id];
    }
    public function midAdvertisementTime() {
        $count = 1;
        for ($i=5; $i <= 60 ; $i++) { 
            //$time[$count * 10] = $i .' Minutes';
            $time[$i * 60] = $i .' Minutes';
            $count++;
            $i = $i + 4;
        }
        return $time;
    }

    public static function GetSharedVideoIcon(){
        $base = Yii::$app->request->baseUrl;
        return array(
            '0' => $base . '/images/facebook.png',
            '1' => $base . '/images/linked_in.png',
            '2' => $base . '/images/twitter.png',
            '3' => $base . '/images/google_plus.png',
            '4' => $base . '/images/pinterest.png',
            '5' => $base . '/images/embed.png',
            '6' => $base . '/images/whatsapp.png',
        );
    }
    public static function GetVideoCategory($videoId){
        return implode(",",Yii\helpers\ArrayHelper::getColumn(\backend\models\Videocategory::find()->with(['categ'])->where(['VideoID'=>$videoId])->asArray()->all(),function($arr){
                return $arr['categ']['CategName'];
        }));
    }
    public static function GetSupervisorName($cretedUserId){
        $sql =  'CALL VideoApprovalName('.$cretedUserId.',"'.AESKEY.'","","","")';
        $command = Yii::$app->db->createCommand($sql);
        $result = $command->queryOne();
        return (!empty($result)) ? $result['UserName'] : "-";
    }
    public  function createSlug($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
        return 'n-a';
        }
      
        return $text;
    }

    
    public function beforeSave($insert) {
        if (is_array($this->shared_on)) {
            $this->shared_on = implode(',', $this->shared_on);
        }
        if (is_array($this->MetaKeywords)) {
            $this->MetaKeywords = implode(',', $this->MetaKeywords);
        }
        // Never persist MySQL zero-dates — they break Update form / DateTimePicker
        if ($this->PublishDate === null || $this->PublishDate === '' || strpos((string) $this->PublishDate, '0000-00-00') === 0) {
            $this->PublishDate = gmdate('Y-m-d H:i:s');
        }
        if (parent::beforeSave($insert) && !$this->isNewRecord) { 
            $this->Updated =  new \yii\db\Expression('NOW()');
            return true;
        } elseif (parent::beforeSave($insert) && $this->isNewRecord) {
            $this->Updated =  new \yii\db\Expression('NOW()');
            return true;
        }
        return true;
    }
}