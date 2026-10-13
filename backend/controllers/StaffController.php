<?php

namespace backend\controllers;

use Yii;
use backend\models\Member;
use backend\models\MemberSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StaffController implements the CRUD actions for Member model.
 */
class StaffController extends \backend\components\BackendController
{
    /*public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }*/

    /**
     * Lists all Member models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MemberSearch();
        
        if (isset($_GET['MemberSearch'])) {
            $searchModel->attributes = $_GET['MemberSearch'];
        }
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
  
        return $this->render('index', [
            'searchModel' => $searchModel,
           // 'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Member model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Member model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Member();
        $model->scenario = 'create';
        $model->SignupType=1;
        $modelUser  = new \backend\models\User();
        $modelUser->UserType = '2';
        if ($model->load(Yii::$app->request->post())) {
            if($model->validate()) {
                $userData = \backend\models\User::findAll(array("UserName"=>new  \yii\db\Expression("AES_ENCRYPT('".$_POST["Member"]["UserName"]."',Password('".AESKEY."'))")));
                if(count($userData)>0) {
                    $model->addError('UserName', 'This username is already exists please try with different username');
                    return $this->render('create', [
                        'model' => $model,
                    ]);
                }
                $userName = $_POST["Member"]["UserName"];
                $email = $_POST["Member"]["Email"];
                $modelUser->UserName = new  \yii\db\Expression("AES_ENCRYPT('".$userName."',Password('".AESKEY."'))");
                $modelUser->Email = new  \yii\db\Expression("AES_ENCRYPT('".$email."',Password('".AESKEY."'))");
                $modelUser->Password = md5($_POST['Member']['Password']);
                $modelUser->ConfirmPassword = md5($_POST['Member']['Password']);
                $modelUser->Status = $_POST['Member']['Status'];
                
                $modelUser->Created = date("Y-m-d H:i:s");
                $modelUser->CreatedBy = Yii::$app->user->identity->UserID;
                $modelUser->save(false);
                $userID = Yii::$app->db->getLastInsertID();
                $model->UserID = $userID;
                $model->Created = date("Y-m-d H:i:s");
                $model->CreatedBy = Yii::$app->user->identity->UserID;
                $model->MobileNo = new  \yii\db\Expression("AES_ENCRYPT('".$_POST["Member"]["MobileNo"]."',Password('".AESKEY."'))");
                $model->save(false);
                Yii::$app->session->setFlash('success', 'Staff has been created successfully');
                return $this->redirect('index');
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'modelUser'=>$modelUser,
                ]);
            }    
        } else {
            return $this->render('create', [
                'model' => $model,
                'modelUser'=>$modelUser,
            ]);
        }
    }

    /**
     * Updates an existing Member model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $modelUser  = $this->findModelForUser($model->UserID);
        
        $conditionForUser = array("UserID"=>$model->UserID);
        $model->UserName = $modelUser->UserName; 
        $model->Email = $modelUser->Email; 
        $model->scenario = 'update';
        $oldPassword = $modelUser->Password;
        if ($model->load(Yii::$app->request->post())) {
            if( ($_POST['Member']['Password']!='' && $_POST['Member']['ConfirmPassword']!='') &&
                ($_POST['Member']['Password']==$_POST['Member']['ConfirmPassword']) ) {
                $model->Password = md5($_POST['Member']['Password']);
                $model->ConfirmPassword = md5($_POST['Member']['Password']);
            } else {
                $model->Password = $oldPassword;
                $model->ConfirmPassword = $oldPassword;
            }
            if($model->validate()) {
                if( ($_POST['Member']['Password']!='' && $_POST['Member']['ConfirmPassword']!='') &&
                    ($_POST['Member']['Password']==$_POST['Member']['ConfirmPassword']) ) {
                    $modelUser->Password = md5($_POST['Member']['Password']);
                    $modelUser->ConfirmPassword = md5($_POST['Member']['Password']);
                } else {
                    $modelUser->Password = $oldPassword;
                    $modelUser->ConfirmPassword = $oldPassword;
                }
                $modelUser->Status = $_POST['Member']['Status'];
                $modelUser->UserName = new  \yii\db\Expression("AES_ENCRYPT('".$_POST["Member"]["UserName"]."',Password('".AESKEY."'))");
                $modelUser->Updated = date("Y-m-d H:i:s");
                $modelUser->UpdatedBy = Yii::$app->user->identity->UserID;
                if(!$modelUser->save(false)) {
                    return $this->render('update', [
                        'model' => $model,
                        'modelUser' => $modelUser,
                    ]);
                }
                $model->MobileNo = new  \yii\db\Expression("AES_ENCRYPT('".$_POST["Member"]["MobileNo"]."',Password('".AESKEY."'))");
                $model->Updated = date("Y-m-d H:i:s");
                $model->UpdatedBy = Yii::$app->user->identity->UserID; 
                if(!$model->save(false)) {
                    return $this->render('update', [
                        'model' => $model,
                        'modelUser' => $modelUser,
                    ]);
                }
                    
                Yii::$app->session->setFlash('success', 'Staff has been updated successfully');
                return $this->redirect('index');
            } else {
                return $this->render('update', [
                     'model' => $model,
                    'modelUser' => $modelUser,
                ]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelUser' => $modelUser,
            ]);
        }
    }

    /**
     * Deletes an existing Member model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Member model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Member the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    
    protected function findModel($id)
    {
        //$model = Artist::findOne($id);
        $model = Member::find()->select("*,AES_DECRYPT(MobileNo,Password('".AESKEY."')) AS MobileNo")
	    ->where('MemberID ='.$id)
	    ->one();
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function findModelForUser($id)
    {
        $model =  \backend\models\User::find()->select("*,AES_DECRYPT(UserName,Password('".AESKEY."')) AS UserName,,AES_DECRYPT(Email,Password('".AESKEY."')) AS Email")
	    ->where('UserID ='.$id.'')
	    ->one();
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionParentRoleUserId(){

        $arr = [];
        $selected = '';
        if (isset($_POST['depdrop_all_params']['member-designation'])) {
            $designation = $_POST['depdrop_all_params']['member-designation'];
            $selected = $_POST['depdrop_all_params']['hidden_parent_id'];;
            $id =  $_POST['depdrop_all_params']['member-memberid'];
            $role_details = \backend\models\UserRole::find()->where(["id"=>$designation])->asArray()->one();
           // print_r($role_details);
            if(!empty($role_details)){
                if($role_details['child_id'] != 0){
                    $member = Member::find()->where("Designation = '".$role_details['child_id']."' && MemberID != '".$id."'")->asArray()->all();
                    foreach ($member as $key => $value) {
                        $arr[] = array('id'=>$value['UserID'],'name'=>$value['FirstName']);
                    }
                }
            }
           /* if ($parents != null) {
                $cat_id = $parents[0];
                $out = self::getSubCatList($cat_id);
                // the getSubCatList function will query the database based on the
                // cat_id and return an array like below:
                // [
                // ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
                // ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
                // ]
                echo Json::encode(['output'=>$out, 'selected'=>'']);
                return;
            }*/
        }
        echo json_encode(['output'=>$arr, 'selected'=>$selected]);
        return;
    }
    
}
