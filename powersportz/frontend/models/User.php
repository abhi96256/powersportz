<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $UserID
 * @property string $UserName
 * @property string $Email
 * @property string $Password
 * @property string $Status
 * @property string $UserType
 * @property string $LastLogin
 * @property integer $CreatedBy
 * @property integer $UpdatedBy
 * @property string $Created
 * @property string $Updated
 */
class User extends \yii\db\ActiveRecord
{
     public $ConfirmPassword;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Email','Password'], 'required'],
            [['Status', 'UserType'], 'string'],
            [['Password','ConfirmPassword'], 'required','on'=>'resetpassword'],
            ['ConfirmPassword', 'compare', 'compareAttribute'=>'Password', 'message'=>"Passwords doesn't match"],
            [['LastLogin', 'Created', 'Updated'], 'safe'],
            [['CreatedBy', 'UpdatedBy'], 'integer'],
            [['UserName', 'Email'], 'string', 'max' => 255],
            [['Password'], 'string','max'=>20],
            [['Password'], 'string','min'=>8]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'UserID' => 'User ID',
            'UserName' => 'User Name',
            'Email' => 'Email',
            'Password' => 'Password',
            'Status' => 'Status',
            'UserType' => 'User Type',
            'LastLogin' => 'Last Login',
            'CreatedBy' => 'Created By',
            'UpdatedBy' => 'Updated By',
            'Created' => 'Created',
            'Updated' => 'Updated',
        ];
    }
     public function loginForUser($username, $rememberMe) {
        $session = Yii::$app->session;
        $userModel = new \common\models\User();
        $userData = $userModel->findByUsernameForFrontUser($username); 
        
        return Yii::$app->user->login($userData, $rememberMe ? 3600 * 24 * 30 : 0);
        
        /*$redirectto=Yii::$app->request->referrer;
        if ($session->has('redirectto')){
            return $this->redirect($session['redirectto']);
        }
        return  Yii::$app->user->login($userData, $rememberMe ? 3600 * 24 * 30 : 0);*/

       
    }

    public function getStatus() {
        return array("1" => "Active", "2" => "Inactive", "3" => "Pending");
    }

    public function getStatusValue($id) {
        $status = array("1" => "Active", "2" => "Inactive", "3" => "Pending", "" => "Not Set");
        return $status[$id];
    }
    
}
