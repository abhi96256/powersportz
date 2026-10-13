<?php

namespace backend\controllers;

use Yii;
use backend\models\TalkingPoints;
use backend\models\TalkingPointsSearch;
use backend\models\Categorygeographic;
use backend\models\Videocategory;
use backend\models\Country;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\Url;

/**
 * TalkingPointsController implements the CRUD actions for TalkingPoints model.
 */
class TalkingPointsController extends \backend\components\BackendController {

   /* public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['view', 'addvideos', 'videosearch', 'remove', 'update', 'create', 'index'],
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
     * Lists all TalkingPoints models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new TalkingPointsSearch();
        if(isset($_GET['TalkingPointsSearch'])) {
            $searchModel->attributes = $_GET['TalkingPointsSearch'];
        }


        return $this->render('index', [
            'searchModel' => $searchModel,

        ]);
    }

    /**
     * Displays a single TalkingPoints model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {

        $searchvideoModel = new TalkingPointsSearch();
        $modelCountry = new \backend\models\Categorygeographic();
        $countryData = $modelCountry->findAll(array('CategID'=>$id));
        
        $country  = array();
        
        foreach($countryData as $key => $value) {
            $country[] = $value->CountryID;
        }
        
        $sql = 'CALL Admin_Category_Topic_PlayList_Video_List (:id,:categType,"",:sort,"","")';
        $var_one = '3';
        $var_two = '1';
        $sort = ' vc.DisplayIndex desc ';
        $command = Yii::$app->db->createCommand($sql);
        $command->bindParam(":id", $id);
        $command->bindParam(":categType", $var_one);
        $command->bindParam(":sort", $sort); 
        $inlist = $command->queryAll();

        /* - Get Video Not In Category- */
        $sort = ' v.Created DESC ';
        $sql = 'CALL Admin_video_category (:id,:IDType,"",:sort,"","")';
        $command = Yii::$app->db->createCommand($sql);
        $command->bindParam(":id", $id);
        $command->bindParam(":IDType", $var_two);
        $command->bindParam(":sort", $sort);
        $outlist = $command->queryAll();

        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'searchvideoModel' => $searchvideoModel,
                    'videoinlist' => $inlist,
                    'videooutlist' => $outlist,
                    'selectedcountry' => $country
        ]);
    }

    /**
     * Creates a new TalkingPoints model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $query = new Query;
        $query->select('ID, Name')
                ->from('country');
        
        // build and execute the query
        $Countrylist = $query->all();
        $sql = 'SELECT GetUniqueCode() as unique_key';
        $command = Yii::$app->db->createCommand($sql);
        $functionvlary = $command->queryAll();
        $unique_Id = $functionvlary[0]['unique_key'];
        $model = new TalkingPoints();
        $model->Type = '3';
        $model->CreatedBy = Yii::$app->user->identity->UserID;
        
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if(isset($_FILES['TalkingPoints']['name']['CategThumb']) && $_FILES['TalkingPoints']['name']['CategThumb']!=''){
                    $filesTempName = $_FILES['TalkingPoints']['tmp_name']['CategThumb'];
                    $fileName = $_FILES['TalkingPoints']['name']['CategThumb'];
                    $ext = pathinfo($fileName, PATHINFO_EXTENSION);
                    $actualImageName = PREFIX_TOPICS . $unique_Id . '.' . $ext;
                    
                    if (\S3::putObjectFile($filesTempName, S3BUCKET, TOPICS . '/' . $actualImageName, \S3::ACL_PUBLIC_READ)) {
                        $model->CategThumb = $actualImageName;
                        $model->CreatedBy = Yii::$app->user->identity->UserID;
                        $model->save();
                    }
                }
                else{
                    $model->addError('CategThumb','Please Upload Image');
                    return $this->render('create', [
                        'model' => $model,
                        'countrylist' => $Countrylist
                    ]);
				}
                         $insertedcntryary = Yii::$app->request->post('Country');
                if (!empty($insertedcntryary)) {
                    foreach ($insertedcntryary as $insertedcntry) {
                        $Categorygeographic = new Categorygeographic();
                        $Categorygeographic->CategID = $model->ID;
                        $Categorygeographic->CountryID = $insertedcntry;
                        $Categorygeographic->save();
                    }
                }
                        Yii::$app->session->setFlash('success', 'Talking Point  has been added successfully');
                        return $this->redirect('index');
                } else {
                        return $this->render('create', [
                            'model' => $model,
                            'countrylist' => $Countrylist
                        ]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'countrylist' => $Countrylist
            ]);
        }
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAddvideos() {
        if (Yii::$app->request->post()) {
            $videoidary = Yii::$app->request->post('videoid');
            $categoryid = Yii::$app->request->post('category');
            if (!empty($videoidary)) {
                foreach ($videoidary as $videoidarylp) {
                    $Videocategory = new Videocategory();
                    $Videocategory->CategID = $categoryid;
                    $Videocategory->VideoID = $videoidarylp;
                    $Videocategory->save();
                }
            }
              Yii::$app->session->setFlash('success', 'Video Hase been Added Successfuilly');
            return $this->redirect(['view', 'id' => $categoryid]);
        } else {
            return $this->render('index', []);
        }
    }

    /**
     * Updates an existing TalkingPoints model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
            $model = $this->findModel($id);
            $insertedcntryary = Yii::$app->request->post('Country');
            $model->Updated = date("Y-m-d H:i:s");
            $model->UpdatedBy = Yii::$app->user->identity->UserID;
        
           /* $sort = ' vc.created DESC'; 
            $sql = 'CALL Admin_Category_Topic_PlayList_Video_List (:id,:categType,"",:sort,"","")';
            $var_one = '1';
            $command = Yii::$app->db->createCommand($sql);
            $command->bindParam(":id", $id);
            $command->bindParam(":categType", $var_one);
            $command->bindParam(":sort", $sort);
            $inlist = $command->queryAll();*/


            $inlist = Videocategory::find()->
                    select(' * ')->
                    where('CategID = :id', ['id'=>$id])
                     ->orderBy(['DisplayIndex' => SORT_DESC ])->
                    asArray()->all();
            //$inlist = Videocategory::findAll(['VideoID' => $id]);
                
            if(!empty($inlist)){
                foreach($inlist as $vinlist){
                    $oldorderary[$vinlist['ID']]=$vinlist['ID'];    
                }
            }
            //echo count($oldorderary);die;
                
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $newarrayorder=json_decode(Yii::$app->request->post('newarrayorder'),true);
                //var_dump($newarrayorder);die;
                
                if(!empty($newarrayorder)){
                    if(!empty($oldorderary)){
                        $keyvar=count($oldorderary) - 1;
                        foreach($oldorderary as $ordrkey=>$oldorderarysub){
                            $neworderary[$newarrayorder[$keyvar]]=$oldorderarysub;
                            $keyvar--;
                        }
                    }        
                }
                
                if(!empty($neworderary)){
                      $keyvar=0;
                      //var_dump($neworderary);die;
                        foreach($neworderary as $newordkey=>$neworderarysub){
                        $newtopicsvideomodel = Videocategory::find()->where('CategID = :id  and VideoID = :videoid', ['id'=>$id,'videoid'=>$newordkey])->one();             
                        if(!empty($newtopicsvideomodel)){
                            
                            $newtopicsvideomodel->DisplayIndex=$keyvar;
                            $video = new \frontend\models\Video();
                            $newtopicsvideomodel->update();
                            
                            $newvideomodel = \backend\models\Video::find()->where(['ID' => $newordkey])->one(); 
                            $newvideomodel->DisplayIndex = $keyvar;
                            $newvideomodel->update();
                            
                            $keyvar++;
                        }        
                    }
                }
                
            if (!empty($insertedcntryary)) {
                        $insertedcntrystring = implode(",", $insertedcntryary);
                        Categorygeographic::deleteAll('CategID = :id  and CountryID NOT IN (:countryid)', ['id' => $id, ':countryid' => $insertedcntrystring]);
                foreach ($insertedcntryary as $insertedcntry) {
                        $categormodel = Categorygeographic::find()->where('CategID = :id  and CountryID = :cntryid', ['id' => $id, 'cntryid' => $insertedcntry])->one();
                    if (empty($categormodel)) {
                        $Categorygeographic = new Categorygeographic();
                        $Categorygeographic->CategID = $model->ID;
                        $Categorygeographic->CountryID = $insertedcntry;
                        $Categorygeographic->save();
                    }
                }
            }
                        else{
              Categorygeographic::deleteAll('CategID = :id ', ['id' => $id]);  
            }
                                $arrayvideoin=json_decode(Yii::$app->request->post('arrayvideoin'),true);
                    $arrayvideoincount=count($arrayvideoin);
            if(!empty($arrayvideoin)){
             $lastIndex = 0;
            $displayIndexModal= new \backend\models\Videocategory();
            $countIndex = $displayIndexModal->findAll(array('CategID' => $id));
            if(!empty($countIndex))
            {
                $lastIndex = count($countIndex);
            }
            
            foreach($arrayvideoin as $arrayvideoinlist){
                    $categvideomodel = Videocategory::find()->where('CategID = :id  and VideoID = :videoid', ['id'=>$id,'videoid'=>$arrayvideoinlist])->one();
            if(empty($categvideomodel)){
                    /*$displayIndexModal= new \backend\models\Videocategory();
                    $countIndex = $displayIndexModal->findAll(array('CategID' => $id));
                    $lastIndex = count($countIndex);
                    if($lastIndex > 0 )
                    {
                       $lastIndex = $lastIndex - 1 ;
                    }*/
                    $Videocategory = new Videocategory();
                    $Videocategory->CategID = $id;
                    $Videocategory->VideoID = $arrayvideoinlist;
                    $Videocategory->DisplayIndex = $lastIndex;
                    $Videocategory->save();
                   /* $newvideomodel = \backend\models\Video::find()->where(['ID' => $arrayvideoinlist])->one(); 
                    $newvideomodel->DisplayIndex = $lastIndex;
                    $newvideomodel->save();
                    $lastIndex++;*/
                     if(!empty($countIndex))
                    {
                         $lastIndex--;
                    }else
                    {
                         $lastIndex++;
                    }
                   
                    }  
                }
            }
                    $arrayvideoout=json_decode(Yii::$app->request->post('arrayvideoout'),true);
            if(!empty($arrayvideoout)) {
            foreach($arrayvideoout as $arrayvideooutlist){
                
                     $catevideomodel = Videocategory::find()->where('CategID = :id  and VideoID = :videoid', ['id'=>$id,'videoid'=>$arrayvideooutlist])->one();   
            if(!empty($catevideomodel))
            {
                    $catevideomodel->delete();
                 } 
            }
        }
                        Yii::$app->session->setFlash('success', 'Talking Points  has been Updated successfully');
                        return $this->redirect('index');
        } else {
                        return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing TalkingPoints model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
         $this->findModel($id)->delete();
         Yii::$app->session->setFlash('success', 'Talking Points  has been deleted successfully');
         return $this->redirect(['index']);
    }
    /**
     * Remove Video from TalkingPoints
     * */
    public function actionVideosearch()
    {
        $var_one='1';
        $videotitle=Yii::$app->request->post('videotitle');    
        $categid=Yii::$app->request->post('categid');         
        
        /*- Get Video Not In Category-*/
        $sql =  'CALL Admin_video_category (:id,:IDType,:videotitle,"","","")';              
        $command = Yii::$app->db->createCommand($sql);
        $command->bindParam(":id", $categid);
        $command->bindParam(":IDType",$var_one);
        $command->bindParam(":videotitle", $videotitle);
        $videodetils = $command->queryAll();
        
        if(!empty($videodetils))
        {
            foreach($videodetils as $videodetilssub)
            {
                echo '<div class="col-lg-3 col-sm-4 col-xs-6"><input type="checkbox" name="videothumb" class="videothumbchkbox" value="'.$videodetilssub['ID'].'"><img class="thumbnail img-responsive" src="'. ImagesUrl($videodetilssub).'"><p>'.$videodetilssub['Title'].'</p></div>';    
            }
        }
        else{
            echo 'No Records Found';
        }
    }

    /**
     * Remove Video from TalkingPoints
     * */
    public function actionRemove() {
                        $infoary = Yii::$app->request->post('info');
                        $categoryid = Yii::$app->request->post('category');
                        if (!empty($infoary)) {
                            foreach ($infoary as $vidoid) {
                                Videocategory::deleteAll('CategID = :categid AND VideoID=:videoid', [':categid' => $categoryid, ':videoid' => $vidoid]);
                            }
                        }
                        Yii::$app->session->setFlash('success', 'Video Hase been removed Successfuilly');
                        return $this->redirect(['view', 'id' => $categoryid]);
    }

    /**
     * Finds the TalkingPoints model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TalkingPoints the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = TalkingPoints::find()->where(['ID' => $id, 'Type' => 3])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
