<?php

namespace backend\controllers;

use Yii;
use backend\models\Playlist;
use backend\models\PlaylistSearch;
use yii\web\Controller;
use backend\models\Playlistgeographic;
use backend\models\Playlistvideo;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\Url;

/**
 * PlaylistController implements the CRUD actions for Playlist model.
 */
class PlaylistController extends Controller
{
    /*public function behaviors()
    {
        return [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['view','addvideos','videosearch','remove','update','create','index','videosearchforaccompanying','videosearchplaylist','videosearchforadvertisement','videosearchforrelatedvideo','videosearchforthumbimages','videosearchforfullvideo'],
                            'roles' => ['@'],
                        ],
                    ],
                ],
        ];
    }*/

    public function beforeAction($action)
    {
        if (
            \Yii::$app->getUser()->isGuest &&
            \Yii::$app->getRequest()->url !== Url::to(\Yii::$app->getUser()->loginUrl)
        ) {
            \Yii::$app->getResponse()->redirect(\Yii::$app->getUser()->loginUrl);
        }
        return parent::beforeAction($action);
    }

    /**
     * Lists all Playlist models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PlaylistSearch();
        if (isset($_GET['PlaylistSearch'])) {
            $searchModel->attributes = $_GET['PlaylistSearch'];
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Playlist model.
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
     * Creates a new Playlist model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $country  = array();
        $var_two = '2';
        $query = new Query;
        $query->select('ID, Name')->from('country');
        // build and execute the query
        $Countrylist = $query->all();
        /*- Get Video Not In Category-*/
        $sql =  'CALL Admin_video_category ("",:IDType,"","","","")';
        $command = Yii::$app->db->createCommand($sql);
        $command->bindParam(":IDType", $var_two);
        $outlist = $command->queryAll();
        $model = new Playlist();
        $sql =  'SELECT GetUniqueCode() as unique_key';
        $command = Yii::$app->db->createCommand($sql);
        $functionvlary = $command->queryAll();
        $unique_Id = $functionvlary[0]['unique_key'];

        if ($model->load(Yii::$app->request->post())) {
            $arrayvideoin = json_decode(Yii::$app->request->post('arrayvideoin'), true);
            $arrayvideoincount = count($arrayvideoin);
            if ($model->validate()) {
                if (isset($_FILES['Playlist']['name']['VideoThumb']) && $_FILES['Playlist']['name']['VideoThumb'] != '') {

                    $filesTempName = $_FILES['Playlist']['tmp_name']['VideoThumb'];
                    $fileName = $_FILES['Playlist']['name']['VideoThumb'];
                    $ext = pathinfo($fileName, PATHINFO_EXTENSION);
                    $image = $actualImageName = PREFIX_PLAYLIST . $unique_Id . '.' . $ext;
                    $commonthumb = '../../upload/images/' . $actualImageName;
                    $createthumb = '../../upload/images/thumb/' . $actualImageName;
                    $createmedium = '../../upload/images/medium/' . $actualImageName;
                    move_uploaded_file($filesTempName, $commonthumb);
                    /*===============Resize to Medium =================*/
                    $mediumimage = Yii::$app->image->load($commonthumb);
                    list($width, $height) = explode('x', SIZE_MEDIUM);
                    $mediumimage->resize($width, $height, \yii\image\drivers\Image::NONE);
                    $mediumimage->save($createmedium);

                    /*===============Resize to Thumb =================*/
                    $thumbimage = Yii::$app->image->load($commonthumb);
                    list($width, $height) = explode('x', SIZE_THUMB);
                    $thumbimage->resize($width, $height, \yii\image\drivers\Image::NONE);
                    $thumbimage->save($createthumb);

                    /*===============Upload to Original =================*/
                    \S3::putObjectFile($commonthumb, S3BUCKET, BUCKET_FOLDER . '/' . PLAYLIST . '/' . $image, \S3::ACL_PUBLIC_READ);
                    /*===============Upload to Medium =================*/
                    \S3::putObjectFile($createmedium, S3BUCKET, BUCKET_FOLDER . '/' . PLAYLIST . '/' . THUMBNAILS_MEDIUM . '/' . $image, \S3::ACL_PUBLIC_READ);
                    /*===============Upload to Thumb =================*/
                    \S3::putObjectFile($createthumb, S3BUCKET, BUCKET_FOLDER . '/' . PLAYLIST . '/' . THUMBNAILS_THUMB . '/' . $image, \S3::ACL_PUBLIC_READ);
                    // unlink($commonthumb);
                    // unlink($createmedium);
                    // unlink($createthumb);
                } else {
                    $model->addError('VideoThumb', 'Please Upload Image');
                    return $this->render('create', [
                        'model' => $model,
                        'countrylist' => $Countrylist,
                        'videooutlist' => $outlist,
                        'countrydata' => $country
                    ]);
                }
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'countrylist' => $Countrylist,
                    'videooutlist' => $outlist,
                    'countrydata' => $country
                ]);
            }
            // if(\S3::putObjectFile($createthumb,S3BUCKET,PLAYLIST.'/'.$actualImageName, \S3::ACL_PUBLIC_READ)) {
            if (
                /*===============Upload to Original =================*/
                \S3::putObjectFile($commonthumb, S3BUCKET, BUCKET_FOLDER . '/' . PLAYLIST . '/' . $image, \S3::ACL_PUBLIC_READ) &&
                /*===============Upload to Medium =================*/
                \S3::putObjectFile($createmedium, S3BUCKET, BUCKET_FOLDER . '/' . PLAYLIST . '/' . THUMBNAILS_MEDIUM . '/' . $image, \S3::ACL_PUBLIC_READ) &&
                /*===============Upload to Thumb =================*/
                \S3::putObjectFile($createthumb, S3BUCKET, BUCKET_FOLDER . '/' . PLAYLIST . '/' . THUMBNAILS_THUMB . '/' . $image, \S3::ACL_PUBLIC_READ)
            ) {


                // unlink($createthumb);
                $model->VideoThumb  = $actualImageName;
                $model->NoOfVideos  = $arrayvideoincount;
                $model->ScheduledRelease = ConvertDateToUTC(date("Y-m-d H:i:s", strtotime($_POST['Playlist']['ScheduledRelease'])));
                $model->CreatedBy = Yii::$app->user->identity->UserID;
                $model->save();
                $insertedcntryary = Yii::$app->request->post('Country');

                if (!empty($insertedcntryary)) {

                    foreach ($insertedcntryary as $insertedcntry) {

                        $Playlistgeographic = new Playlistgeographic();
                        $Playlistgeographic->PlayListID = $model->ID;
                        $Playlistgeographic->CountryID = $insertedcntry;
                        $Playlistgeographic->CreatedBy = Yii::$app->user->identity->UserID;
                        $Playlistgeographic->save();
                    }
                }
                if (!empty($arrayvideoin)) {
                    $videoorder = 0;
                    foreach ($arrayvideoin as $arrayvideoinsub) {

                        $Playlistvideo = new Playlistvideo();
                        $Playlistvideo->PlayListID = $model->ID;
                        $Playlistvideo->DisplayIndex = $videoorder;
                        $Playlistvideo->VideoID = $arrayvideoinsub;
                        $Playlistvideo->CreatedBy = Yii::$app->user->identity->UserID;
                        $Playlistvideo->save();
                        $videoorder++;
                    }
                }
            }
            /**  start : Add or update langauge translation fields **/
            if (isset($_POST['languageFields'])) {
                $_POST['languageFields']['from_table_id'] = $model->ID;
                \backend\models\LangaugeFields::SaveLanguageFields($_POST['languageFields']);
            }
            /**  stop : Add or update langauge translation fields **/
            Yii::$app->session->setFlash('success', 'Playlist has been added successfully');
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'countrylist' => $Countrylist,
                'videooutlist' => $outlist,
                'countrydata' => $country
            ]);
        }
    }
    /**
     * Updates an existing Playlist model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        //$modeldemopllist = Playlistvideo::find()
        // ->joinWith('video', false, 'INNER JOIN')
        // ->all();
        // 


        $modelCountry = new \backend\models\Playlistgeographic();
        $countryData = $modelCountry->findAll(array('PlaylistId' => $id));
        $country  = array();
        foreach ($countryData as $key => $value) {
            $country[] = $value->CountryID;
        }
        $var_one = '2';
        $sort_var = 'vc.DisplayIndex desc';
        $sort = 'v.Created desc';
        /*- Get Video From  Category-*/
        $sql =  'CALL Admin_video_category (:id,:IDType,"",:sort,"","")';
        $command = Yii::$app->db->createCommand($sql);
        $command->bindParam(":id", $id);
        $command->bindParam(":IDType", $var_one);
        $command->bindParam(":sort", $sort);
        $outlist = $command->queryAll();
        $sql =  'CALL Admin_Category_Topic_PlayList_Video_List (:id,"",:IDType,:sort,"","")';
        $command = Yii::$app->db->createCommand($sql);
        $command->bindParam(":id", $id);
        $command->bindParam(":IDType", $var_one);
        $command->bindParam(":sort", $sort_var);

        $inlist = $command->queryAll();
        if (!empty($inlist)) {
            foreach ($inlist as $vinlist) {
                $oldorderary[$vinlist['ID']] = $vinlist['plylstorder'];
            }
        }

        $model = $this->findModel($id);
        $oldimagename = $model->VideoThumb;
        $model->ScheduledRelease = ConvertDateTolocaltime($model->ScheduledRelease);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $newarrayorder = json_decode(Yii::$app->request->post('newarrayorder'), true);
                if (!empty($newarrayorder)) {
                    if (!empty($oldorderary)) {
                        $keyvar = 0;
                        foreach ($oldorderary as $ordrkey => $oldorderarysub) {
                            $neworderary[$newarrayorder[$keyvar]] = $oldorderarysub;
                            $keyvar++;
                        }
                    }
                }
                $sql =  'SELECT GetUniqueCode() as unique_key';
                $command = Yii::$app->db->createCommand($sql);
                $functionvlary = $command->queryAll();
                $unique_Id = $functionvlary[0]['unique_key'];
                $model->VideoThumb = $oldimagename;

                if (isset($_FILES) && !empty($_FILES)) {
                    if (isset($_FILES['Playlist']['name']['VideoThumb']) && $_FILES['Playlist']['name']['VideoThumb'] != '') {

                        $filesTempName = $_FILES['Playlist']['tmp_name']['VideoThumb'];
                        $fileName = $_FILES['Playlist']['name']['VideoThumb'];
                        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
                        $image = $actualImageName = PREFIX_PLAYLIST . $unique_Id . '.' . $ext;
                        $commonthumb = '../../upload/images/' . $actualImageName;
                        $createthumb = '../../upload/images/thumb/' . $actualImageName;
                        $createmedium = '../../upload/images/medium/' . $actualImageName;
                        move_uploaded_file($filesTempName, $commonthumb);
                        /*===============Resize to Medium =================*/
                        $mediumimage = Yii::$app->image->load($commonthumb);
                        list($width, $height) = explode('x', SIZE_MEDIUM);
                        $mediumimage->resize($width, $height, \yii\image\drivers\Image::NONE);
                        $mediumimage->save($createmedium);

                        /*===============Resize to Thumb =================*/
                        $thumbimage = Yii::$app->image->load($commonthumb);
                        list($width, $height) = explode('x', SIZE_THUMB);
                        $thumbimage->resize($width, $height, \yii\image\drivers\Image::NONE);
                        $thumbimage->save($createthumb);

                        /*===============Upload to Original =================*/
                        \S3::putObjectFile($commonthumb, S3BUCKET, BUCKET_FOLDER . '/' . PLAYLIST . '/' . $image, \S3::ACL_PUBLIC_READ);
                        /*===============Upload to Medium =================*/
                        \S3::putObjectFile($createmedium, S3BUCKET, BUCKET_FOLDER . '/' . PLAYLIST . '/' . THUMBNAILS_MEDIUM . '/' . $image, \S3::ACL_PUBLIC_READ);
                        /*===============Upload to Thumb =================*/
                        \S3::putObjectFile($createthumb, S3BUCKET, BUCKET_FOLDER . '/' . PLAYLIST . '/' . THUMBNAILS_THUMB . '/' . $image, \S3::ACL_PUBLIC_READ);
                        // unlink($commonthumb);
                        // unlink($createmedium);
                        // unlink($createthumb);

                        $model->VideoThumb  = $actualImageName;
                    } else {
                        $model->VideoThumb = $oldimagename;
                    }
                }
                $model->ScheduledRelease = ConvertDateToUTC(date("Y-m-d H:i:s", strtotime($_POST['Playlist']['ScheduledRelease'])));
                $model->Updated = date("Y-m-d H:i:s");
                $model->UpdatedBy = Yii::$app->user->identity->UserID;
                if (!empty($neworderary)) {
                    foreach ($neworderary as $newordkey => $neworderarysub) {
                        $newplaylistvideomodel = Playlistvideo::find()->where('PlayListID = :id  and VideoID = :videoid', ['id' => $id, 'videoid' => $newordkey])->one();
                        if (!empty($newplaylistvideomodel)) {
                            $newplaylistvideomodel->DisplayIndex = $neworderarysub;
                            $newplaylistvideomodel->update();
                        }
                    }
                }
                $arrayvideoout = json_decode(Yii::$app->request->post('arrayvideoout'), true);
                if (!empty($arrayvideoout)) {
                    foreach ($arrayvideoout as $arrayvideooutlist) {

                        $playlistvideomodel = Playlistvideo::find()->where('PlayListID = :id  and VideoID = :videoid', ['id' => $id, 'videoid' => $arrayvideooutlist])->one();
                        if (!empty($playlistvideomodel)) {
                            $playlistvideomodel->delete();
                        }
                    }
                }
                $arrayvideoin = json_decode(Yii::$app->request->post('arrayvideoin'), true);
                $arrayvideoincount = count($arrayvideoin);
                if (!empty($arrayvideoin)) {
                    $playlistmaxvalue = Playlistvideo::find()->select(' MAX(DisplayIndex) as maxvalue12 ')->where('PlayListID = :id', ['id' => $id])->asArray()->one();
                    $playlistmaxvaluevar = 0;
                    if (!empty($playlistmaxvalue)) {
                        $playlistmaxvaluevar = $playlistmaxvalue['maxvalue12'] + 1;
                    }
                    foreach ($arrayvideoin as $arrayvideoinlist) {
                        $playlistvideomodel = Playlistvideo::find()->where('PlayListID = :id  and VideoID = :videoid', ['id' => $id, 'videoid' => $arrayvideoinlist])->one();
                        if (empty($playlistvideomodel)) {
                            $Playlistvideo = new Playlistvideo();
                            $Playlistvideo->PlayListID = $model->ID;
                            $Playlistvideo->DisplayIndex = $playlistmaxvaluevar;
                            $Playlistvideo->VideoID = $arrayvideoinlist;
                            $Playlistvideo->CreatedBy = Yii::$app->user->identity->UserID;
                            $Playlistvideo->save();
                            $playlistmaxvaluevar++;
                        }
                    }
                }
                if (!empty($arrayvideoin) || !empty($arrayvideoout)) {
                    $zerovar = '0';
                    //$videoinplay=Playlistvideo::find()->where('PlayListID = :id ', ['id'=>$id])->all();
                    //$videoplaycount= count($videoinplay);
                    $querydemo = new Query;
                    $querydemo->select(['video.ID'])
                        ->from('playlistvideo')
                        ->join(
                            'INNER JOIN',
                            'video',
                            'video.ID =playlistvideo.VideoID'
                        )
                        ->where('playlistvideo.PlaylistID=' . $id . ' and video.Status=1');
                    $commanddemo = $querydemo->createCommand();
                    $modeldemopllist = $commanddemo->queryAll();
                    $videoplaycount = count($modeldemopllist);
                    $model->NoOfVideos = $videoplaycount;
                }
                $model->save();
                $insertedcntryary = Yii::$app->request->post('Country');
                if (!empty($insertedcntryary)) {
                    $insertedcntrystring = implode(",", $insertedcntryary);
                    Playlistgeographic::deleteAll('PlayListID = :id  and CountryID NOT IN (:countryid)', ['id' => $id, ':countryid' => $insertedcntrystring]);
                    foreach ($insertedcntryary as $insertedcntry) {

                        $playlistmodel = Playlistgeographic::find()->where('PlayListID = :id  and CountryID = :cntryid', ['id' => $id, 'cntryid' => $insertedcntry])->one();
                        if (empty($playlistmodel)) {
                            $Playlistgeographic = new Playlistgeographic();
                            $Playlistgeographic->Updated = ConvertDateToUTC(date("Y-m-d H:i:s"));
                            $Playlistgeographic->UpdatedBy = Yii::$app->user->identity->UserID;
                            $Playlistgeographic->PlayListID = $model->ID;
                            $Playlistgeographic->CountryID = $insertedcntry;
                            $Playlistgeographic->save();
                        }
                    }
                } else {
                    Playlistgeographic::deleteAll('PlayListID = :id ', ['id' => $id]);
                }
            }
            /**  start : Add or update langauge translation fields **/
            if (isset($_POST['languageFields'])) {
                $_POST['languageFields']['from_table_id'] = $model->ID;
                \backend\models\LangaugeFields::SaveLanguageFields($_POST['languageFields']);
            }
            /**  stop : Add or update langauge translation fields **/

            Yii::$app->session->setFlash('success', 'Playlist  has been Updated successfully');
            return $this->redirect('index');
        } else {
            return $this->render('update', [
                'model' => $model,
                'videoinlist' => $inlist,
                'videooutlist' => $outlist,
                'Countrydata' => $country
            ]);
        }
    }
    /**
     * Deletes an existing Playlist model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();
        Yii::$app->session->setFlash('success', 'Playlist has been deleted successfully!');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Playlist model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Playlist the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {

        if (($model = Playlist::findOne($id)) !== null) {

            return $model;
        } else {

            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    /**
     * Displays a Video by title.
     */
    public function actionVideosearch()
    {
        $var_two = '2';
        $videotitle = Yii::$app->request->post('videotitle');
        $categid = Yii::$app->request->post('categid');
        /*- Get Video Not In Category-*/
        $sql =  'CALL Admin_video_category (:id,:IDType,:videotitle,"","","")';
        $command = Yii::$app->db->createCommand($sql);
        $command->bindParam(":id", $categid);
        $command->bindParam(":IDType", $var_two);
        $command->bindParam(":videotitle", $videotitle);
        $videodetils = $command->queryAll();
        if (!empty($videodetils)) {
            foreach ($videodetils as $videodetilssub) {
                echo '<div class="col-lg-3 col-sm-4 col-xs-6"><input type="radio" name="videothumb" class="videothumbchkbox" value="' . $videodetilssub['ID'] . '"><img class="thumbnail img-responsive" src="' . ImagesUrl($videodetilssub) . '"><p>' . $videodetilssub['Title'] . '</p></div>';
            }
        } else {
            echo 'No Records Found';
        }
    }
    /**
     * Displays a Video by title.
     */
    public function actionVideosearchplaylist()
    {
        $var_two = '2';
        $videotitle = Yii::$app->request->post('videotitle');
        $categid = Yii::$app->request->post('categid');
        /*- Get Video Not In Category-*/
        $sql =  'CALL Admin_video_category (:id,:IDType,:videotitle,"","","")';
        $command = Yii::$app->db->createCommand($sql);
        $command->bindParam(":id", $categid);
        $command->bindParam(":IDType", $var_two);
        $command->bindParam(":videotitle", $videotitle);
        $videodetils = $command->queryAll();
        if (!empty($videodetils)) {
            foreach ($videodetils as $videodetilssub) {
                echo '<div class="col-lg-3 col-sm-4 col-xs-6"><input type="checkbox" name="videothumb" class="videothumbchkbox" value="' . $videodetilssub['ID'] . '"><img class="thumbnail img-responsive" src="' . ImagesUrl($videodetilssub) . '"><p>' . $videodetilssub['Title'] . '</p></div>';
            }
        } else {
            echo 'No Records Found';
        }
    }

    public function actionVideosearchforaccompanying()
    {
        $var_two = '2';
        $videotitle = Yii::$app->request->post('videotitle');
        $categid = Yii::$app->request->post('categid');
        /*- Get Video Not In Category-*/
        $sql =  'CALL Admin_video_category (:id,:IDType,:videotitle,"","","")';
        $command = Yii::$app->db->createCommand($sql);
        $command->bindParam(":id", $categid);
        $command->bindParam(":IDType", $var_two);
        $command->bindParam(":videotitle", $videotitle);
        $videodetils = $command->queryAll();
        if (!empty($videodetils)) {
            foreach ($videodetils as $videodetilssub) {
                echo '<div class="col-lg-3 col-sm-4 col-xs-6"><input type="checkbox" name="videoaccompanying" class="videothumbchkbox" value="' . $videodetilssub['ID'] . '"><img class="thumbnail img-responsive" src="' . ImagesUrl($videodetilssub) . '"><p>' . $videodetilssub['Title'] . '</p></div>';
            }
        } else {
            echo 'No Records Found';
        }
    }

    public function actionVideosearchforadvertisement()
    {
        $contenttitle = Yii::$app->request->post('content');
        /*- Get Video Not In Category-*/
        $sql =  'CALL Admin_advertisement_video_list(:content,null,null,null,null)';
        $command = Yii::$app->db->createCommand($sql);
        $command->bindParam(":content", ltrim($contenttitle));
        $videodetils = $command->queryAll();
        if (!empty($videodetils)) {
            foreach ($videodetils as $videolistsub) {
                echo '<div class="col-lg-3 col-sm-4 col-xs-6"><input type="checkbox" name="videoadvertisement" class="advertisementVideo" value="' . $videolistsub['ID'] . '"><img class="thumbnail img-responsive" src="' . S3_THUMB_CLOUDFRONT . '/' . ADVERISEMENT . '/' . $videolistsub['ImagePath'] . '"> <p>' . $videolistsub['Content'] . '</p></div>';
            }
        } else {
            echo 'No Records Found';
        }
    }
    /**
     * Serach video for related videos
     */
    public function actionVideosearchforrelatedvideo()
    {
        $contenttitle = Yii::$app->request->post('content');
        $videoId = Yii::$app->request->post('videoId');
        /*- Get filter videos-*/
        $sql =  "SELECT i.*,v.Title FROM `images` as i left join video as v ON ID = VideoID where v.Title like '%$contenttitle%' && v.ID != '" . $videoId . "' && i.IsThumb = 1 && i.ImageType = 1";
        $command = Yii::$app->db->createCommand($sql);
        $videodetils = $command->queryAll();
        if (!empty($videodetils)) {
            foreach ($videodetils as $videolistsub) {
                echo '<div class="col-lg-3 col-sm-4 col-xs-6"><input type="checkbox" name="videothumb" class="videothumbchkbox" value="' . $videolistsub['VideoID'] . '"><img class="thumbnail img-responsive" src="' . ImagesUrl($videolistsub) . '"> <p>' . $videolistsub['Title'] . '</p></div>';
            }
        } else {
            echo 'No Records Found';
        }
    }

    /**
     * Serach video for related videos
     */
    public function actionVideosearchforfullvideo()
    {
        $contenttitle = Yii::$app->request->post('content');
        $videoId = Yii::$app->request->post('videoId');
        /*- Get filter videos-*/
        $sql =  "SELECT i.*,v.Title FROM `images` as i left join video as v ON ID = VideoID where v.Title like '%$contenttitle%' && v.ID != '" . $videoId . "' && i.IsThumb = 1 && i.ImageType = 1";
        $command = Yii::$app->db->createCommand($sql);
        $videodetils = $command->queryAll();
        if (!empty($videodetils)) {
            foreach ($videodetils as $videolistsub) {
                echo '<div class="col-lg-3 col-sm-4 col-xs-6"><input type="radio" name="fullvideo" class="videothumbradio" value="' . $videolistsub['VideoID'] . '"><img class="thumbnail img-responsive" src="' . ImagesUrl($videolistsub) . '"> <p>' . $videolistsub['Title'] . '</p></div>';
            }
        } else {
            echo 'No Records Found';
        }
    }

    /**
     * Serach video for Video thumb images
     */
    public function actionVideosearchforthumbimages()
    {
        $contenttitle = Yii::$app->request->post('content');
        $videoId = Yii::$app->request->post('videoId');
        /*- Get filter videos-*/
        $sql =  'CALL Admin_Thumbnail_List (:content,NULL,NULL,NULL)';
        $command = Yii::$app->db->createCommand($sql);
        $command->bindParam(":content", ltrim($contenttitle));
        $ThumbImages = $command->query();
        if (!empty($ThumbImages)) {
            foreach ($ThumbImages as $videolistsub) {
                echo '<div class="col-lg-3 col-sm-4 col-xs-6"><input type="checkbox" name="videothumb" class="videothumbimagechkbox" value="' . $videolistsub['VideoID'] . '"><img class="thumbnail img-responsive" src="' . ImagesUrl($videolistsub) . '"> <p>' . $videolistsub['Title'] . '</p></div>';
            }
        } else {
            echo 'No Records Found';
        }
    }
}
