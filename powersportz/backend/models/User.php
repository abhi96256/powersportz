<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use backend\models\User;

/**
 * This is the model class for table "user".
 *
 * @property integer $UserID
 * @property string $UserName
 * @property string $Password
 * @property string $Status
 * @property string $LastLoginDateTime
 * @property string $UserType
 * @property string $ActivationCode
 * @property string $ActivatedOn
 * @property integer $ArtistID
 * @property integer $parent_role_user_id
 * @property string $LastLogin
 * @property integer $CreatedBy
 * @property integer $UpdatedBy
 * @property string $Created
 * @property string $Updated
 */
class User extends \yii\db\ActiveRecord {

    public $ConfirmPassword;
    public $OldPassword;
    public $NewPassword;
    public $rememberMe = true;
    private $_user;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['UserName', 'Email', 'Password', 'Status'], 'required', 'on' => 'create'],
            [['UserName', 'Email', 'Status'], 'required', 'on' => 'update'],
            ['Email', 'email'],
            ['ConfirmPassword', 'required', 'on' => ['create', 'myprofile']],
            ['NewPassword', 'required', 'on' => 'myprofile'],
            ['OldPassword', 'findPasswords','skipOnEmpty' => false],
            ['OldPassword', 'required', 'on' => ['myprofile']],
            [['parent_role_user_id'], 'integer'],
            ['ConfirmPassword', 'compare', 'compareAttribute' => 'Password', 'message' => "Passwords doesn't match"],
            ['UserName', function(){
                    if(($userData = $this->findAll(array("UserName" => new \yii\db\Expression("AES_ENCRYPT('" . $_POST["User"]["UserName"] . "',Password('" . AESKEY . "'))")))) === NULL){
                        $this->addError('UserName', 'This username is already exists please try with different username');    
                        return false;
                    }
                }
            ],
            ['UserType','safe'],
            //['ConfirmPassword', 'compare', 'compareAttribute' => 'NewPassword', 'message' => "Passwords doesn't match"],
        ];
    }
    public function unique_username(){
        if(($userData = $this->findAll(array("UserName" => new \yii\db\Expression("AES_ENCRYPT('" . $_POST["User"]["UserName"] . "',Password('" . AESKEY . "'))")))) === NULL){
            $this->addError('UserName', 'This username is already exists please try with different username');    
            return false;
        }

    }
    //matching the old password with your existing password.
    public function findPasswords($attribute, $params)
    {        
        //$userModel = new \common\models\User();
        //$userData = $userModel->findIdentity(Yii::$app->user->identity->UserID);
        //if ($userData->Password != md5($this->OldPassword))
        //{
         //$this->addError($attribute, 'Old password is incorrect.');    
        //}      
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'UserID' => 'User ID',
            'UserName' => 'User Name',
            'Password' => 'Password',
            'ConfirmPassword' => 'Confirm Password',
            'OldPassword' => 'Old Password',
            'NewPassword' => 'New Password',
            'Status' => 'Status',
            'LastLoginDateTime' => 'Last Login Date Time',
            'UserType' => 'User Type',
            'parent_role_user_id' => Yii::t('app', 'Parent Users'),
            'ActivationCode' => 'Activation Code',
            'ActivatedOn' => 'Activated On',
            'ArtistID' => 'Artist ID',
            'CreatedBy' => 'Created By',
            'UpdatedBy' => 'Updated By',
            'Created' => 'Created',
            'Updated' => 'Updated',
        ];
    }

    public function loginForAdmin($username, $rememberMe) {
        $userModel = new \common\models\User();
        $userData = $userModel->findByUsernameForAdmin($username);
        return Yii::$app->user->login($userData, $rememberMe ? 3600 * 24 * 30 : 0);
    }

    public function getStatus() {
        return array("1" => "Active", "2" => "Inactive", "3" => "Pending");
    }

    public function getStatusValue($id) {
        $status = array("1" => "Active", "2" => "Inactive", "3" => "Pending", "" => "Not Set");
        return $status[$id];
    }

}
