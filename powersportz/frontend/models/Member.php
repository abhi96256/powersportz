<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "member".
 *
 * @property integer $MemberID
 * @property string $FirstName
 * @property string $LastName
 * @property string $DOB
 * @property string $Email
 * @property string $MobileNo
 * @property string $Designation
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
    public $TermCondition;
    public $ConfirmPassword;
    public $UserName;
    public $oldPassword;
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
            [['FirstName', 'LastName','Email','Password','UserName','ConfirmPassword'], 'required','on'=>'register'],
            [['Email','Password'], 'required','on'=>'login'],
            [['Email'], 'required','on'=>'forgotpassword'],
            [['Password','ConfirmPassword'], 'required','on'=>'resetpassword'],
            [['Password','ConfirmPassword','oldPassword'], 'required','on'=>'changepassword'],
            [['Email'], 'email'],
            [['DOB', 'ActivatedOn', 'Created','Status', 'Updated'], 'safe'],
            [['Gender', 'DeviceType', 'SignupType', 'Status'], 'string'],
            [['Occupation', 'Interest', 'UserID', 'CreatedBy', 'UpdatedBy'], 'integer'],
            [['FirstName', 'LastName'], 'string', 'max' => 100],
            [['Email', 'MobileNo', 'ActivationCode'], 'string', 'max' => 255],
            ['ConfirmPassword', 'compare', 'compareAttribute'=>'Password',"whenClient"=>"function(attribute, value){
                return $('#member-password').val() != value ;
            }", 'message'=>"\"Password\"  doesn't match with \"Confirm Password\""],
            ['TermCondition', 'required', 'requiredValue' => 1, 'message' => 'You should accept term to use our service','on'=>'register'],
            [['DeviceToken'], 'string', 'max' => 1000],
            [['Password','ConfirmPassword','oldPassword'], 'string','max'=>20],
            [['Password','ConfirmPassword','oldPassword'], 'string','min'=>8]
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
            'DOB' => 'DOB',
            'Email' => 'Email',
            'MobileNo' => 'Mobile No',
            'Designation' => 'Designation',
            'Gender' => 'Gender',
            'TermCondition' =>Yii::t('frontend','TermCondition'),
            'Occupation' => 'Occupation',
            'Interest' => 'Interest',
            'DeviceType' => 'Device Type',
            'DeviceToken' => 'Device Token',
            'SignupType' => 'Signup Type',
            'Status' => 'Status',
            'UserID' => 'User ID',
            'ActivationCode' => 'Activation Code',
            'ActivatedOn' => 'Activated On',
            'Created' => 'Created',
            'Updated' => 'Updated',
            'CreatedBy' => 'Created By',
            'UpdatedBy' => 'Updated By',
        ];
    }
        /**
     * @inheritdoc
     */
     public static function getInterest() {
         $listData=array('1'=>'Cricket','2'=>'Football','3'=>'Learning Game','4'=>'Rugby','5'=>'Sportz News','6'=>'Talk shows');
        return $listData;
    }
            /**
     * @inheritdoc
     */
     public static function getOccupations() {
         $listData=array('1'=>'Student','2'=>'IT Professional','3'=>'Doctors','4'=>'Auditors','5'=>'Sportz Trainers');
        return $listData;
    }
       
}
