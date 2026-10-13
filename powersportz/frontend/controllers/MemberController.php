<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Member;
use frontend\models\MemberSearch;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\User;
use frontend\models\Forgotpassword;
use yii\web\UploadedFile;
use  yii\web\Session;

/**
 * MemberController implements the CRUD actions for Member model.
 */
class MemberController extends Controller {

    public $enableCsrfValidation = false;

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actions() {
        return [
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'successCallback'],
            ],
            'authforgoogle' => [
             'class' => 'yii\authclient\AuthAction',
             'successCallback' => [$this, 'successcallbackforgoogle'],
         ],
         
     ];
 }
 public function init(){
    $_SESSION['language_id'] = 'eng-US';
    Yii::$app->language = 'eng-US';
}

public function Successcallbackforgoogle($client) {
    $attributes = $client->getUserAttributes();        
    $name = $attributes['displayName'];
    $email = $attributes['emails'][0]['value'];
    $model = new Member();
    $rememberMe = false;
    $model->scenario = 'register';
    $modelUser = new \backend\models\User();
    $userData = \backend\models\User::findAll(array("Email" => new \yii\db\Expression("AES_ENCRYPT('" . $email . "',Password('" . AESKEY . "'))")));
    if (count($userData) > 0) {
        $username = $email;
        $userID = $userData[0]->UserID;
        $userType = $userData[0]->UserType;
        $session = Yii::$app->session;
        $session->set('is_social',1);
        $session->set('frontuserName', $username);
        $session->set('frontuserName', $userID);
        $session->set('frontuserName', $userType);
        User::loginForUser($username, $rememberMe);
    } else {
        $enctrypeml = new \yii\db\Expression("AES_ENCRYPT('" . $email . "',Password('" . AESKEY . "'))");
        $modelUser->Email = $enctrypeml;
        $modelUser->UserName = $enctrypeml;
        $modelUser->Status = '1';
        $modelUser->UserType = '3';
        $modelUser->Created = date("Y-m-d H:i:s");
        $modelUser->save(false);
        $userID = Yii::$app->db->getLastInsertID();
        $model->UserID = $userID;
        $model->FirstName = $name;
        $model->Email = $email;
        $model->SignupType = '3';
        $model->Status = '2';
        $model->Created = date("Y-m-d H:i:s");
        $model->save(false);
        $condition = "Email = AES_ENCRYPT('" . $email . "',Password('" . AESKEY . "')) AND Status = '1' AND UserType IN ('3') ";
            //$loginData = User::find()->where($condition)->all();
        $loginData = User::find()->select("*,AES_DECRYPT(Email,Password('" . AESKEY . "')) AS Email,AES_DECRYPT(UserName,Password('" . AESKEY . "')) AS UserName")
        ->where($condition)->all();
        if (count($loginData) > 0) { 
            $username = $loginData[0]->UserName;
            $userID = $loginData[0]->UserID;
            $userType = $loginData[0]->UserType;
            $session = Yii::$app->session;
            $session->set('frontuserName', $username);
            $session->set('frontuserName', $userID);
            $session->set('frontuserName', $userType);
            User::loginForUser($username, $rememberMe);
        }
    }
}
public function successCallback($client) {
       // var_dump($client);die;
    $attributes = $client->getUserAttributes();
    $name = $attributes['name'];
    $email = $attributes['email'];
        //var_dump($attributes);
    $model = new Member();
    $rememberMe = false;
    $model->scenario = 'register';
    $modelUser = new \backend\models\User();
    $userData = \backend\models\User::findAll(array("Email" => new \yii\db\Expression("AES_ENCRYPT('" . $email . "',Password('" . AESKEY . "'))")));
    if (count($userData) > 0) {
        $username = $email;
        $userID = $userData[0]->UserID;
        $userType = $userData[0]->UserType;
        $session = Yii::$app->session;
        $session->set('frontuserName', $username);
        $session->set('frontuserName', $userID);
        $session->set('frontuserName', $userType);
        User::loginForUser($username, $rememberMe);
    } else {
        $enctrypeml = new \yii\db\Expression("AES_ENCRYPT('" . $email . "',Password('" . AESKEY . "'))");
        $modelUser->Email = $enctrypeml;
        $modelUser->UserName = $enctrypeml;
        $modelUser->Status = '1';
        $modelUser->UserType = '3';
        $modelUser->Created = date("Y-m-d H:i:s");
        $modelUser->save(false);
        $userID = Yii::$app->db->getLastInsertID();
        $model->UserID = $userID;
        $model->FirstName = $name;
        $model->Email = $email;
        $model->SignupType = '2';
        $model->Status = '2';
        $model->Created = date("Y-m-d H:i:s");
        $model->save(false);
        $condition = "Email = AES_ENCRYPT('" . $email . "',Password('" . AESKEY . "')) AND Status = '1' AND UserType IN ('3') ";
            //$loginData = User::find()->where($condition)->all();
        $loginData = User::find()->select("*,AES_DECRYPT(Email,Password('" . AESKEY . "')) AS Email,AES_DECRYPT(UserName,Password('" . AESKEY . "')) AS UserName")
        ->where($condition)->all();
        if (count($loginData) > 0) {
            $username = $loginData[0]->UserName;
            $userID = $loginData[0]->UserID;
            $userType = $loginData[0]->UserType;
            $session = Yii::$app->session;
            $session->set('frontuserName', $username);
            $session->set('frontuserName', $userID);
            $session->set('frontuserName', $userType);
            User::loginForUser($username, $rememberMe);
        }
    }
}

public function actionRegister() {

    $model = new Member();
    $model->scenario = 'register';
    $modelUser = new \backend\models\User();
    if ($model->load(Yii::$app->request->post())) {
        if ($model->validate()) {
            $userData = \backend\models\User::findAll(array("UserName" => new \yii\db\Expression("AES_ENCRYPT('" . $_POST["Member"]["UserName"] . "',Password('" . AESKEY . "'))")));
            if (count($userData) > 0) {
                $model->addError('UserName', Yii::t('frontend', 'UsernameExists'));
                return $this->render('register', [
                    'model' => $model,
                ]);
            }
            $useremailData = \backend\models\User::findAll(array("Email" => new \yii\db\Expression("AES_ENCRYPT('" .strtolower($_POST["Member"]["Email"]) . "',Password('" . AESKEY . "'))")));
            if (count($useremailData) > 0) {
                $model->addError('Email', Yii::t('frontend', 'emailalredyexits'));
                return $this->render('register', [
                    'model' => $model,
                ]);
            }
            preg_match_all('!\d+!',$model->FirstName, $matches);
            preg_match_all('!\d+!',$model->LastName, $matches12);
            if(!empty($matches[0])){
                $model->addError('FirstName',Yii::t('frontend', 'firstnamenum'));
                return $this->render('register', [
                    'model' => $model,
                ]);   
            }
            if(!empty($matches12[0])){
                $model->addError('LastName',Yii::t('frontend', 'lastnamenum'));
                return $this->render('register', [
                    'model' => $model,
                ]);   
            }
            $sql = 'SELECT GetUniqueCode() as unique_key';
            $command = Yii::$app->db->createCommand($sql);
            $functionvlary = $command->queryAll();
            $unique_Id = $functionvlary[0]['unique_key'];
            $userName = $_POST["Member"]["UserName"];
            $email = $_POST["Member"]["Email"];
            $model->DOB=date("Y-m-d H:i:s",strtotime($_POST['Member']['DOB']));
            $modelUser->UserName = new \yii\db\Expression("AES_ENCRYPT('" . $userName . "',Password('" . AESKEY . "'))");
            $modelUser->Email = new \yii\db\Expression("AES_ENCRYPT('" . strtolower($email) . "',Password('" . AESKEY . "'))");
            $modelUser->Password = md5($_POST['Member']['Password']);
            $modelUser->ConfirmPassword = md5($_POST['Member']['Password']);
            $modelUser->Status = '1';
            $modelUser->UserType = '3';
            $modelUser->Created = date("Y-m-d H:i:s");
            $modelUser->save(false);
            $userID = Yii::$app->db->getLastInsertID();
            $model->UserID = $userID;
            $model->SignupType = '1';
            $model->ActivationCode = $unique_Id;
            $model->Status = '1';
            $model->Created = date("Y-m-d H:i:s");
            $model->save(false);
            Yii::$app->session->setFlash('success', 'We Have Sent you a verification email');
            Yii::$app->mailer->compose()
            ->setFrom('info@powersports3.e2logy.com')
            ->setTo($email)
            ->setSubject('Account Verification Email')
            ->setHtmlBody('<p>Hello '.$model->FirstName.' '.$model->LastName.'</p><p>We\'re so glad you joined us. We wish you a pleasant experience with us</p><p>Please <a href="'.Yii::$app->params['domainName'].Url::toRoute('member/verification?Accesstoken='.$unique_Id).'">Click Here to Verifiy Your Email</a>  to complete the verification process</p>'
                . '<p>Please contact info@powersports3.e2logy.com for help. </p>'
                . '<p>Greetings from </p>.' 
                .' Power Sportz</p>')
            ->send();
            return $this->redirect('login');
        }
    } else {
        return $this->render('register', [
            'model' => $model,
        ]);
    }
}

    /**
     * Login Controller.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Member the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionLogin() {
        $logincontid = Yii::$app->getRequest()->getQueryParam('id');
        if($logincontid){ Yii::$app->session->setFlash('error', Yii::t('frontend', 'mustlogin')); }
            $session = Yii::$app->session;
            $model = new Member();
            $model->scenario = 'login';
            if(Yii::$app->request->referrer!=null){
             $redirectto=Yii::$app->request->referrer;
             if($redirectto!=Yii::$app->params['domainName'].'member/login' && $redirectto!=Yii::$app->params['domainName'].'member/login/1'){
                $session->set('redirectto',$redirectto);
            }  
        }else{  
            $session->remove('redirectto'); 
        }
        if (!\Yii::$app->user->isGuest) {
            //echo 'is_user';die;
            return $this->goHome();
        }
        $redirectto=Yii::$app->request->referrer;
        $session->set('redirectto_',$redirectto);
        
        $model = new User();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $email = $_POST['User']['Email'];
            $password = $_POST['User']['Password'];
            $rememberMe = false;
            $condition = "Email = AES_ENCRYPT('" . strtolower($email) . "',Password('" . AESKEY . "')) AND Password = '" . md5($password) . "' AND Status = '1' AND UserType IN ('3') ";
            //$loginData = User::find()->where($condition)->all();
            $loginData = User::find()->select("*,AES_DECRYPT(Email,Password('" . AESKEY . "')) AS Email,AES_DECRYPT(UserName,Password('" . AESKEY . "')) AS UserName")
            ->where($condition)->all();
            if (count($loginData) > 0) {
                $username = $loginData[0]->UserName;
                $userID = $loginData[0]->UserID;
                $userType = $loginData[0]->UserType;
                $session = Yii::$app->session;
                $session->set('frontuserName', $username);
                $session->set('frontuserName', $userID);
                $session->set('frontuserName', $userType);
                User::loginForUser($username, $rememberMe);
                if ($session->has('redirectto') && !strpos($session['redirectto'],'member/register')) {
                    //echo $session['redirectto'];
                    return $this->redirect($session['redirectto']);
                }else{
                    return $this->goHome();
                }
                
            } else {
                Yii::$app->session->setFlash('error', Yii::t('frontend', 'LoginFailed'));
            }
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * forgot password Controller.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Member the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionForgotpassword() {
        $model = new Member();
        $model->scenario = 'forgotpassword';
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $email = $_POST['Member']['Email'];
            $modelemail = Member::find()->where(['Email' => $email])->one();
            if (!empty($modelemail)) {
                $memberid = $modelemail->UserID;
                $modelForgotpwd = Forgotpassword::find()->where(['RefID' => $memberid, 'Status' => '1'])->one();
                if (!empty($modelForgotpwd)) {
                    $unique_Id = $modelForgotpwd->UniqueCode;
                } else {
                    $sql = 'SELECT GetUniqueCode() as unique_key';
                    $command = Yii::$app->db->createCommand($sql);
                    $functionvlary = $command->queryAll();
                    $unique_Id = $functionvlary[0]['unique_key'];
                    $modelForgotpwd = new Forgotpassword();
                    $modelForgotpwd->RefID = $memberid;
                    $modelForgotpwd->UniqueCode = $unique_Id;
                    $modelForgotpwd->RefTableID = '1';
                    $modelForgotpwd->Status = '1';
                    $modelForgotpwd->save();
                }

                Yii::$app->mailer->compose()
                ->setFrom('info@powersports3.e2logy.com')
                ->setTo($email)
                ->setSubject('Password Reset Link')
                ->setHtmlBody('<p>Hello '.$modelemail->FirstName.' '.$modelemail->LastName.' </p>'
                    .'<p>We recieved a request to reset the password associated with this e-mail address. 
                    If you made this request , please follow the instructions below.</p>'
                    .'<p>Click on the link below to reset your password </p>'
                    . '<a href="'.Yii::$app->params['domainName'].Url::toRoute('member/resetpassword?Accesstoken='.$unique_Id).'">Click Here to Reset Your Password</a>'
                    . '<p>If you did not request to have your password reset you can safely ignore this mail.</p>'
                    . '<p>Greeting from</p> <p> Power Sportz</p>')
                ->send();
                Yii::$app->session->setFlash('success', Yii::t('frontend', 'Forgotmailsent'));
                return $this->render('forgotpassword', [
                    'model' => $model,
                ]);
            }
            else{
                $model->addError('Email',Yii::t('frontend', 'enterregisteremail'));
                return $this->render('forgotpassword', [
                    'model' => $model,
                ]);    
            }
        }
        return $this->render('forgotpassword', [
            'model' => $model,
        ]);
    }

    /**
     * password reset Controller.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Member the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionResetpassword() {

        $request = Yii::$app->request;
        $Accesstoken = $request->get('Accesstoken');
        $modelForgotpwd = Forgotpassword::find()->where(['UniqueCode' => $Accesstoken, 'Status' => '1'])->one();
        if (!empty($modelForgotpwd)) {
            $memberid = $modelForgotpwd->RefID;
            $model = User::find()->where(['UserID' => $memberid])->one();

            $model->scenario = 'resetpassword';
            if ($model->load(Yii::$app->request->post()) && $model->validate()) {
                $password = $_POST['User']['Password'];
                $model->Password = md5($password);
                $model->save(false);
                $modelForgotpwd->Status = '2';
                $modelForgotpwd->save();
                Yii::$app->session->setFlash('success', Yii::t('frontend', 'ChangePasswordSuccess'));
                return $this->redirect('login');
            }
            return $this->render('resetpassword', [
                'model' => $model,
            ]);
        } else {
            return $this->redirect('login');
        }
    }

    /**
     * Account Verification.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Member the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionVerification() {
        $request = Yii::$app->request;
        $Accesstoken = $request->get('Accesstoken');
        $model = Member::find()->where(['ActivationCode' => $Accesstoken])->one();
        if (!empty($model)) {
            if ($model->Status == '1') {
                $model->Status = '2';
                $model->ActivatedOn = date("Y-m-d H:i:s");
                $model->save(false);
                Yii::$app->session->setFlash('success', Yii::t('frontend', 'AccountVerified'));
                return $this->redirect('login');
            } else {
                Yii::$app->session->setFlash('error', Yii::t('frontend', 'AccountalreadyVerified'));
                return $this->redirect('login');
            }
        } else {
            $model = new Member();
            return $this->render('login', [
                'model' => $model,
            ]);
        }
        //ArrayHelper::toArray($model, $properties);
    }

    /**
     * logout action.
     */
    public function actionLogout() {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * Finds the Member model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Member the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Member::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionMywatchlist() {
        $lang_code=Yii::$app->language;
        if(isset($_SESSION['language_id'])){
            $lang_code = $_SESSION['language_id'];
            Yii::$app->language = $lang_code;
        }
        //$lang_data=\backend\models\Langauge\getLanguageId($lang_code);
        $lang_data=\backend\models\Langauge::getLanguageId($lang_code);
        if(!empty($lang_data)){
            $lang_id=$lang_data['LanguageID'];
        }
        else{
            $lang_id='';
        }
        /* TYPE:  1-Like,2-Favourite,3-Watchlist */
        if (!Yii::$app->getUser()->isGuest) {
            $userID = Yii::$app->user->identity->UserID;
            $modelMember = \frontend\models\Member::find()->where(['UserID' => $userID])->one();
            $membrID = $modelMember->MemberID;
            $type = '3';

            $videoPath = '';
            $sql = 'CALL Video_MyWatchLaterList(:MemberID,:videoPath)';
            $command = Yii::$app->db->createCommand($sql);
            $command->bindParam(":MemberID", $membrID);
            $command->bindParam(":videoPath", $videoPath);
            $watchlistdetails = $command->queryAll();
            if($lang_id!='' || $lang_id!='1'){
             if(!empty($watchlistdetails)){
                foreach($watchlistdetails as $watchkey=>$watchlistdetailssub){
                   $watchvideoid=$watchlistdetailssub['ID'];
                   $sql = 'CALL Getdetails_by_lang(:lang_id,"video",:Video)';
                   $command = Yii::$app->db->createCommand($sql);
                   $command->bindParam(":Video", $watchvideoid);
                   $command->bindParam(":lang_id", $lang_id);
                   $translatedwtcviddata = $command->queryAll();
                   if(!empty($translatedwtcviddata)){
                    foreach($translatedwtcviddata as $translatedwtcviddatasub){
                       if($translatedwtcviddatasub['value']!=''){
                          $watchlistdetails[$watchkey][$translatedwtcviddatasub['field_name']]=$translatedwtcviddatasub['value']; 
                      } 
                  }
              }
          }
      }   
  }
  return $this->render('mywatchlist', [
    'watchlistdetails' => $watchlistdetails
]);
} else {
    Yii::$app->session->setFlash('error', Yii::t('frontend', 'mustlogin'));
    return $this->redirect('../member/login');
}
}

public function actionMyfavourite() {
    $lang_code=Yii::$app->language;
    if(isset($_SESSION['language_id'])){
        $lang_code = $_SESSION['language_id'];
        Yii::$app->language = $lang_code;
    }
        //$lang_data=\backend\models\Langauge\getLanguageId($lang_code);
    $lang_data=\backend\models\Langauge::getLanguageId($lang_code);
    if(!empty($lang_data)){
        $lang_id=$lang_data['LanguageID'];
    }
    else{
        $lang_id='';
    }
    /* TYPE:  1-Like,2-Favourite,3-Watchlist */
    if (!Yii::$app->getUser()->isGuest) {
     $userID = Yii::$app->user->identity->UserID;
     $modelMember = \frontend\models\Member::find()->where(['UserID' => $userID])->one();
     $membrID = $modelMember->MemberID;
     $type = '2';
     $videoPath = '';
     $sql = 'CALL Video_MyFavorite(:MemberID,:videoPath)';
     $command = Yii::$app->db->createCommand($sql);
     $command->bindParam(":MemberID", $membrID);
     $command->bindParam(":videoPath", $videoPath);
     $favouritelistdetails = $command->queryAll();
     if($lang_id!='' || $lang_id!='1'){
        foreach($favouritelistdetails as $favkey=>$favouritelistdetailssub){
            $favvideoid=$favouritelistdetailssub['ID'];
            $sql = 'CALL Getdetails_by_lang(:lang_id,"video",:Video)';
            $command = Yii::$app->db->createCommand($sql);
            $command->bindParam(":Video", $favvideoid);
            $command->bindParam(":lang_id", $lang_id);
            $translatedfavviddata = $command->queryAll();
            if(!empty($translatedfavviddata)){
                foreach($translatedfavviddata as $translatedfavviddatasub){
                   if($translatedfavviddatasub['value']!=''){
                      $favouritelistdetails[$favkey][$translatedfavviddatasub['field_name']]=$translatedfavviddatasub['value']; 
                  } 
              }
          }
      }     
  }
  return $this->render('myfavourite', [
    'favouritelistdetails' => $favouritelistdetails
]);
} else {
    Yii::$app->session->setFlash('error', Yii::t('frontend', 'mustlogin'));
    return $this->redirect('../member/login');
}
}

public function actionMyvideo() {
    
    /* TYPE:  1-Like,2-Favourite,3-Watchlist */        
    $lang_code=Yii::$app->language;
    if(isset($_SESSION['language_id'])){
        $lang_code = $_SESSION['language_id'];
        Yii::$app->language = $lang_code;
    }
    if(isset($_SESSION['language_id']))
        if (!Yii::$app->getUser()->isGuest) {            
            $userID = Yii::$app->user->identity->UserID;
            $modelMember = \frontend\models\Member::find()->where(['UserID' => $userID])->one();
            $membrID = $modelMember->MemberID;
            $type = '';

            $sql = 'CALL My_Account_Video_List(:UserID,:MemberID,:Type);';
            $command = Yii::$app->db->createCommand($sql);
            $command->bindParam(":UserID", $userID);
            $command->bindParam(":MemberID", $membrID);
            $command->bindParam(":Type", $type);
            $videolistdetails = $command->queryAll();
            return $this->render('myvideo', [
                'videolistdetails' => $videolistdetails
            ]);
        } else {
            Yii::$app->session->setFlash('error', Yii::t('frontend', 'mustlogin'));
            return $this->redirect('../member/login');
        }
    }

    public function actionDeletevideo() {
        /* TYPE:  1-Like,2-Favourite,3-Watchlist */
        if (!Yii::$app->getUser()->isGuest) {
            $sid = $_POST['sid'];
            $type = $_POST['type'];
            if($type==''){
                $modelvideo = \backend\models\Videouploadbysubscribers::find()->where(['ID' => $sid])->one();
                $modelvideo->delete();
                if ($modelvideo->delete()) {
                    echo "success";
                    die;
                } else {
                    echo "fail";
                    die;
                }
                
            }else if($type!=''){
                $sql = 'Delete From videolike where ID = :ID';
                $command = Yii::$app->db->createCommand($sql);
                $command->bindParam(":ID", $sid);
                $command->query();
                /*$memberActivity = \frontend\models\Videolike::find()->where(['ID' => $sid])->one();
                $modelvideolike->delete();
                if ($modelvideolike->delete()) {
                    echo "success";
                    die;
                } else {
                    echo "fail";
                    die;
                }*/
            }
        } else {
            Yii::$app->session->setFlash('error', Yii::t('frontend', 'mustlogin'));
            return $this->redirect('../member/login');
        }
    }

    public function actionVideoupload() {
      
        if (!Yii::$app->getUser()->isGuest) {
            $model = new \frontend\models\Videouploadbysubscribers;
            $currentdate = date('Y-m-d H:i:s');
            $modelvideoenableupdate = \backend\models\Subscribervideosetting::find()->orderBy(['SID'=>SORT_DESC])->one();
            if(($currentdate >= $modelvideoenableupdate['FromDate']) && ($currentdate <= $modelvideoenableupdate['ToDate'])) {
              return $this->render('videoupload', [
                'model' => $model
            ]);
          }
          else{
            return $this->redirect('myvideo');
        }
    } else {
        Yii::$app->session->setFlash('error', Yii::t('frontend', 'mustlogin'));
        return $this->redirect('../member/login');
    }
}

   /* public function actionUpload() {
        if (!Yii::$app->getUser()->isGuest) {
            $model = new \frontend\models\Videouploadbysubscribers();

            if (isset($_FILES["FileInput"])) {
                ############ Edit settings ##############
                //  $UploadDirectory = '../../uploads/'; //specify upload directory ends with / (slash)
                $UploadDirectory = Yii::$app->basePath . '/web/uploads/'; //specify upload directory ends with / (slash)
                ##########################################
*/
                /*
                  Note : You will run into errors or blank page if "memory_limit" or "upload_max_filesize" is set to low in "php.ini".
                  Open "php.ini" file, and search for "memory_limit" or "upload_max_filesize" limit
                  and set them adequately, also check "post_max_size".
                 */

                //check if this is an ajax request
                /* if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
                  die();
                  }
                 */

                //Is file size is less than allowed size.
                /* if ($_FILES["FileInput"]["size"] > 5242880) {
                  die("File size is too big!");
              } */

                //allowed file type Server side check
               /* switch (strtolower($_FILES['FileInput']['type'])) {
                    //allowed file types

                    case 'video/mp4':
                        break;
                    default:
                        die('Unsupported File!'); //output error
                }

                $File_Name = strtolower($_FILES['FileInput']['name']);
                $File_Ext = substr($File_Name, strrpos($File_Name, '.')); //get file extention
                $Random_Number = rand(0, 9999999999); //Random number to be added to name.
                $time = time();
                $NewFileName = $Random_Number . $time . $File_Ext; //new file name
                $path = $UploadDirectory . $NewFileName;
                if (move_uploaded_file($_FILES['FileInput']['tmp_name'], $path)) {

                    /* Get MemberId and Userid */
                   /* if (!Yii::$app->getUser()->isGuest) {
                        $userID = Yii::$app->user->identity->UserID;
                        $modelMember = \frontend\models\Member::find()->where(['UserID' => $userID])->one();
                        $membrID = $modelMember->MemberID;
                        if ($model->validate()) {
                            $model->VideoTitle = $_POST['videotitle'];
                            $model->MemberID = $membrID;
                            $model->ApproveStatus = '1'; //1-Pending,2-Published,3-Rejected
                            $model->VideoFile = $NewFileName;
                            $model->CreatedBy = $userID;
                            $model->save();
                            if ($model->save()) {
                                Yii::$app->response->redirect(['member/myvideo']);
                            }
                        }
                    }
                } else {
                    die('error uploading File!');
                }
            } else {
                die('Something wrong with upload! Is "upload_max_filesize" set correctly?');
                return $this->render('videoupload', [
                            'model' => $model
                ]);
            }
        } else {
            Yii::$app->session->setFlash('error', Yii::t('frontend', 'mustlogin'));
            return $this->redirect('../member/login');
        }
    }*/

    public function actionUpload() {
        if (!Yii::$app->getUser()->isGuest) {
            $model = new \frontend\models\Videouploadbysubscribers();
            $userID = Yii::$app->user->identity->UserID;
            $modelMember = \frontend\models\Member::find()->where(['UserID' => $userID])->one();
            $membrID = $modelMember->MemberID;
            $model->VideoTitle = $_POST['videotitle'];
            $model->MemberID = $membrID;
                $model->ApproveStatus = '1'; //1-Pending,2-Published,3-Rejected
                $model->VideoFile = $_POST['VideoFile'];
                $model->CreatedBy = $userID;
                $model->save(false);
                return $this->redirect(['member/myvideo']);
            } else {
                Yii::$app->session->setFlash('error', Yii::t('frontend', 'mustlogin'));
                return $this->redirect('../member/login');
            }
        }

        public function actionMyprofile() {
            if(isset($_SESSION['language_id'])){
                $lang_code = $_SESSION['language_id'];
                Yii::$app->language = $lang_code;
            }
            if (!Yii::$app->getUser()->isGuest) {
                
                $userID = Yii::$app->user->identity->UserID;
                $modelMember = \frontend\models\Member::find()->where(['UserID' => $userID])->one();
                $membrID = $modelMember->MemberID;

                $model = new Member();
                $model->scenario = 'update';

                $model = $this->findModel($membrID);
                if ($model->load(Yii::$app->request->post())) {
                   
                    $fname = $_POST['Member']['FirstName'];
                    $lname = $_POST['Member']['LastName'];
                    $date= $_POST['Member']['DOB'];
                    $gender = $_POST['Member']['Gender'];

                    $model->FirstName = $fname;
                    $model->LastName = $lname;
                    if(!empty($date)){
                        
                    }else{
                        $model->DOB = '';
                    }
                    
                    $model->Gender = $gender;
                    $model->UpdatedBy = Yii::$app->user->identity->UserID;
                    $model->Updated = date('Y-m-d H:i:s');
                    $model->save();
                    if ($model->save()) {
                     Yii::$app->session->setFlash('success', Yii::t('frontend', 'Profile updated successfully!'));
                     Yii::$app->response->redirect(['member/myprofile']);
                 }else{
                  Yii::$app->session->setFlash('error', Yii::t('frontend', 'Sorry!Profile not updated'));
                  Yii::$app->response->redirect(['member/myprofile']);
              }

              Yii::$app->response->redirect(['member/myprofile']);
          } else {

            return $this->render('myprofile', [
                'model' => $model
            ]);
        }
    } else {
        Yii::$app->session->setFlash('error', Yii::t('frontend', 'mustlogin'));
        return $this->redirect('../member/login');
    }
}

public function actionChangepassword() {
    if (!Yii::$app->getUser()->isGuest) {
        $userID = Yii::$app->user->identity->UserID;
        $model = \frontend\models\Member::find()->where(['UserID' => $userID])->one();
        $model->scenario = 'changepassword';
        if ($model->load(Yii::$app->request->post())) {
            $modelUser = User::findOne($userID); 
            if($modelUser->Password != md5($model->oldPassword)){
                $model->addError('oldPassword',"Old Password was Invalid");
            }else{
                if($model->validate()){
                    $model->Updated = date('Y-m-d H:i:s');
                    $model->UpdatedBy = Yii::$app->user->identity->UserID;
                    $model->save(false);
                    $modelUser->Password = md5($model->Password);
                    $modelUser->Updated = date('Y-m-d H:i:s');
                    $modelUser->UpdatedBy = Yii::$app->user->identity->UserID;
                    $modelUser->save(false);
                    Yii::$app->session->setFlash('success', Yii::t('frontend', 'Password changed Successfully!  '));
                    return $this->redirect(['member/myprofile']);
                    
                }
                
            }
        }
        return $this->render('changepassword', [
            'model' => $model
        ]);
    } else {
        Yii::$app->session->setFlash('error', Yii::t('frontend', 'mustlogin'));
        return $this->redirect('../member/login');
    }
}

public function actionChangepasswordsave() {
    if (!Yii::$app->getUser()->isGuest) {
     $userID = Yii::$app->user->identity->UserID;
     $modelMember = \frontend\models\Member::find()->where(['UserID' => $userID])->one();
     $membrID = $modelMember->MemberID;

            //$model = new User();
            //$model->scenario = 'update';
            //$model = $this->findModel($userID);
     $model = \frontend\models\User::find()->where(['UserID' => $userID])->one();
            // echo "<pre>";print_r($model);die;

     if (isset($_POST)) {

        $model->Password = md5($_POST['newpassword']);
        $model->UpdatedBy = Yii::$app->user->identity->UserID;
        $model->Updated = date('Y-m-d H:i:s');
        $model->save(false);
        if ($model->save(false)) {
            $model->save(false);
            
            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', Yii::t('frontend', 'Password changed Successfully!  '));
                    // Yii::$app->response->redirect(['member/myprofile']);
                echo "success";
                die;
            } else {
             echo "fail";
             die;
         }
     }
 } else {
    Yii::$app->session->setFlash('error', Yii::t('frontend', 'mustlogin'));
    return $this->redirect('../member/login');
}
}
}

public function actionPasswordcheck() {
    if (!Yii::$app->getUser()->isGuest) {
        $oldpassword = md5($_POST['pwd']);

        $userID = Yii::$app->user->identity->UserID;
        $model = \frontend\models\User::find()->where(['UserID' => $userID])->one();
        $dbpwd = $model->Password;

        if ($oldpassword == $dbpwd) {
            echo "success";
            die;
        } else {
            echo "fail";
            die;
        }
    } else {
        Yii::$app->session->setFlash('error', Yii::t('frontend', 'mustlogin'));
        return $this->redirect('../member/login');
    }
}


    /* 
     * to add video in favourite list
     */
    public function actionAddtofavourit($vid){
        if(isset($_SESSION['language_id'])){
            $lang_code = $_SESSION['language_id'];
            Yii::$app->language = $lang_code;
        }  
        if (!Yii::$app->getUser()->isGuest) {
            $userID = Yii::$app->user->identity->UserID;
            $modelMember = \frontend\models\Member::find()->where(['UserID' => $userID])->one();
            $membrID = $modelMember->MemberID;
            $flag = 1; // flag 1 for to add video
            
            $redirectto=Yii::$app->request->referrer;
            $sql = 'CALL Video_AddRemoveFav(:UserID,:VideoID,:Flag)';
            $command = Yii::$app->db->createCommand($sql);
            $command->bindParam(":UserID",$membrID );
            $command->bindParam(":VideoID", $vid);
            $command->bindParam("Flag", $flag);
            $addtoFvrt = $command->query();
            
            return $this->redirect($redirectto);
        }
        else {
            Yii::$app->session->setFlash('error', Yii::t('frontend', 'mustlogin'));
            return $this->redirect('../member/login');
        }
    }
    
    /*
     * to add video in watchlist
     */
    public function actionAddtowatchlist($vid){
        if(isset($_SESSION['language_id'])){
            $lang_code = $_SESSION['language_id'];
            Yii::$app->language = $lang_code;
        }  
        if (!Yii::$app->getUser()->isGuest) {
            $userID = Yii::$app->user->identity->UserID;
            $modelMember = \frontend\models\Member::find()->where(['UserID' => $userID])->one();
            $membrID = $modelMember->MemberID;
            $flag = 1;
            
            $redirectto=Yii::$app->request->referrer;
            $sql = 'CALL Video_AddRemoveWatchList(:UserID,:VideoID,:Flag)';
            $command = Yii::$app->db->createCommand($sql);
            $command->bindParam(":UserID",$membrID );
            $command->bindParam(":VideoID", $vid);
            $command->bindParam("Flag", $flag);
            $addtoWatchlist = $command->query();
            
            return $this->redirect($redirectto);
        }
        else {
            Yii::$app->session->setFlash('error', Yii::t('frontend', 'mustlogin'));
            return $this->redirect('../member/login');
        }
    }
    
}
