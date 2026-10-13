<?php

namespace backend\controllers;

use Yii;
use backend\models\User;
use backend\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\filters\AccessControl;
use backend\models\Member;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends \backend\components\BackendController {

    /*public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['update', 'myprofile', 'create', 'index'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }*/

    public function beforeAction($action) {
        if (\Yii::$app->getUser()->isGuest &&
                \Yii::$app->getRequest()->url !== Url::to(\Yii::$app->getUser()->loginUrl)
        ) {
            \Yii::$app->getResponse()->redirect(\Yii::$app->getUser()->loginUrl);
        }
        return parent::beforeAction($action);
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new UserSearch();
        if (isset($_GET['UserSearch'])) {
            $searchModel->attributes = $_GET['UserSearch'];
        }
        return $this->render('index', [
                    'model' => $searchModel,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {

        $model = new User();
        $model->scenario = 'create';
        $member_model = new Member();
        $member_model->scenario = 'create';

        if ($model->load(Yii::$app->request->post()) && $member_model->load(Yii::$app->request->post())) {
            $member_model->UserType = $model->UserType;
           
            $tempvalidate = $model->validate();
            $tempvalidate = $member_model->validate() && $tempvalidate;

            if($tempvalidate){
                    $userData = \backend\models\User::findAll(array("UserName"=>new  \yii\db\Expression("AES_ENCRYPT('".$_POST["User"]["UserName"]."',Password('".AESKEY."'))")));
                    if(count($userData)>0) {
                        $model->addError('UserName', 'This username is already exists please try with different username');
                    }else{
                        $member_model->setAttributes($model->attributes);

                        $model->UserName = new \yii\db\Expression("AES_ENCRYPT('" . $_POST["User"]["UserName"] . "',Password('" . AESKEY . "'))");
                        $model->Email = new \yii\db\Expression("AES_ENCRYPT('" . $_POST["User"]["Email"] . "',Password('" . AESKEY . "'))");
                        $model->Password = md5($_POST['User']['Password']);
                        $model->ConfirmPassword = md5($_POST['User']['Password']);
                        $model->Created = date("Y-m-d H:i:s");
                        if(isset($_POST['Member']['parent_role_user_id']) && $_POST['Member']['parent_role_user_id'] !='')
                            $model->parent_role_user_id =  $_POST['Member']['parent_role_user_id'];
                        $model->save(false);

                        if($model->UserType == 2){
                            $member_model->UserID = $model->UserID;
                            $member_model->Created = date("Y-m-d H:i:s");
                            $member_model->CreatedBy = Yii::$app->user->identity->UserID;
                            $member_model->MobileNo = new  \yii\db\Expression("AES_ENCRYPT('".$_POST["Member"]["MobileNo"]."',Password('".AESKEY."'))");
                            $member_model->save(false);
                        }
                        Yii::$app->session->setFlash('success', 'Admin has been added successfully');
                        return $this->redirect('index');
                    }

            }
        }
        return $this->render('create', compact(['model','member_model']));
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
      
        $model = $this->findModel($id);
        $model->scenario = 'update';
        
        $oldPassword = $model->Password;
        $member_model = $this->findMemberModel($id);
        $usertype = $model->UserType;

        if ($model->load(Yii::$app->request->post()) && $member_model->load(Yii::$app->request->post())) {
            $member_model->UserType = $model->UserType;
           
            if (($_POST['User']['Password'] != '' && $_POST['User']['ConfirmPassword'] != '') &&
                ($_POST['User']['Password'] == $_POST['User']['ConfirmPassword'])) {
                $model->Password = md5($_POST['User']['Password']);
                $model->ConfirmPassword = md5($_POST['User']['Password']);
            } else {
                $model->Password = $oldPassword;
                $model->ConfirmPassword = $oldPassword;
            }

            $tempvalidate = $model->validate();
            $tempvalidate = $member_model->validate() && $tempvalidate;

            if($tempvalidate){
                   
                $member_model->setAttributes($model->attributes);
                $model->UserType = $usertype;
                $model->UserName = new \yii\db\Expression("AES_ENCRYPT('" . $_POST["User"]["UserName"] . "',Password('" . AESKEY . "'))");
                $model->Email = new \yii\db\Expression("AES_ENCRYPT('" . $_POST["User"]["Email"] . "',Password('" . AESKEY . "'))");
                $model->Password = md5($_POST['User']['Password']);
                $model->ConfirmPassword = md5($_POST['User']['Password']);
                $model->Created = date("Y-m-d H:i:s");
                if(isset($_POST['Member']['parent_role_user_id']) && $_POST['Member']['parent_role_user_id'] !='')
                            $model->parent_role_user_id =  $_POST['Member']['parent_role_user_id'];
                $model->save(false);

                if($model->UserType == 2){
                    $member_model->UserID = $model->UserID;
                    $member_model->Created = date("Y-m-d H:i:s");
                    $member_model->CreatedBy = Yii::$app->user->identity->UserID;
                    $member_model->MobileNo = new  \yii\db\Expression("AES_ENCRYPT('".$_POST["Member"]["MobileNo"]."',Password('".AESKEY."'))");
                    $member_model->save(false);
                }
                Yii::$app->session->setFlash('success', 'Admin has been added successfully');
                return $this->redirect('index');
             }
        }

   /*     if ($model->load(Yii::$app->request->post())) {
        
            if (($_POST['User']['Password'] != '' && $_POST['User']['ConfirmPassword'] != '') &&
                ($_POST['User']['Password'] == $_POST['User']['ConfirmPassword'])) {
                $model->Password = md5($_POST['User']['Password']);
                $model->ConfirmPassword = md5($_POST['User']['Password']);
            } else {
                $model->Password = $oldPassword;
                $model->ConfirmPassword = $oldPassword;
            }
            
            if ($model->validate()) {
            
                $model->Updated = date("Y-m-d H:i:s");
                $model->UpdatedBy = Yii::$app->user->identity->UserID;
                $email = $_POST["User"]["Email"];
                $model->Email = new \yii\db\Expression("AES_ENCRYPT('" . $email . "',Password('" . AESKEY . "'))");
                Yii::$app->session->setFlash('success', 'Admin has been updated successfully');
                $model->save(false);
                return $this->redirect('index');
            
            } else {
                return $this->render('update', [
                            'model' => $model,
                ]);
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }*/
        return $this->render('update', compact(['model','member_model']));
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        $model = User::find()->select("*,AES_DECRYPT(Email,Password('" . AESKEY . "')) AS Email,AES_DECRYPT(UserName,Password('" . AESKEY . "')) AS UserName")
                ->where('UserID =' . $id)
                ->one();
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findMemberModel($id)
    {
        //$model = Artist::findOne($id);
        $model = Member::find()->select("*,AES_DECRYPT(MobileNo,Password('".AESKEY."')) AS MobileNo")
        ->where('UserID ='.$id)
        ->one();
        if ($model !== null) {
            return $model;
        }else{
            return new Member;
        }
    }

    /**
     * Change password Controller.
     * @param integer $id
     * @return mixed
     */
    public function actionMyprofile() {
        $identity = Yii::$app->user->identity->UserID;
        $model = $this->findModel($identity);
        $model->scenario = 'myprofile';
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->Password=md5($model->NewPassword);
                $model->save();
            } else {
              $errors = $model->errors;
            }
        }
        return $this->render('myprofile', [
                    'model' => $model,
        ]);
    }

}
