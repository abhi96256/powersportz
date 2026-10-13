<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "homepage".
 *
 * @property integer $HomeID
 * @property string $MainVideoType
 * @property string $VideoID
 * @property string $ExternalVideoURL
 * @property string $AccompanyingID
 * @property string $NewsOrAdd
 * @property string $AdvertisementID
 * @property string $CategoryID
 * @property integer $scroll_time 
 */
class Homepage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'homepage';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['MainVideoType', 'NewsOrAdd'], 'string'],
            [['VideoID', 'ExternalVideoURL', 'AccompanyingID', 'AdvertisementID'], 'string', 'max' => 255],
            ['CategoryID','categoryLength'],
            ['AccompanyingID','required'],
            [['MainVideoType'],'mainVideoValidator'],
            [['scroll_time'], 'safe'],
           // [['VideoID', 'ExternalVideoURL', 'AccompanyingID', 'AdvertisementID', 'CategoryID'], 'string', 'max' => 255]
            /*['VideoID','required', 'when' => function($model) {
                return $model->MainVideoType== 1;
            },'message'=>'Please select recorded video'],
            ['ExternalVideoURL','required', 'when' => function($model) {
                return $model->MainVideoType== 2;
            },'message'=>'Please enter external video URL.'],*/
        ];
    }

    function categoryLength(){
        if(!empty($_POST['Homepage']['CategoryID'])){
            if(count($_POST['Homepage']['CategoryID']) > 4){
                $this->addError('CategoryID','You have choose maximum 4 category.');
             }
        }
        
    }

    function mainVideoValidator(){
        if($_POST['Homepage']['MainVideoType'] == 1){
            if(empty($_POST['Homepage']['VideoID'])){
                $this->addError('VideoID','Please select recorded video.');
            }
         }
         if($_POST['Homepage']['MainVideoType']== 2){
            if(empty($_POST['Homepage']['ExternalVideoURL'])){
                    $this->addError('VideoID','Please enter external video URL.'); 
            }
         }
        
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'HomeID' => 'Home ID',
            'MainVideoType' => 'Main Video',
            'VideoID' => 'Video ID',
            'ExternalVideoURL' => 'External Video Url',
            'AccompanyingID' => 'Accompanying Videos',
            'NewsOrAdd' => 'Breaking News/Advs',
            'AdvertisementID' => 'Advertisements',
            'CategoryID' => 'Category Videos',
            'scroll_time' => 'Scroll Time',
        ];
    }


    public static function SetRoleBasedHeaderMenu(){
        if (Yii::$app->user->isGuest) {
              $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
        } else {
           // print_r();die;
            $controller_name = [];
            if(Yii::$app->user->identity->UserType == 2){
                $loginMemberDetail = \backend\models\Member::find()->with(['userRulesDetail'=>function($q){
                    return $q->select(["controller_name","role_id"]);
                }])->where(['UserID'=>Yii::$app->user->id])->asArray()->one();
                if(!empty($loginMemberDetail['userRulesDetail'])){
                    $controller_name = yii\helpers\BaseArrayHelper::getColumn($loginMemberDetail['userRulesDetail'], function ($element) {
                                return strtolower(str_replace(" ","-",ltrim(preg_replace('/(?<!\ )[A-Z]/', ' $0', str_replace("Controller", "",$element['controller_name'])))));
                            });
                }else{
                    return [];
                }
            }
            $menuItems = [
                ['label' => 'Home Config',
                 'url' => ['/homepage/update'],
                 'visible'=> (Yii::$app->user->identity->UserType == 2 && in_array('homepage',$controller_name)) || Yii::$app->user->identity->UserType == 1,
                ],
            ];
            
             
             if((!empty(array_intersect(array("video"/*,"schedule","playlist"*/,"category",/*"topics",*/"images"),$controller_name)) && Yii::$app->user->identity->UserType == 2) || Yii::$app->user->identity->UserType == 1){
                     $menuItems[] = [
                        'label' => 'Videos',
                        'items' =>  [
                                        ['label' => 'Videos', 'url' => ['/video/index'],'active'=>Yii::$app->controller->id == 'video' && Yii::$app->controller->action->id == 'index','visible'=> (Yii::$app->user->identity->UserType == 2 && in_array('video',$controller_name)) || Yii::$app->user->identity->UserType == 1],
                                        [
                                            'label' => 'Video Thumbnails',
                                            'url' => ['/images/index'],
                                            'active'=>Yii::$app->controller->id == 'image',
                                            'visible'=> (Yii::$app->user->identity->UserType == 2 && in_array('images',$controller_name)) || Yii::$app->user->identity->UserType == 1,
                                        ],
                                        ['label' => 'Categories', 'url' =>['/category/index'],'active'=>Yii::$app->controller->id == 'category','visible'=> (Yii::$app->user->identity->UserType == 2 && in_array('category',$controller_name)) || Yii::$app->user->identity->UserType == 1],
                                        ['label' => 'Subscriber Videos', 'url' => ['/video/subscriber-uploded-video-index'],'active'=>Yii::$app->controller->id == 'video' && Yii::$app->controller->action->id == 'subscriber-uploded-video-index','visible'=> (Yii::$app->user->identity->UserType == 2 && in_array('video',$controller_name)) || Yii::$app->user->identity->UserType == 1],
                                       // ['label' => 'Schedule', 'url' =>['/schedule/index'],'active'=>Yii::$app->controller->id == 'schedule','visible'=> (Yii::$app->user->identity->UserType == 2 && in_array('schedule',$controller_name)) || Yii::$app->user->identity->UserType == 1],
                                       // ['label' => 'Playlist', 'url' =>['/playlist/index'],'active'=>Yii::$app->controller->id == 'playlist','visible'=> (Yii::$app->user->identity->UserType == 2 && in_array('playlist',$controller_name)) || Yii::$app->user->identity->UserType == 1],
                                       // ['label' => 'Topics', 'url' =>['/topics/index'],'active'=>Yii::$app->controller->id == 'topics','visible'=> (Yii::$app->user->identity->UserType == 2 && in_array('topics',$controller_name)) || Yii::$app->user->identity->UserType == 1],
                                    ],
                    ];
            }
            $menuItems[] = ['label' => 'Topics', 'url' =>['/topics/index'],'active'=>Yii::$app->controller->id == 'topics','visible'=> (Yii::$app->user->identity->UserType == 2 && in_array('topics',$controller_name)) || Yii::$app->user->identity->UserType == 1];
            $menuItems[] = ['label' => 'Playlists', 'url' =>['/playlist/index'],'active'=>Yii::$app->controller->id == 'playlist','visible'=> (Yii::$app->user->identity->UserType == 2 && in_array('playlist',$controller_name)) || Yii::$app->user->identity->UserType == 1];
            $menuItems[] =  ['label' => 'Schedule', 'url' =>['/schedule/index'],'active'=>Yii::$app->controller->id == 'schedule','visible'=> (Yii::$app->user->identity->UserType == 2 && in_array('schedule',$controller_name)) || Yii::$app->user->identity->UserType == 1];

            if((!empty(array_intersect(array("breakingnews","advertisements","gamerule","customadvertisement"),$controller_name)) && Yii::$app->user->identity->UserType == 2) || Yii::$app->user->identity->UserType == 1){
                    $menuItems[] = [
                        'label' => 'Content',
                        'items' => [
                                ['label' => 'Breaking News', 'url' => ['/breakingnews/index'],'active'=>Yii::$app->controller->id == 'breakingnews','visible'=> (Yii::$app->user->identity->UserType == 2 && in_array('breakingnews',$controller_name)) || Yii::$app->user->identity->UserType == 1],
                                ['label' => 'Image Advs', 'url' =>['/advertisements/index'],'active'=>Yii::$app->controller->id == 'advertisements','visible'=> (Yii::$app->user->identity->UserType == 2 && in_array('advertisements',$controller_name)) || Yii::$app->user->identity->UserType == 1],
                                ['label' => 'Video Advs', 'url' =>['/customadvertisement/index'],'active'=>Yii::$app->controller->id == 'customadvertisement','visible'=> (Yii::$app->user->identity->UserType == 2 && in_array('customadvertisement',$controller_name)) || Yii::$app->user->identity->UserType == 1],
                                ['label' => 'Rules Of The Game', 'url' =>['/gamerule/index'],'active'=>Yii::$app->controller->id == 'gamerule','visible'=> (Yii::$app->user->identity->UserType == 2 && in_array('gamerule',$controller_name)) || Yii::$app->user->identity->UserType == 1],
                                ],
                    ];
            }

            if((!empty(array_intersect(array("staff","user","user-role","member"),$controller_name)) && Yii::$app->user->identity->UserType == 2) || Yii::$app->user->identity->UserType == 1){
                    $menuItems[] = [
                        'label' => 'Users',
                        'items' => [
                                        [
                                            'label' => 'Staff Users',
                                            'url' => ['/staff/index'],
                                            'active'=>Yii::$app->controller->id == 'staff',
                                            'visible'=> (Yii::$app->user->identity->UserType == 2 && in_array('staff',$controller_name)) || Yii::$app->user->identity->UserType == 1,
                                        ],
                                        [
                                            'label' => 'Admin Users',
                                            'url' => ['/user/index'],
                                            'active'=>Yii::$app->controller->id == 'user',
                                            'visible'=> (Yii::$app->user->identity->UserType == 2 && in_array('user',$controller_name)) || Yii::$app->user->identity->UserType == 1,
                                        ],
                                        [
                                            'label' => 'Staff Role',
                                            'url' => ['/user-role/index'],
                                            'visible'=> (Yii::$app->user->identity->UserType == 2 && in_array('user-role',$controller_name)) || Yii::$app->user->identity->UserType == 1,
                                        ],
                                        [
                                            'label' => 'Subscribers',
                                            'url' => ['/member/index'],
                                            'active'=>Yii::$app->controller->id == 'member',
                                            'visible'=> (Yii::$app->user->identity->UserType == 2 && in_array('member',$controller_name)) || Yii::$app->user->identity->UserType == 1,
                                        ],
                                ],
                    ];
            }
           
            $menuItems[] = [
                'label' => 'Logout (' . Yii::$app->user->identity->UserName . ')',
                'url' => ['/site/logout'],
                'linkOptions' => ['data-method' => 'post']
            ];       
        }
        return $menuItems;
    }
}
