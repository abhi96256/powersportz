<?php

namespace backend\controllers;

use Yii;
use backend\models\Video;
use backend\models\Playlist;
use backend\models\Category;
use backend\models\VideoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\RelatedVideos;
use backend\models\VideoThumbnailImages;
use backend\models\Images;
use Aws\S3\S3Client;

//require( 'C:/xampp/htdocs/Power_Sportz/backend/components/twitteroauth.php');
/**
 * VideoController implements the CRUD actions for Video model.
 */
class VideoController extends \backend\components\BackendController {

    /**
     * Lists all Video models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new VideoSearch();
        if (isset($_GET['VideoSearch'])) {
            $searchModel->attributes = $_GET['VideoSearch'];
        }
        return $this->render('index', [
          'model' => $searchModel,
      ]);
    }

    public function actionSubscriberUplodedVideoIndex() {


        $searchModel = new \backend\models\Member();

        //if (isset($_GET['id'])) {
        if (isset($_GET['Member'])) {
            $searchModel->attributes = $_GET['Member'];
            //$searchModel->attributes = $_GET['id'];
        }
        //}

        return $this->render('subscriber_uploded_video_index', [
          'model' => $searchModel,
            // 'dataProvider' => $dataProvider,
      ]);
    }

    /**
     * Displays a single Video model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
          'model' => $this->findModel($id),
      ]);
    }

    /**
     * Creates a new Video model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Video();
        $model->scenario = 'create';
        $playlist = array();
        $topics = array();
        $country = array();
        $autherName = '';
        if (!empty($_GET['svid'])) {
            if (($VideouplodbysubscribersModel = \backend\models\Videouploadbysubscribers::find()->with(['member.user' => function($q) {
              return $q->select(['AES_DECRYPT(UserName,PASSWORD("' . AESKEY . '")) as UserName']);
          }])->where(['ID' => $_GET['svid']])->asArray()->One()) !== null) {
                $model->Title = $VideouplodbysubscribersModel['VideoTitle'];
                // $backednPath = str_replace('backend','frontend',\Yii::$app->basePath);
                //$path = Yii::getAlias('@web').'/web/uploads/'.$VideouplodbysubscribersModel['VideoFile'];

                $model->VideoURL = S3_SUBSCRIBER_VIDEO_BUCKETABSOLUTE_PATH . $VideouplodbysubscribersModel['VideoFile'];
                //$model->VideoURL  = "https://testvideoin.s3.amazonaws.com/Videos/Videos_31_1446726923657.mp4";
                $model->CreatedBy = $VideouplodbysubscribersModel['member']['user']['UserName'];
                if (isset($VideouplodbysubscribersModel['member']['FirstName']) && isset($VideouplodbysubscribersModel['member']['LastName']))
                    $autherName = $VideouplodbysubscribersModel['member']['FirstName'] . ' ' . $VideouplodbysubscribersModel['member']['LastName'];
            }
        }

        //Get related video list (selected/recent; full search via typeahead)
        $VideosList = $this->getRelatedVideoThumbListForForm(0, '');

        //Get video thumbnail image list (recent + search via typeahead)
        $VideoImageList = $this->getLibraryThumbnailListForForm('');
        $isShowStatus = true;
        if (($member = \backend\models\Member::find()->where('parent_role_user_id != "" && UserID = "' . YIi::$app->user->id . '"')->asArray()->One()) !== null) {
            $model->Status = 4;
            $isShowStatus = false;
        }



        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
              'model' => $model,
              'playlistData' => $playlist,
              'topicsData' => $topics,
              'countryData' => $country,
              'videosList' => $VideosList,
              'isShowStatus' => $isShowStatus,
              'VideoThumbImageList' => $VideoImageList,
              'autherName' => $autherName
          ]);
        }
    }

    /**
     * Updates an existing Video model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $autherName = '';
        $model = \backend\models\Video::find()->with(['userName'])->where(['id' => $id])->One();
        //$model = $this->findModel($id);
        $model->scenario = 'update';
        // Broken zero-dates break DateTimePicker + client validation (Update appears to do nothing)
        if (empty($model->PublishDate) || strpos((string) $model->PublishDate, '0000-00-00') === 0) {
            $model->PublishDate = date('Y-m-d h:i A');
        } else {
            try {
                $model->PublishDate = ConvertDateTolocaltime($model->PublishDate);
            } catch (\Exception $e) {
                $model->PublishDate = date('Y-m-d h:i A');
            }
        }

        $modelImages = new \backend\models\Images();
        $images = $modelImages->findAll(array('VideoID' => $id));
        $smallImage = '';
        if (isset($images[0]->ImageName) && $images[0]->ImageName != '')
            $smallImage = $images[0]->ImageName;

        $modelPlaylist = new \backend\models\Playlistvideo();
        $playlistData = $modelPlaylist->findAll(array('VideoID' => $id));

        $modelTopics = new \backend\models\Videocategory();
        $topicsData = $modelTopics->findAll(array('VideoID' => $id));

        $modelCountry = new \backend\models\Videogeographic();
        $countryData = $modelCountry->findAll(array('VideoID' => $id));

        // Auto-generate default thumbnails from source video when stream is ready
        if (!empty($model->VideoStreamURL) || !empty($model->VideoURL)) {
            $this->ensureGeneratedThumbnails($model);
        }

        //Get all default thumbnail images 
        $modelVideoList = new \backend\models\Images();
        $DefaultGeneratedImages = $modelVideoList->find()->where("ImageType = 1 && VideoID = '" . $id . "'")->asArray()->all();

        // Reliable load (GROUP_CONCAT via ActiveRecord One() is flaky)
        $thumbIds = Yii::$app->db->createCommand(
            "SELECT GROUP_CONCAT(images_id) FROM video_thumbnail_images WHERE video_id = :id AND type = '1'"
        )->bindValue(':id', (int) $id)->queryScalar();
        $model->IsthumbnailVideoId = !empty($thumbIds) ? $thumbIds : '';

        $defaultThumbIds = Yii::$app->db->createCommand(
            "SELECT GROUP_CONCAT(images_id) FROM video_thumbnail_images WHERE video_id = :id AND type = '0'"
        )->bindValue(':id', (int) $id)->queryScalar();
        $model->IsDefaultthumbnailVideoId = !empty($defaultThumbIds) ? $defaultThumbIds : '';

        $relatedIds = Yii::$app->db->createCommand(
            "SELECT GROUP_CONCAT(related_video) FROM related_videos WHERE video_id = :id"
        )->bindValue(':id', (int) $id)->queryScalar();
        $model->IsRelatedVideoId = !empty($relatedIds) ? $relatedIds : '';

        $playlist = array();
        $topics = array();
        $country = array();

        // Library thumbs: selected + latest (full catalog via search typeahead)
        $VideoImageList = $this->getLibraryThumbnailListForForm($model->IsthumbnailVideoId);

        // Related videos: selected + latest active (full catalog via search typeahead)
        $VideosList = $this->getRelatedVideoThumbListForForm($id, $model->IsRelatedVideoId);

        $isShowStatus = true;
        if (Yii::$app->user->identity->UserType != 1) {
            if (($member = \backend\models\Member::find()->where("UserID = '" . $model->CreatedBy . "'  && parent_role_user_id != '" . Yii::$app->user->id . "'")->asArray()->One()) !== null) {
                $isShowStatus = false;
            }
        }

        foreach ($playlistData as $key => $value) {
            $playlist[] = $value->PlayListID;
        }
        foreach ($topicsData as $key => $value) {
            $topics[] = $value->CategID;
        }
        foreach ($countryData as $key => $value) {
            $country[] = $value->CountryID;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ID]);
        }
        // changed by Hiren dave on 23-06-2017 to append m3u8 on url [Shailesh has suggested]
        if (!empty($model->VideoStreamURL))
            $model->VideoStreamURL = $model->VideoStreamURL . '.m3u8';
        return $this->render('update', [
          'model' => $model,
          'playlistData' => $playlist,
          'topicsData' => $topics,
          'countryData' => $country,
          'videosList' => $VideosList,
          'images' => $images,
          'isShowStatus' => $isShowStatus,
          'VideoThumbImageList' => $VideoImageList,
          'DefaultGeneratedImages' => $DefaultGeneratedImages,
          'autherName' => $autherName
      ]);
    }

    public function actionCreateajax() {

        $model = new Video();
        $model->scenario = 'create';
        if ($model->load(Yii::$app->request->post())) {
            // $backednPath = str_replace('backend','frontend',\Yii::$app->basePath);
            // echo $backednPath.'/web/uploads/'.$model->VideoURL;die;
            //Video::upload_image(base64_encode(file_get_contents($backednPath.'/web/uploads/'.$model->VideoURL)));

            if ($model->validate()) {
                $model->CreatedBy = Yii::$app->user->identity->UserID;
                $model->slug = \backend\models\Video::createSlug($model->Title);
                $playlist = array();
                $topics = array();
                $category = array();
                $country = array();
                if (isset($_POST['Video']['Playlist'])) {
                    $playlist = $_POST['Video']['Playlist'];
                }
                if (isset($_POST['Video']['Topics'])) {
                    $topics = $_POST['Video']['Topics'];
                }
                if (isset($_POST['Video']['Category'])) {
                    $category = $_POST['Video']['Category'];
                }
                if (isset($_POST['Video']['CountryRestrictions'])) {
                    $country = $_POST['Video']['CountryRestrictions'];
                }
                //$model->PublishDate = date("Y-m-d H:i:s",strtotime($_POST['Video']['PublishDate']));
                $model->PublishDate = $this->normalizePublishDateUtc(isset($_POST['Video']['PublishDate']) ? $_POST['Video']['PublishDate'] : '');
                $model->save(false);
                $videoID = Yii::$app->db->getLastInsertID();

                $videoData = Video::findOne(['ID' => $videoID]);

                $skipTimeString = $model->skip_adv_time;
                $videoData->PreXML = '';
                $videoData->MidXML = '';
                $videoData->PostXML = '';
                for ($i = 0; $i < 3; $i++) {
                    $URL ='';
                    $fileName = "myStaticTag_" . $videoID . "_" . $i;
                    if ($i == 0 && !empty($model->PreAdvertisementTagURL)) {
                        $URL = $model->PreAdvertisementTagURL;
                        $videoData->PreXML = $fileName;
                    } else if ($i == 1 && !empty($model->MidAdvertisementTagURL)) {
                        $URL = $model->MidAdvertisementTagURL;
                        $videoData->MidXML = $fileName;
                    } else if(!empty($model->PostAdvertisementTagURL)){
                        $URL = $model->PostAdvertisementTagURL;
                        $videoData->PostXML = $fileName;
                    }
                    if(!empty($URL)){ 
                        $xml = '<VAST version="2.0">
                        <Ad id="static">
                        <InLine>
                        <AdSystem>Static VAST Template</AdSystem>
                        <AdTitle>Static VAST Tag</AdTitle>
                        <Creatives>
                        <Creative>
                        <Linear skipoffset="00:00:03">
                        <Duration>00:00:08</Duration>
                        <VideoClicks>
                        <ClickThrough>http://www.jwplayer.com/</ClickThrough>
                        </VideoClicks>
                        <MediaFiles>
                        <MediaFile type="video/mp4" bitrate="300" width="480" height="270">
                        ' . $URL . '
                        </MediaFile>
                        </MediaFiles>
                        </Linear>
                        </Creative>
                        </Creatives>
                        </InLine>
                        </Ad>
                        </VAST>';
                        $xmlobj = new \SimpleXMLElement($xml);

                    //$path =Yii::$app->getUrlManager()->getBaseUrl()."/upload/xml/";
                    //echo $path;
                        $xmlobj->asXML('upload/xml/' . $fileName . '.xml');
                        \S3::putObjectFile('upload/xml/' . $fileName . '.xml', S3BUCKET, 'xml/' . $fileName . '.xml', \S3::ACL_PUBLIC_READ);
                    }

                    // chmod ('upload/xml/'.$fileName.'.xml',0777);
                }
                $videoData->save();
                for ($n = 0; $n < count($playlist); $n++) {
                    $modelPlaylist = new \backend\models\Playlistvideo();
                    //$modelPlay = new \backend\models\Videocategory();
                    $PlayListindex = $modelPlaylist->find()->where(['PlayListID' => $playlist[$n]])->max('DisplayIndex');
                    ;
                    //$index = $catData;

                    if ($PlayListindex > 0) {
                        $PlayListindex++;
                    } else {
                        $PlayListindex = 1;
                    }
                    $modelPlaylist->PlayListID = $playlist[$n];
                    $modelPlaylist->VideoID = $videoID;
                    $modelPlaylist->DisplayIndex = $PlayListindex;
                    $modelPlaylist->CreatedBy = Yii::$app->user->identity->UserID;
                    $modelPlaylist->save();
                }
                for ($n = 0; $n < count($topics); $n++) {
                    $modelTopics = new \backend\models\Videocategory();
                    $modelTopics = new \backend\models\Videocategory();
                    $TopicsData = $modelTopics->find()->where(['CategID' => $topics[$n]])->max('Displayindex');
                    ;
                    $Topicindex = $TopicsData;
                    //echo $index;die;
                    if ($Topicindex > 0) {
                        $Topicindex++;
                    } else {
                        $Topicindex = 1;
                    }
                    $modelTopics->CategID = $topics[$n];
                    $modelTopics->VideoID = $videoID;
                    $modelTopics->DisplayIndex = $Topicindex;
                    $modelTopics->CreatedBy = Yii::$app->user->identity->UserID;
                    $modelTopics->save();
                }

                for ($n = 0; $n < count($category); $n++) {
                    $modelcat = new \backend\models\Videocategory();
                    $catData = $modelcat->find()->where(['CategID' => $category[$n]])->max('Displayindex');
                    ;
                    $index = $catData;
                    //echo $index;die;
                    if ($index > 0) {
                        $index++;
                    } else {
                        $index = 1;
                    }
                    $modelCategory = new \backend\models\Videocategory();
                    $modelCategory->CategID = $category[$n];
                    $modelCategory->VideoID = $videoID;
                    $modelCategory->DisplayIndex = $index;
                    $modelCategory->CreatedBy = Yii::$app->user->identity->UserID;
                    $modelCategory->save();
                }
                for ($n = 0; $n < count($country); $n++) {
                    $modelCountry = new \backend\models\Videogeographic();
                    $modelCountry->CountryID = $country[$n];
                    $modelCountry->VideoID = $videoID;
                    $modelCountry->CreatedBy = Yii::$app->user->identity->UserID;
                    $modelCountry->save();
                }
                if (isset($_POST['languageFields'])) {
                    $_POST['languageFields']['from_table_id'] = $model->ID;
                    \backend\models\LangaugeFields::SaveLanguageFields($_POST['languageFields']);
                }
                $this->execStoredProcedure(
                    'CALL AdminVideoPlaylistAddOrUpdate(:VideoID,:playlistID,NULL,NULL,NULL)',
                    array(
                        ':VideoID' => (int) $videoID,
                        ':playlistID' => (!empty($playlist)) ? implode(",", $playlist) : null,
                    )
                );

                $this->saveRelatedAndThumbnails($videoID);


                if (!empty($_REQUEST['SVID'])) {
                    $Subscribermodel = \backend\models\Videouploadbysubscribers::find()->where(['ID' => $_REQUEST['SVID']])->One();
                    $Subscribermodel->VideoID = $model->ID;
                    $Subscribermodel->ApproveStatus = "2";
                    $Subscribermodel->save(false);
                }

                /* $sql =  'CALL RelatedVideosAddOrUpdate (:videoID,:relatedVideoId,"","","")';
                  $command = Yii::$app->db->createCommand($sql);
                  $command->bindParam(":videoID", $videoID);
                  $command->bindParam(":relatedVideoId", (!empty($_POST['Video']['IsRelatedVideoId'])) ? trim($_POST['Video']['IsRelatedVideoId']) : NULL);
                  $command->queryAll();

                  $sql =  'CALL VideosThumbImagesAddOrUpdate(:VideoID,:thumbVideoId,NULL,NULL,NULL)';
                  $command = Yii::$app->db->createCommand($sql);
                  $command->bindParam(":VideoID",trim($id));
                  $command->bindParam(":thumbVideoId",(!empty($_POST['Video']['IsthumbnailVideoId'])) ? trim($_POST['Video']['IsthumbnailVideoId']) : NULL);
                  $command->execute(); */

                  if (!$model->isNewRecord && $model->VideoStreamURL == '') {
                    Yii::$app->session->setFlash('success', 'Video has been uploded successfully');
                } else {
                    Yii::$app->session->setFlash('success', 'Video has been added successfully');
                }
                //echo json_encode(array("status"=>"ok","id"=>$videoID,'VideoURL'=>$model->VideoStreamURL,'thumbimage'=>S3_VIDEO_BUCKETABSOLUTE_PATH.$model->generateThumbnailImage->ImageName,'videoTitle'=>$model->Title,'shared_on_browser'=>$model->shared_on)); die;
                echo json_encode(array("status" => "ok", "UplodedVideoUrl" => $model->VideoURL, "thumb_sec" => $model->GeneratedThumbnailTime, "id" => $videoID, 'videoDesc' => (isset($model->Description)) ? $model->Description : "", 'VideoURL' => (isset($model->ID)) ? Yii::$app->urlManagerFrontEnd->createAbsoluteUrl(['video/index', 'id' => $model->ID]) : "", 'thumbimage' => (isset($model->generateThumbnailImage->ImageName)) ? S3_VIDEO_BUCKETABSOLUTE_PATH . $model->generateThumbnailImage->ImageName : "", 'videoTitle' => (isset($model->Title)) ? $model->Title : "", 'shared_on_browser' => (isset($model->shared_on)) ? $model->shared_on : ""));
                die;
            } else {
                echo json_encode(array("status" => "error", "errors" => $model->getErrors()));
                die;
            }
        }
    }

    public function actionUpdateajax() {
        $id = $_POST['id'];
        $model = $this->findModel($id);
        $model->scenario = 'update';
        $exists_sharedon = empty($model->shared_on) ? [] : explode(",", $model->shared_on);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->slug = \backend\models\Video::createSlug($model->Title);
                //Xml Code Goes Here
                $skipTimeString = $model->skip_adv_time;
                $model->PreXML = '';
                $model->MidXML = '';
                $model->PostXML = '';
                
                for ($i = 0; $i < 3; $i++) {
                 $URL='';
                 $fileName = "myStaticTag_" . $model->ID . "_" . $i;
                 if ($i == 0 && !empty($model->PreAdvertisementTagURL)) {

                    $URL = $model->PreAdvertisementTagURL;
                    $model->PreXML = $fileName;
                } else if ($i == 1 && !empty($model->MidAdvertisementTagURL)) {
                    $URL = $model->MidAdvertisementTagURL;
                    $model->MidXML = $fileName;
                } else if(!empty($model->PostAdvertisementTagURL)){
                    $URL = $model->PostAdvertisementTagURL;
                    $model->PostXML = $fileName;
                }
                if(!empty($URL)){
                    $xml = '<VAST version="2.0">
                    <Ad id="static">
                    <InLine>
                    <AdSystem>Static VAST Template</AdSystem>
                    <AdTitle>Static VAST Tag</AdTitle>
                    <Creatives>
                    <Creative>
                    <Linear skipoffset="' . $skipTimeString . '">
                    <Duration>00:00:08</Duration>
                    <VideoClicks>
                    <ClickThrough>http://www.jwplayer.com/</ClickThrough>
                    </VideoClicks>
                    <MediaFiles>
                    <MediaFile type="video/mp4" bitrate="300" width="480" height="270">
                    ' . $URL . '
                    </MediaFile>
                    </MediaFiles>
                    </Linear>
                    </Creative>
                    </Creatives>
                    </InLine>
                    </Ad>
                    </VAST>';
                    $xmlobj = new \SimpleXMLElement($xml);

                    //$path =Yii::$app->getUrlManager()->getBaseUrl()."/upload/xml/";
                    //echo $path;
                    $xmlobj->asXML('upload/xml/' . $fileName . '.xml');
                    \S3::putObjectFile('upload/xml/' . $fileName . '.xml', S3BUCKET, 'xml/' . $fileName . '.xml', \S3::ACL_PUBLIC_READ);
                    // chmod ('upload/xml/'.$fileName.'.xml',0777);
                }
            }
            $model->Updated = date("Y-m-d H:i:s");
            $model->UpdatedBy = Yii::$app->user->identity->UserID;
            $playlist = array();
            $topics = array();
            $category = array();
            $country = array();
            if (isset($_POST['Video']['Playlist'])) {
                $playlist = $_POST['Video']['Playlist'];
                if (in_array("multiselect-all", $playlist)) {
                        // echo "hiii";
                    unset($playlist[array_search("multiselect-all", $playlist)]);
                }
            }
            if (isset($_POST['Video']['Topics'])) {
                $topics = $_POST['Video']['Topics'];
            }
            if (isset($_POST['Video']['Category'])) {
                $category = $_POST['Video']['Category'];
            }
            if (isset($_POST['Video']['CountryRestrictions'])) {
                $country = $_POST['Video']['CountryRestrictions'];
            }
            $model->PublishDate = $this->normalizePublishDateUtc(isset($_POST['Video']['PublishDate']) ? $_POST['Video']['PublishDate'] : '');
            $model->shared_on = empty($model->shared_on) ? [] : $model->shared_on;
                //$model->shared_on = implode(",",array_unique(array_merge($exists_sharedon,$model->shared_on)));
            $model->shared_on = implode(",", $model->shared_on);
            $model->save(false);
                /* $modelPlaylist = new \backend\models\Playlistvideo();
                  $modelPlaylist->deleteAll(array('VideoID'=>$id));
                  for($n=0;$n<count($playlist);$n++) {
                  $modelPlaylist = new \backend\models\Playlistvideo();
                  $modelPlaylist->PlayListID = $playlist[$n];
                  $modelPlaylist->VideoID = $id;
                  $modelPlaylist->CreatedBy = Yii::$app->user->identity->UserID;
                  $modelPlaylist->save();
              } */

              if (isset($_POST['languageFields'])) {
                $_POST['languageFields']['from_table_id'] = $model->ID;
                \backend\models\LangaugeFields::SaveLanguageFields($_POST['languageFields']);
            }

            $modelTopics = new \backend\models\Videocategory();

            $DisplayIndexTopics = \backend\models\Videocategory::find()->where(['CategID' => $topics, 'VideoID' => $id])->asArray()->all();
            $DisplayIndexCat = \backend\models\Videocategory::find()->where(['CategID' => $category, 'VideoID' => $id])->asArray()->all();
                //var_dump($DisplayIndexCat);die;  
            $modelTopics->deleteAll(array('VideoID' => $id));
            for ($n = 0; $n < count($topics); $n++) {
                $modelTopics = new \backend\models\Videocategory();
                $modelTopics->CategID = $topics[$n];
                $modelTopics->VideoID = $id;
                if (count($DisplayIndexTopics) > 0 && $n < count($DisplayIndexTopics)) {
                    $modelTopics->DisplayIndex = $DisplayIndexTopics[$n]['DisplayIndex'];
                } else {
                    $catData = $modelTopics->find()->where(['CategID' => $topics[$n]])->max('Displayindex');
                    ;
                    $topicIndex = $catData;
                    if ($topicIndex > 0) {
                        $topicIndex++;
                    } else {
                        $topicIndex = 1;
                    }
                    $modelTopics->DisplayIndex = $topicIndex;
                }$modelTopics->CreatedBy = Yii::$app->user->identity->UserID;
                $modelTopics->save();
            }
            for ($n = 0; $n < count($category); $n++) {
                $modelCategory = new \backend\models\Videocategory();
                $modelCategory->CategID = $category[$n];
                $modelCategory->VideoID = $id;
                if (count($DisplayIndexCat) > 0 && $n < count($DisplayIndexCat)) {
                    $modelCategory->DisplayIndex = $DisplayIndexCat[$n]['DisplayIndex'];
                } else {
                    $catData = $modelCategory->find()->where(['CategID' => $category[$n]])->max('Displayindex');
                    ;
                    $index = $catData;
                    if ($index > 0) {
                        $index++;
                    } else {
                        $index = 1;
                    }
                    $modelCategory->DisplayIndex = $index;
                }
                $modelCategory->CreatedBy = Yii::$app->user->identity->UserID;
                $modelCategory->save();
            }

            $PlaylistModel = new \backend\models\Playlistvideo();
            $DisplayIndexPlaylist = \backend\models\Playlistvideo::find()->where(['PlayListID' => $playlist, 'VideoID' => $id])->asArray()->all();

            $modelCountry = new \backend\models\Videogeographic();
            $modelCountry->deleteAll(array('VideoID' => $id));
            for ($n = 0; $n < count($country); $n++) {
                $modelCountry = new \backend\models\Videogeographic();
                $modelCountry->CountryID = $country[$n];
                $modelCountry->VideoID = $id;
                $modelCountry->CreatedBy = Yii::$app->user->identity->UserID;
                $modelCountry->save();
            }

            $this->execStoredProcedure(
                'CALL AdminVideoPlaylistAddOrUpdate(:VideoID,:playlistID,NULL,NULL,NULL)',
                array(
                    ':VideoID' => (int) $id,
                    ':playlistID' => (!empty($playlist)) ? implode(",", $playlist) : null,
                )
            );

            $this->saveRelatedAndThumbnails($id);

            $PlaylistModel = new \backend\models\Playlistvideo();
                //$DisplayIndexPlaylist = \backend\models\Playlistvideo::find()->where(['PlayListID' => $playlist,'VideoID' =>$id])->asArray()->all();

            $PlaylistModel->deleteAll(array('VideoID' => $id));
                // var_dump($DisplayIndexPlaylist);die;
            for ($n = 0; $n < count($playlist); $n++) {
                $modelPlaylist = new \backend\models\Playlistvideo();
                $modelPlaylist->PlayListID = $playlist[$n];
                $modelPlaylist->VideoID = $id;
                $modelPlaylist->CreatedBy = Yii::$app->user->identity->UserID;

                if (count($DisplayIndexPlaylist) > 0 && $n < count($DisplayIndexPlaylist)) {

                    $modelPlaylist->DisplayIndex = $DisplayIndexPlaylist[$n]['DisplayIndex'];
                } else {
                    $playlistData = $PlaylistModel->find()->where(['PlayListID' => $playlist[$n]])->max('DisplayIndex');
                    $playlistIndex = $playlistData;
                    if ($playlistIndex > 0) {
                        $playlistIndex++;
                    } else {
                        $playlistIndex = 1;
                    }
                    $modelPlaylist->DisplayIndex = $playlistIndex;
                }

                $modelPlaylist->save();
            }

            if (!$model->isNewRecord && $model->VideoStreamURL == '') {
                Yii::$app->session->setFlash('success', 'Video has been uploded successfully');
            } else {
                Yii::$app->session->setFlash('success', 'Video has been updated successfully');
            }
                //http://52.91.4.216/powersport/frontend/web/index.php/video?id=52
                //echo json_encode(array("status"=>"ok","id"=>$id,'VideoURL'=>$model->VideoStreamURL,'thumbimage'=>S3_VIDEO_BUCKETABSOLUTE_PATH.$model->generateThumbnailImage->ImageName,'videoTitle'=>$model->Title,'shared_on_browser'=>$model->shared_on)); die;
            echo json_encode(array("status" => "ok", "id" => $id, "thumb_sec" => $model->GeneratedThumbnailTime, 'videoDesc' => (isset($model->Description)) ? $model->Description : "", 'VideoURL' => (isset($model->ID)) ? Yii::$app->urlManagerFrontEnd->createAbsoluteUrl(['video/index', 'id' => $model->ID]) : "", 'thumbimage' => (isset($model->generateThumbnailImage->ImageName)) ? S3_VIDEO_BUCKETABSOLUTE_PATH . $model->generateThumbnailImage->ImageName : "", 'videoTitle' => (isset($model->Title)) ? $model->Title : "", 'shared_on_browser' => (isset($model->shared_on)) ? $model->shared_on : ""));
            die;
        } else {
            echo json_encode(array("status" => "error", "errors" => $model->getErrors()));
            die;
                // echo json_encode(array("status"=>"error")); die;
        }
    } else {
        echo json_encode(array("status" => "error", "errors" => array("form" => array("Invalid form data."))));
        die;
    }
    }

    public function actionUpdatevideo() {
        $videoID = $_POST['id'];
        $modelUpdate = Video::findOne($videoID);
        if (isset($_POST['fullvideofile']) && $_POST['fullvideofile'] != '') {
            $modelUpdate->FullVideoURL = $_POST['fullvideofile'];
        }
        if (isset($_POST['filename']) && $_POST['filename'] != '') {
            $filename = trim($_POST['filename']);
            // Ensure MediaConvert input prefix
            if (strpos($filename, 'production/') !== 0 && strpos($filename, 'Videos/') === 0) {
                $filename = 'production/' . $filename;
            }
            $modelUpdate->VideoURL = $filename;
        }
        $modelUpdate->save(false);
        echo json_encode(array("status" => "ok"));
        die;
    }

    public function actionlogintwitter() {
        /* $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
          $request_token = $connection->getRequestToken(OAUTH_CALLBACK);
          $_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
          $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
          switch ($connection->http_code) {
          case 200:
          $url = $connection->getAuthorizeURL($token);
          header('Location: ' . $url);
          break;
          default:
          echo "Notlogin";
          unset($_SESSION['oauth_token']);
          unset($_SESSION['oauth_token_secret']);
          break;
          }
          exit; */


        /* if (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {
          echo "No";
          }
          else
          {
          echo "Yes";
      } */

      $twitter = Yii::$app->twitter->getTwitter();
      $request_token = $twitter->getRequestToken();

        //set some session info
      Yii::$app->session['oauth_token'] = $token = $request_token['oauth_token'];
      Yii::$app->session['oauth_token_secret'] = $request_token['oauth_token_secret'];

      if ($twitter->http_code == 200) {
            //get twitter connect url
        $url = $twitter->getAuthorizeURL($token);
            //send them
        return $this->redirect($url);
    } else {
            //error here
        return $this->redirect(Url::home());
    }
    }

    public function actionUpdateVideoStatus() {
        $videoID = $_POST['video_id'];
        $status = $_POST['status'];
        $modelUpdate = Video::findOne($videoID);
        $modelUpdate->Status = $status;
        $modelUpdate->save(false);
        echo "success";
    }

    /**
     * Deletes an existing Video model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $model = $this->findModel($id);
        $model->Status = 3;
        $model->save(false);
        Yii::$app->session->setFlash('success', 'Video has been deleted successfully!');
        return $this->redirect(['index']);
    }

    /**
     * Checks MediaConvert / HLS output for a video and updates VideoStreamURL when ready.
     * @return mixed
     */
    public function actionCheckAwsTranscodingStatus() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $videoId = Yii::$app->request->post('video_id');

        if (empty($videoId)) {
            return array('success' => false, 'message' => 'Video ID is required.');
        }

        $model = Video::findOne($videoId);
        if ($model === null) {
            return array('success' => false, 'message' => 'The requested video does not exist.');
        }

        if (empty($model->VideoURL) && empty($model->VideoStreamURL)) {
            return array('success' => false, 'message' => 'Video file not uploaded yet.');
        }

        // Already has stream URL
        if (!empty($model->VideoStreamURL)) {
            $streamKey = preg_replace('/\.m3u8$/i', '', $model->VideoStreamURL);
            $ok = $this->checkRemoteFileExists(CDN_VIDEO_URL . ltrim($streamKey, '/') . '.m3u8');
            if ($ok) {
                $thumbCount = $this->ensureGeneratedThumbnails($model);
                return array(
                    'success' => true,
                    'message' => 'Transcoding complete. Stream is ready. Generated thumbnails: ' . (int) $thumbCount
                );
            }
            return array('success' => false, 'message' => 'Stream URL saved but file not found yet. Try again in a minute.');
        }

        $streamKey = $this->buildExpectedStreamKey($model->VideoURL);
        if ($streamKey === '') {
            return array('success' => false, 'message' => 'Could not determine stream path from VideoURL.');
        }

        $m3u8Url = CDN_VIDEO_URL . ltrim($streamKey, '/') . '.m3u8';
        if ($this->checkRemoteFileExists($m3u8Url)) {
            $model->VideoStreamURL = $streamKey;
            $model->save(false);
            $thumbCount = $this->ensureGeneratedThumbnails($model);
            return array(
                'success' => true,
                'message' => 'Transcoding complete. VideoStreamURL saved. Generated thumbnails: ' . (int) $thumbCount . '. Page will reload.'
            );
        }

        return array(
            'success' => false,
            'message' => 'Transcoding still in progress (MediaConvert). Wait 2-5 min then check again. Expected: ' . $streamKey . '.m3u8'
        );
    }

    /**
     * Build expected HLS key from uploaded mp4 key.
     * production/Videos/Videos_123_120_xxx.mp4 -> Streaming/Videos_123_120_xxx/Videos_123_120_xxx
     */
    protected function buildExpectedStreamKey($videoUrl) {
        $key = trim((string) $videoUrl);
        $key = preg_replace('#^https?://[^/]+/#', '', $key);
        $base = basename($key);
        $base = preg_replace('/\.(mp4|mov|avi|mkv)$/i', '', $base);
        if ($base === '') {
            return '';
        }
        return 'Streaming/' . $base . '/' . $base;
    }

    protected function checkRemoteFileExists($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_exec($ch);
        $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return ($code >= 200 && $code < 400);
    }

    /**
     * Ensure ImageType=1 rows exist for a video (generate via ffmpeg if needed).
     * @return int number of generated thumbnail rows for this video
     */
    protected function ensureGeneratedThumbnails($model) {
        $videoId = (int) $model->ID;
        if ($videoId <= 0) {
            return 0;
        }

        $existing = Images::find()->where(array('VideoID' => $videoId, 'ImageType' => '1'))->count();
        if ($existing > 0) {
            // Still sync any S3 files that might not be in DB yet
            $this->syncGeneratedThumbnailsFromS3($model);
            return (int) Images::find()->where(array('VideoID' => $videoId, 'ImageType' => '1'))->count();
        }

        $this->generateDefaultThumbnailsFromVideo($model);
        $this->syncGeneratedThumbnailsFromS3($model);
        return (int) Images::find()->where(array('VideoID' => $videoId, 'ImageType' => '1'))->count();
    }

    protected function getAwsS3Client() {
        return new S3Client(array(
            'version' => '2006-03-01',
            'region' => AWSREGION,
            'credentials' => array(
                'key' => AWSACCESSKEY,
                'secret' => AWSSECRETKEY,
            ),
        ));
    }

    /**
     * Resolve source mp4 basename (Videos_123_120_xxx) from VideoURL / VideoStreamURL.
     */
    protected function resolveVideoBasename($model) {
        $candidates = array();
        if (!empty($model->VideoURL)) {
            $candidates[] = $model->VideoURL;
        }
        if (!empty($model->VideoStreamURL)) {
            $candidates[] = $model->VideoStreamURL;
        }
        foreach ($candidates as $raw) {
            $key = trim((string) $raw);
            $key = preg_replace('#^https?://[^/]+/#', '', $key);
            $key = preg_replace('/\.m3u8$/i', '', $key);
            $base = basename($key);
            $base = preg_replace('/\.(mp4|mov|avi|mkv)$/i', '', $base);
            if ($base !== '' && preg_match('/^Videos_/i', $base)) {
                return $base;
            }
        }
        return '';
    }

    protected function resolveSourceVideoKey($model) {
        $base = $this->resolveVideoBasename($model);
        if ($base === '') {
            return '';
        }
        // Prefer key stored in VideoURL when it already points at Videos/
        if (!empty($model->VideoURL)) {
            $key = trim((string) $model->VideoURL);
            $key = preg_replace('#^https?://[^/]+/#', '', $key);
            $key = ltrim($key, '/');
            if (stripos($key, 'production/') !== 0 && stripos($key, 'Videos/') === 0) {
                $key = 'production/' . $key;
            }
            if (preg_match('/\.(mp4|mov|avi|mkv)$/i', $key)) {
                return $key;
            }
        }
        return 'production/Videos/' . $base . '.mp4';
    }

    /**
     * Create default thumbnails with ffmpeg and upload to output bucket.
     */
    protected function generateDefaultThumbnailsFromVideo($model) {
        @set_time_limit(300);
        $ffmpeg = '/opt/ffmpeg/ffmpeg';
        $ffprobe = '/opt/ffmpeg/ffprobe';
        if (!is_file($ffmpeg)) {
            Yii::error('ffmpeg binary not found at ' . $ffmpeg, __METHOD__);
            return false;
        }

        $videoId = (int) $model->ID;
        $base = $this->resolveVideoBasename($model);
        $srcKey = $this->resolveSourceVideoKey($model);
        if ($base === '' || $srcKey === '') {
            return false;
        }

        $tmpDir = sys_get_temp_dir() . '/ps_thumbs_' . $videoId;
        if (!is_dir($tmpDir)) {
            @mkdir($tmpDir, 0775, true);
        }
        $localMp4 = $tmpDir . '/' . $base . '.mp4';

        try {
            $s3 = $this->getAwsS3Client();
            if (!is_file($localMp4) || filesize($localMp4) < 1000) {
                $s3->getObject(array(
                    'Bucket' => S3BUCKET,
                    'Key' => $srcKey,
                    'SaveAs' => $localMp4,
                ));
            }

            $duration = 0.0;
            if (is_file($ffprobe)) {
                $probeCmd = $ffprobe . ' -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 ' . escapeshellarg($localMp4);
                $duration = (float) trim(shell_exec($probeCmd));
            }
            if ($duration <= 0) {
                $duration = 5.0;
            }

            $times = array(1.0, 2.0, 3.0);
            $preferred = !empty($model->GeneratedThumbnailTime) ? (float) $model->GeneratedThumbnailTime : 0.0;
            if ($preferred > 0 && $preferred < $duration) {
                $times[] = $preferred;
            }
            $times[] = max(0.5, $duration * 0.25);
            $times[] = max(0.5, $duration * 0.5);
            $times[] = max(0.5, $duration * 0.75);

            $uniqueTimes = array();
            foreach ($times as $t) {
                $t = round((float) $t, 2);
                if ($t >= $duration) {
                    $t = max(0.1, $duration - 0.2);
                }
                if ($t < 0.1) {
                    $t = 0.1;
                }
                $uniqueTimes[number_format($t, 2, '.', '')] = $t;
            }
            $uniqueTimes = array_values($uniqueTimes);
            sort($uniqueTimes);
            // Keep first 5 frames
            $uniqueTimes = array_slice($uniqueTimes, 0, 5);

            $index = 1;
            foreach ($uniqueTimes as $ss) {
                $suffix = str_pad((string) $index, 5, '0', STR_PAD_LEFT);
                $localPng = $tmpDir . '/Thumb_' . $base . '_' . $suffix . '.png';
                $cmd = $ffmpeg . ' -y -ss ' . escapeshellarg((string) $ss)
                    . ' -i ' . escapeshellarg($localMp4)
                    . ' -frames:v 1 -update 1 -q:v 2 '
                    . escapeshellarg($localPng) . ' 2>&1';
                $output = array();
                $code = 0;
                exec($cmd, $output, $code);
                if ($code !== 0 || !is_file($localPng) || filesize($localPng) < 100) {
                    $index++;
                    continue;
                }

                $destKey = 'production/Videos/Thumb/' . $videoId . '/Thumb_' . $base . '_' . $suffix . '.png';
                $s3->putObject(array(
                    'Bucket' => S3BUCKETFORVIDEO,
                    'Key' => $destKey,
                    'SourceFile' => $localPng,
                    'ContentType' => 'image/png',
                ));
                $index++;
            }

            @unlink($localMp4);
            return true;
        } catch (\Exception $e) {
            Yii::error('Thumbnail generation failed: ' . $e->getMessage(), __METHOD__);
            return false;
        }
    }

    /**
     * List S3 generated thumbs and insert missing images rows (ImageType=1).
     */
    protected function syncGeneratedThumbnailsFromS3($model) {
        $videoId = (int) $model->ID;
        $prefix = 'production/Videos/Thumb/' . $videoId . '/';
        try {
            $s3 = $this->getAwsS3Client();
            $result = $s3->listObjects(array(
                'Bucket' => S3BUCKETFORVIDEO,
                'Prefix' => $prefix,
                'MaxKeys' => 50,
            ));
            if (empty($result['Contents'])) {
                return 0;
            }

            $added = 0;
            $userId = (isset(Yii::$app->user) && !Yii::$app->user->isGuest) ? (int) Yii::$app->user->id : 0;
            foreach ($result['Contents'] as $obj) {
                $key = isset($obj['Key']) ? $obj['Key'] : '';
                if ($key === '' || !preg_match('/\.(png|jpe?g|webp)$/i', $key)) {
                    continue;
                }
                // DB stores path without production/ prefix (CDN already includes /production/)
                $imageName = preg_replace('#^production/#', '', $key);
                $exists = Images::find()->where(array(
                    'VideoID' => $videoId,
                    'ImageName' => $imageName,
                    'ImageType' => '1',
                ))->one();
                if ($exists) {
                    continue;
                }
                $img = new Images();
                $img->VideoID = $videoId;
                $img->Title = !empty($model->Title) ? $model->Title : ('Thumb ' . $videoId);
                $img->ImageName = $imageName;
                $img->IsThumb = 1;
                $img->ImageType = '1';
                $img->Created = date('Y-m-d H:i:s');
                $img->CreatedBy = $userId;
                if ($img->save(false)) {
                    $added++;
                }
            }
            return $added;
        } catch (\Exception $e) {
            Yii::error('Thumbnail sync failed: ' . $e->getMessage(), __METHOD__);
            return 0;
        }
    }

    /**
     * Normalize publish date from form (local) to UTC for DB. Never write 0000-00-00.
     */
    protected function normalizePublishDateUtc($raw) {
        $raw = trim((string) $raw);
        $ts = $raw !== '' ? strtotime($raw) : false;
        if ($ts === false || $ts <= 0) {
            return gmdate('Y-m-d H:i:s');
        }
        try {
            return ConvertDateToUTC(date('Y-m-d H:i:s', $ts));
        } catch (\Exception $e) {
            return gmdate('Y-m-d H:i:s');
        }
    }

    /**
     * Persist related videos + library/default thumbnails via direct SQL
     * (avoids PDO unbuffered error after CALL stored procedures).
     */
    protected function saveRelatedAndThumbnails($videoId) {
        $videoId = (int) $videoId;
        $related = '';
        $thumbs = '';
        $defaults = '';
        if (isset($_POST['Video']['IsRelatedVideoId'])) {
            $related = trim((string) $_POST['Video']['IsRelatedVideoId']);
        }
        if (isset($_POST['Video']['IsthumbnailVideoId'])) {
            $thumbs = trim((string) $_POST['Video']['IsthumbnailVideoId']);
        }
        if (isset($_POST['Video']['IsDefaultthumbnailVideoId'])) {
            $defaults = trim((string) $_POST['Video']['IsDefaultthumbnailVideoId']);
        }

        $related = trim(preg_replace('/[^0-9,]/', '', $related), ',');
        $thumbs = trim(preg_replace('/[^0-9,]/', '', $thumbs), ',');
        $defaults = trim(preg_replace('/[^0-9,]/', '', $defaults), ',');

        $db = Yii::$app->db;

        // Related videos
        $db->createCommand()->delete('related_videos', array('video_id' => $videoId))->execute();
        if ($related !== '') {
            $ids = explode(',', $related);
            foreach ($ids as $rid) {
                $rid = (int) $rid;
                if ($rid <= 0 || $rid === $videoId) {
                    continue;
                }
                $db->createCommand()->insert('related_videos', array(
                    'video_id' => $videoId,
                    'related_video' => $rid,
                ))->execute();
            }
        }

        // Library thumbnails (type=1)
        $db->createCommand()->delete('video_thumbnail_images', array('video_id' => $videoId, 'type' => '1'))->execute();
        if ($thumbs !== '') {
            $ids = explode(',', $thumbs);
            foreach ($ids as $iid) {
                $iid = (int) $iid;
                if ($iid <= 0) {
                    continue;
                }
                $db->createCommand()->insert('video_thumbnail_images', array(
                    'video_id' => $videoId,
                    'images_id' => $iid,
                    'type' => '1',
                ))->execute();
            }
        }

        // Default/generated thumbnails (type=0)
        $db->createCommand()->delete('video_thumbnail_images', array('video_id' => $videoId, 'type' => '0'))->execute();
        if ($defaults !== '') {
            $ids = explode(',', $defaults);
            foreach ($ids as $iid) {
                $iid = (int) $iid;
                if ($iid <= 0) {
                    continue;
                }
                $db->createCommand()->insert('video_thumbnail_images', array(
                    'video_id' => $videoId,
                    'images_id' => $iid,
                    'type' => '0',
                ))->execute();
            }
        }
    }

    /**
     * Run a MySQL CALL and fully drain result sets so next queries work.
     */
    protected function execStoredProcedure($sql, $params = array()) {
        $command = Yii::$app->db->createCommand($sql);
        foreach ($params as $name => $value) {
            $command->bindValue($name, $value);
        }
        $command->execute();
        if ($command->pdoStatement) {
            try {
                while ($command->pdoStatement->nextRowset()) {
                    // drain
                }
            } catch (\Exception $e) {
                // ignore when no more rowsets
            }
            try {
                $command->pdoStatement->closeCursor();
            } catch (\Exception $e) {
            }
        }
    }

    /**
     * Typeahead JSON: library thumbnails (ImageType=3) by title/keywords.
     */
    public function actionThumbImageList($q = null) {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $q = trim(urldecode((string) $q));
        if ($q === '') {
            return array();
        }
        $like = '%' . str_replace(array('%', '_'), array('\\%', '\\_'), $q) . '%';
        $sql = "SELECT img.ImageID, img.ImageType, img.VideoID, img.Title, img.ImageName, img.MetaKeywords
                FROM images AS img
                WHERE img.ImageType = 3
                  AND (img.Title LIKE :q OR img.MetaKeywords LIKE :q2)
                ORDER BY img.ImageID DESC
                LIMIT 120";
        $rows = Yii::$app->db->createCommand($sql)
            ->bindValue(':q', $like)
            ->bindValue(':q2', $like)
            ->queryAll();
        foreach ($rows as $k => $row) {
            $rows[$k]['thumbUrl'] = ImagesUrl($row);
            if (empty($rows[$k]['MetaKeywords'])) {
                $rows[$k]['MetaKeywords'] = isset($row['Title']) ? $row['Title'] : '';
            }
        }
        return $rows;
    }

    /**
     * Typeahead JSON: videos for Related Videos picker.
     */
    public function actionVideoThumbList($q = null, $id = null) {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $q = trim(urldecode((string) $q));
        if ($q === '') {
            return array();
        }
        $like = '%' . str_replace(array('%', '_'), array('\\%', '\\_'), $q) . '%';
        $exclude = (int) $id;
        $sql = "SELECT im.ImageID, im.ImageType, im.VideoID, im.ImageName, v.Title, v.MetaKeywords
                FROM images AS im
                INNER JOIN video AS v ON v.ID = im.VideoID
                WHERE im.IsThumb = 1 AND im.ImageType = 1 AND v.Status = '1'
                  AND (v.PublishDate IS NULL OR v.PublishDate <= NOW())
                  AND (v.Title LIKE :q OR v.MetaKeywords LIKE :q2)";
        if ($exclude > 0) {
            $sql .= " AND im.VideoID <> " . $exclude;
        }
        $sql .= " GROUP BY v.ID ORDER BY v.Updated DESC, v.Created DESC LIMIT 120";
        $rows = Yii::$app->db->createCommand($sql)
            ->bindValue(':q', $like)
            ->bindValue(':q2', $like)
            ->queryAll();
        foreach ($rows as $k => $row) {
            $rows[$k]['thumbUrl'] = ImagesUrl($row);
            if (empty($rows[$k]['MetaKeywords'])) {
                $rows[$k]['MetaKeywords'] = isset($row['Title']) ? $row['Title'] : '';
            }
        }
        return $rows;
    }

    /**
     * Selected + recent library thumbs for the Video Thumbnail modal.
     */
    protected function getLibraryThumbnailListForForm($selectedIds) {
        $selectedIds = preg_replace('/[^0-9,]/', '', (string) $selectedIds);
        $byId = array();
        if ($selectedIds !== '') {
            $rows = Yii::$app->db->createCommand(
                "SELECT ImageID, ImageType, VideoID, Title, ImageName, MetaKeywords
                 FROM images WHERE ImageType = 3 AND ImageID IN ($selectedIds)"
            )->queryAll();
            foreach ($rows as $row) {
                $byId[$row['ImageID']] = $row;
            }
        }
        $recent = Yii::$app->db->createCommand(
            "SELECT ImageID, ImageType, VideoID, Title, ImageName, MetaKeywords
             FROM images WHERE ImageType = 3
             ORDER BY ImageID DESC LIMIT 80"
        )->queryAll();
        foreach ($recent as $row) {
            if (!isset($byId[$row['ImageID']])) {
                $byId[$row['ImageID']] = $row;
            }
        }
        return array_values($byId);
    }

    /**
     * Selected + recent related-video thumbs for the Related Videos modal.
     */
    protected function getRelatedVideoThumbListForForm($currentVideoId, $selectedRelatedIds) {
        $currentVideoId = (int) $currentVideoId;
        $selectedRelatedIds = preg_replace('/[^0-9,]/', '', (string) $selectedRelatedIds);
        $byVideo = array();

        if ($selectedRelatedIds !== '') {
            $sql = "SELECT im.ImageID, im.ImageType, im.VideoID, im.ImageName, v.Title
                    FROM images AS im
                    INNER JOIN video AS v ON v.ID = im.VideoID
                    WHERE im.IsThumb = 1 AND im.ImageType = 1
                      AND im.VideoID IN ($selectedRelatedIds)
                    GROUP BY v.ID";
            foreach (Yii::$app->db->createCommand($sql)->queryAll() as $row) {
                $byVideo[$row['VideoID']] = $row;
            }
        }

        $sql = "SELECT im.ImageID, im.ImageType, im.VideoID, im.ImageName, v.Title
                FROM images AS im
                INNER JOIN video AS v ON v.ID = im.VideoID
                WHERE im.IsThumb = 1 AND im.ImageType = 1 AND v.Status = '1'
                  AND v.ID <> :vid
                  AND (v.PublishDate IS NULL OR v.PublishDate <= NOW())
                GROUP BY v.ID
                ORDER BY v.Updated DESC, v.Created DESC
                LIMIT 80";
        $recent = Yii::$app->db->createCommand($sql)->bindValue(':vid', $currentVideoId)->queryAll();
        foreach ($recent as $row) {
            if (!isset($byVideo[$row['VideoID']])) {
                $byVideo[$row['VideoID']] = $row;
            }
        }
        return array_values($byVideo);
    }

    /**
     * Finds the Video model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Video the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Video::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
