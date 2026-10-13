<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Member;
use yii\data\SpDataProvider;

/**
 * This is the model class for table "member".
 *
 * @property integer $MemberID
 * @property string $FirstName
 * @property string $LastName
 * @property string $DOB
 * @property string $MobileNo
 * @property string $Gender
 * @property integer $Occupation
 * @property integer $Interest
 * @property string $DeviceType
 * @property string $DeviceToken
 * @property string $SignupType
 * @property string $Status
 * @property integer $UserID
 * @property string $ActivationCode
 * @property string $ActivatedOn
 * @property string $Created
 * @property string $Updated
 * @property integer $CreatedBy
 * @property integer $UpdatedBy
 */
class Member extends \yii\db\ActiveRecord
{
    public $Password;
    public $ConfirmPassword;
    public $UserName;
    public $Email,$video_title,$UserType;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'member';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['FirstName','LastName','MobileNo','Designation'], 'required','on'=>'create','whenClient' => "function (attribute, value) {
                    return $('#user-usertype input:radio:checked').val() != '1';
                }",'when'=>function($model){
                      return  $this->UserType != 1; 
                }],
            [['FirstName','LastName','MobileNo','Designation'], 'required','on'=>'update'],
            [['FirstName', 'LastName', 'DOB', 'MobileNo', 'Gender', 'DeviceType', 'DeviceToken', 'SignupType', 'Status', 'ActivationCode', 'ActivatedOn', 'Created', 'Updated'], 'safe'],
         //   ['ConfirmPassword', 'required','on' => 'create'],
         //   ['ConfirmPassword', 'compare', 'compareAttribute'=>'Password', 'message'=>"Passwords doesn't match"],
          //  ['Email','email'],
            ['FirstName','safe'],
            [['parent_role_user_id','Designation','Status','video_title','Status','UserType'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MemberID' => 'Member ID',
            'FirstName' => 'First Name',
            'LastName' => 'Last Name',
            'DOB' => 'Dob',
            'MobileNo' => 'Mobile No',
            'Gender' => 'Gender',
            'Occupation' => 'Occupation',
            'Interest' => 'Interest',
            'DeviceType' => 'Device Type',
            'DeviceToken' => 'Device Token',
            'SignupType' => 'Signup Type',
            'Status' => 'Status',
            'UserID' => 'User ID',
            'parent_user_id'=>'Head user',
            'ActivationCode' => 'Activation Code',
            'ActivatedOn' => 'Activated On',
            'Created' => 'Created',
            'Updated' => 'Updated',
            'CreatedBy' => 'Created By',
            'UpdatedBy' => 'Updated By',
            'parent_role_user_id'=>'Supervisor',
        ];
    }
    
    
     public function uploadvideo()
    {
    
        $arrParams = array();
        $request = Yii::$app->request;
        $id = $request->get('id');
       // $arrParams['v_MemberID'] = "";
	      $arrParams['v_MemberID'] = "$id";
        $arrParams['v_Key'] = AESKEY;
        $arrParams['v_title'] = $this->video_title;
        $arrParams['v_Author'] = $this->FirstName;
        $arrParams['v_Status'] = $this->Status;
        
        
       /* $arrParams['v_Gender'] = $this->Gender;
        $arrParams['v_SignupType'] = $this->SignupType;
       */
         
        $spDataProvider = new SpDataProvider([
			'spName' => 'Admin_Video_UploadedBy_Subscribers',
			//'totalCount'=>5,
			 'params'=>$arrParams,
			 'sort'=> [
				'attributes'=>[
					'ID'=>[
						'asc'=>['ID' => SORT_ASC],
						'desc'=>['ID' =>SORT_DESC],
						//'default'=>SORT_ASC,
						'label'=>'ID'
					],
				],
				/*'defaultOrder'=>[
					'ID' => SORT_ASC
				]*/
			 ],  
			 //'sort' => $sort,
			'pagination' => [
				  'pageSize' => 10,
			 ],
			 
		]);

        return $spDataProvider;
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['UserID' => 'UserID']);
    }
    public function getDesignationDetail(){
          return $this->hasOne(UserRole::className(), ['id' => 'Designation']);
    }
    public function getUserRulesDetail(){
          return $this->hasMany(UserRules::className(), ['role_id' => 'Designation']);
    }
    
    public function getDesignation($ParentRoleId = false) {
        $condition = [];
        if(!empty($ParentRoleId)){
            $condition = ['parent_id'=>$ParentRoleId];
        }
        return Yii\helpers\ArrayHelper::map(UserRole::find()->where($condition)->asArray()->all(),'id','role_name');

        /*$designation =  ['1'=>'Editor','2'=>'Sub Editor','3'=>'Creative Head'];
        if($id != '') {
            return $designation[$id];
        } else {
            return $designation;
        }*/
    }
	
	  public function getSignupType($id) {
            $designation =  ['1'=>'Website','2'=>'FaceBook','3'=>'Google',''=>''];
              return $designation[$id];
      
        }
        
         public function getGender($id) {
            $designation =  [""=>"","1"=>"Male","2"=>"Female","3"=>"Not Specified"];
              return $designation[$id];
      
        }
        
         public function getLikevideo($id) {
            $designation =  ['1'=>'Normal','2'=>'FaceBook','3'=>'Google'];
              return $designation[$id];
      
        }
        
        public function getAge($id) {
            $designation =  ['1'=>'Normal','2'=>'FaceBook','3'=>'Google'];
              return $designation[$id];
      
        }
        
       public function getIntersest($id) {
             //$listData=array('1'=>'Construction Project Manager','2'=>'Project Builder','3'=>'External Auditor');
        $listData=array(''=>'','1'=>'Cricket','2'=>'Football','3'=>'Learning Game','4'=>'Rugby','5'=>'Sportz News','6'=>'Talk shows');
      
	   return (!empty($listData[$id])) ? $listData[$id] :"-";
      
        }
        
        
        public function getOccupation($id) {
            // $listData=array('1'=>'Construction Project Manager','2'=>'Project Builder','3'=>'External Auditor');
       $listData=array(''=>'','1'=>'Student','2'=>'IT Professional','3'=>'Doctors','4'=>'Auditors','5'=>'Sportz Trainers');
       
	   return (!empty($listData[$id])) ? $listData[$id] :"-" ;
      
        }

}
