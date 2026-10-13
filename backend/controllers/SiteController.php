<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;
use backend\models\User;
use backend\models\UserRules;
//use yii\rbac\PhpManager;
/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error','wccon','multistreaming','vodview','popview','adipmapping'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions'=>['authlinkedin','getsession'],
                        'allow'=>true,
                        
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post','get'],
                ],
            ],
        ];
    }

    public function actionGetsession(){
    //    print_r($_SESSION);die;
       return (!empty($_SESSION['twitter'])) ? 'Yes' : 'No';
    }
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

     public function actionIndex()
    {
        if (!\Yii::$app->user->isGuest) { 
            $role_id = Yii::$app->user->identity->UserType;
            if ($role_id == 3) {
                return $this->redirect(['/academy/player/index']);
            }
            if(($member = \backend\models\Member::find()->where(['UserID'=>Yii::$app->user->id])->asArray()->One()) !== null){
              $role_id = $member['Designation'];
            }
            $controller_name = 'HomepageController';
            $isHome = "";
            if($role_id != 1){
                $userRules_menu =  UserRules::find(["controller_name"=>$controller_name,'role_id'=>$role_id])->asArray()->all();
                foreach($userRules_menu as $key => $value) {
                    $roleID = $value['role_id'];
                    $controller = $value['controller_name'];
                    $action = array();
                    if($controller == 'HomepageController' && $roleID == $role_id) {
                        $isHome = "1";
                    } else if($roleID == $role_id) {
                        $anotherController = $value['controller_name'];
                        $anotherAction = explode(',',$value['action_name']);
                    } else {
                        $controller  = '';
                    }
                }
                if($isHome == '1') {
                    return $this->redirect(['homepage/update']);
                } else {
                    $controller = str_replace('Controller','',$anotherController);
                    return $this->redirect([strtolower($controller)."/index"]);
                }
            } else {
                return $this->redirect(['homepage/update']);
            }
        } else {
            return $this->redirect(['site/login']);
        }    
    }


    /*public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }*/
    
    
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new User();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $userName = $_POST['User']['UserName'];
            $password = $_POST['User']['Password'];
            $rememberMe = $_POST['User']['rememberMe'];
            //Staff::findOne([""])
            $condition = "UserName = AES_ENCRYPT('".$userName."',Password('".AESKEY."')) AND Password = '".md5($password)."' AND Status = '1' AND UserType IN ('1','2','3') ";
            //$loginData = User::find()->where($condition)->all();
            $loginData = User::find()->select("*,AES_DECRYPT(Email,Password('".AESKEY."')) AS Email,AES_DECRYPT(UserName,Password('".AESKEY."')) AS UserName")->where($condition)->all();
                // echo $loginData->createCommand()->sql;exit;
            if(count($loginData)>0) {
                $username = $loginData[0]->UserName;
                $userID = $loginData[0]->UserID;
                $userType = $loginData[0]->UserType;
                $session = Yii::$app->session;
                $session->set('userName',$username);
                $session->set('userID',$userID);
                $session->set('userType',$userType);    
                //We have set below session because Kanthi has reset the password and if user are not login with new password then they automatically logout
                $session->set('isLoginWithNewPassword',1);
                User::loginForAdmin($username,$rememberMe);
                //return $this->goHome();
                $role_id = Yii::$app->user->identity->UserType;
                if ($role_id == 3) {
                    return $this->redirect(['/academy/player/index']);
                }
                if(($member = \backend\models\Member::find()->where(['UserID'=>Yii::$app->user->id])->asArray()->One()) !== null){
                  $role_id = $member['Designation'];
                }
                $controller_name = 'HomepageController';
                $isHome = "";
                if($role_id != 1){
                    $userRules_menu =  UserRules::find(["controller_name"=>$controller_name,'role_id'=>$role_id])->asArray()->all();
                    foreach($userRules_menu as $key => $value) {
                        $roleID = $value['role_id'];
                        $controller = $value['controller_name'];
                        $action = array();
                        if($controller == 'HomepageController' && $roleID == $role_id) {
                            $isHome = "1";
                        } else if($roleID == $role_id) {
                            $anotherController = $value['controller_name'];
                            $anotherAction = explode(',',$value['action_name']);
                        } else {
                            $controller  = '';
                        }
                    }
                    if($isHome == '1') {
                        return $this->redirect(['homepage/update']);
                    } else {
                        $controller = str_replace('Controller','',$anotherController);
                        return $this->redirect([strtolower($controller)."/index"]);
                    }
                } else {
                    return $this->redirect(['homepage/update']);
                }
            } else {
                Yii::$app->session->setFlash('error', 'Username or password is incorrect');
            }
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    public function actionWccon()
    {
       
         return $this->render('wc');
    }
	
	public function actionMultistreaming()
    {
       
         return $this->render('ms');
    }

	public function actionPopview()
    {
       
         return $this->render('pop');
    }
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

      public function actionAdipmapping()
    {
         return $this->render('c_a_map');
    }
}
