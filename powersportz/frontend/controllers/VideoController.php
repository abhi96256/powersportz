<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\Homepage;
use backend\models\Breakingnews;
use frontend\models\Video;

class VideoController extends \yii\web\Controller {

  public $enableCsrfValidation = false;

  public function actionIndex() {
    $is_fvrt = 0;
    $is_watch = 0;
    $HomePageData = Homepage::find()->where(['HomeID' => '1'])->one();
    $NewsOrAddType = $HomePageData->NewsOrAdd;
    $AdvertisementID = $HomePageData->AdvertisementID;
    $lang_code = Yii::$app->language;
    if (isset($_SESSION['language_id'])) {
      $lang_code = $_SESSION['language_id'];
      Yii::$app->language = $lang_code;
    }
//$lang_data=\backend\models\Langauge\getLanguageId($lang_code);
    $lang_data = \backend\models\Langauge::getLanguageId($lang_code);
    if (!empty($lang_data)) {
      $lang_id = $lang_data['LanguageID'];
    } else {
      $lang_id = '';
    }

    $Video_ID = $VideoID = $uri = Yii::$app->getRequest()->getQueryParam('id');
    // $matches = [];      
    // preg_match("/[-]\d+$/", $uri, $matches);
    // if(is_array($matches) && count($matches))
    // {
    //     $slug = str_replace(current($matches),'', $uri);
    //     $Video_ID = $VideoID  = str_replace('-','',current($matches));
    // }

    $Categ_ID = Yii::$app->getRequest()->getQueryParam('CategoryID');
    $videodetailspages = \backend\models\Video::find()->where("concat(slug,'-',ID) ='" . $uri . "' and Status = '1'")->one();
    if (!empty($videodetailspages)) {
      $Video_ID = $VideoID = $videodetailspages->ID;
    } else {
      throw new \yii\web\NotFoundHttpException('Oops, Video is no longer available.');
    }


    $sql = 'CALL Video_GetDetail (:VideoId)';
    $var_one = '2';
    $command = Yii::$app->db->createCommand($sql);
    $command->bindParam(":VideoId", $VideoID);
    $inlist = $command->queryAll();

    // Fix empty/wrong ImageName from SP so player poster + OG image work
    if (!empty($inlist[0])) {
      $resolved = ResolveVideoDisplayThumbnail(
        (int) $VideoID,
        isset($inlist[0]['ImageName']) ? $inlist[0]['ImageName'] : '',
        isset($inlist[0]['ImageType']) ? $inlist[0]['ImageType'] : ''
      );
      $inlist[0]['ImageName'] = $resolved['ImageName'];
      $inlist[0]['ImageType'] = $resolved['ImageType'];
    }

    $country_code = GetIPDetails();
    $CountryData = \backend\models\Country::find()->where(['Code' => $country_code])->asArray()->one();
    $Videogeographics = array();
    if (!empty($CountryData)) {
      $countryid = $CountryData['ID'];
      $Videogeographics = \backend\models\Videogeographic::find()->where(['VideoID' => $VideoID, 'CountryID' => $countryid])->asArray()->one();
    }

    $modelMember = array();

    if (!Yii::$app->getUser()->isGuest) {

      $userID = Yii::$app->user->identity->UserID;
      $modelMember = \frontend\models\Videolike::find()->where(['UserID' => $userID, 'VideoID' => $VideoID])->asArray()->all();

      /* $modelMember1 = \frontend\models\Member::find()->where(['UserID' => $userID])->one();
        $membrID = $modelMember1->MemberID;
        $ActivityTypeID = 2 ;

        $sql = 'select *from memberactivity where MemberID = :MemberID AND VideoID = :VideoID AND  ActivityTypeID = :ActivityTypeID';
        $command = Yii::$app->db->createCommand($sql);
        $command->bindParam(":MemberID", $membrID);
        $command->bindParam(":VideoID", $VideoID);
        $command->bindParam(":ActivityTypeID", $ActivityTypeID);
        $fvrtList = $command->queryAll();
        if(!empty($fvrtList)){ $is_fvrt = 1; }

        $ActivityTypeID = 3 ;

        $sql = 'select *from memberactivity where MemberID = :MemberID AND VideoID = :VideoID AND  ActivityTypeID = :ActivityTypeID';
        $command = Yii::$app->db->createCommand($sql);
        $command->bindParam(":MemberID", $membrID);
        $command->bindParam(":VideoID", $VideoID);
        $command->bindParam(":ActivityTypeID", $ActivityTypeID);
        $watchList = $command->queryAll();
        if(!empty($watchList)){ $is_watch = 1; } */
    }

    $shared_on = $inlist[0]['shared_on'];
    if ($lang_id != '' || $lang_id != '1') {
      $sql = 'CALL Getdetails_by_lang(:lang_id,"video",:Video)';
      $command = Yii::$app->db->createCommand($sql);
      $command->bindParam(":Video", $VideoID);
      $command->bindParam(":lang_id", $lang_id);
      $translatedviddata = $command->queryAll();
      if (!empty($translatedviddata)) {
        foreach ($translatedviddata as $translatedviddatasub) {
          if ($translatedviddatasub['value'] != '') {
            $inlist[0][$translatedviddatasub['field_name']] = $translatedviddatasub['value'];
          }
        }
      }
    }
    $Videodescription = array();
    $Customvideo = array();
    $Customadvertise = array();
    $Customtopicsadd = array();
    if (!empty($inlist)) {
      $categID = $inlist[0]['CategID'];
      $categidarray = explode(',', $categID);
      $categName = $inlist[0]['CategName'];
      $categNamearray = explode(',', $categName);
      $Maincategoryary = array_combine($categidarray, $categNamearray);
      if ($lang_id != '' || $lang_id != '1') {
        $sql = 'CALL Getdetails_by_lang(:lang_id,"category",:categ_id)';
        $command = Yii::$app->db->createCommand($sql);
        $command->bindParam(":categ_id", $categID);
        $command->bindParam(":lang_id", $lang_id);
        $translatedcatgdata = $command->queryAll();
        if (!empty($translatedcatgdata)) {
          foreach ($translatedcatgdata as $translatedcatgdatasub) {
            if (array_key_exists($translatedcatgdatasub['from_table_id'], $Maincategoryary)) {
              if ($translatedcatgdatasub['value'] != '') {
                $Maincategoryary[$translatedcatgdatasub['from_table_id']] = $translatedcatgdatasub['value'];
              }
            }
          }
        }
        $Maincategorystrng = implode(",", $Maincategoryary);
        $inlist[0]['CategName'] = $Maincategorystrng;
      }
      $sql = 'CALL Select_Custom_Advertise (2,"",:VideoId,:CategID)';
      $command = Yii::$app->db->createCommand($sql);
      $command->bindParam(":VideoId", $VideoID);
      $command->bindParam(":CategID", $inlist[0]['CategID']);
      $Customadvertise = $command->queryAll();


      /* Begins Topics Ads */
      if ($Categ_ID > 0) {
        $Customadvideo = \frontend\models\Customadtopics::find()->where(['TopicsID' => $Categ_ID, 'IsDelete' => 0])->asArray()->all();
        if (!empty($Customadvideo)) {
          foreach ($Customadvideo as $val) {
            $date = date('Y-m-d H:i:s');
            $status = 1;
            $sql = 'select ca.*,ct.Type_Id from customadvertisement ca
                JOIN customadvertisement_type AS ct ON ct.CusAdvertiseID = ca.CustomAdvertiseID
                where FromDate <= :date and ToDate >= :date AND Status = :status AND CustomAdvertiseID = :CustomAdvertiseID Group by ct.Type_Id ';
            $command = Yii::$app->db->createCommand($sql);
            $command->bindParam(":date", $date);
            $command->bindParam(":status", $status);
            $command->bindParam(":CustomAdvertiseID", $val['CustomAdvertiseID']);
            $Customadvertise = $command->queryAll();
            if (count($Customadvertise) > 0) {
              break;
            }
          }
        }
        if (empty($Customadvertise)) {
          $Customvideo = \frontend\models\Customadvideo::find()->where(['VideoID' => $Video_ID, 'IsDelete' => 0])->asArray()->all();
          if (!empty($Customvideo)) {
            foreach ($Customvideo as $val) {
              $date = date('Y-m-d H:i:s');
              $status = 1;
              $sql = 'select ca.*,ct.Type_Id from customadvertisement ca   
                    JOIN customadvertisement_type AS ct ON ct.CusAdvertiseID = ca.CustomAdvertiseID
                    where FromDate <= :date and ToDate >= :date AND Status = :status AND CustomAdvertiseID = :CustomAdvertiseID  Group by ct.Type_Id';
              $command = Yii::$app->db->createCommand($sql);
              $command->bindParam(":date", $date);
              $command->bindParam(":status", $status);
              $command->bindParam(":CustomAdvertiseID", $val['CustomAdvertiseID']);
              $Customadvertise = $command->queryAll();
              if (count($Customadvertise) > 0) {
                break;
              }
            }
          }
        }
      }
      /* End Topics Ads */

//        $Customvideo= \frontend\models\Customadvideo::find()->where(['VideoID'=>$inlist[0]['ID']])->asArray()->all();            
//        if(!empty($Customvideo)){
//            $Customadid = $Customvideo[0]['CustomAdvertiseID']; 
//            $Customadvertise= \frontend\models\Customadvertisement::find()->where(['CustomAdvertiseID'=>$Customadid])->asArray()->all();       
//        }
//        else{
//        $sql = 'CALL Video_Get_CustomAdd(:VideoId)';
//        $command = Yii::$app->db->createCommand($sql);
//        $command->bindParam(":VideoId", $VideoID);
//        $Customadvertise = $command->queryAll();
//        }
      $relatedVideo = $inlist[0]['ReleatedVideo'];
      if (!empty($relatedVideo)) {
        $relatedvideoarray = explode(',', $relatedVideo);
        foreach ($relatedvideoarray as $key => $relatedvideovar) {
          $sql = 'CALL Video_GetList("",:Video,0)';
          $command = Yii::$app->db->createCommand($sql);
          $command->bindParam(":Video", $relatedvideovar);
          $videodetails = $command->queryAll();
          if ($lang_id != '' || $lang_id != '1') {
            $sql = 'CALL Getdetails_by_lang(:lang_id,"video",:Video)';
            $command = Yii::$app->db->createCommand($sql);
            $command->bindParam(":Video", $relatedvideovar);
            $command->bindParam(":lang_id", $lang_id);
            $translatedreldata = $command->queryAll();
            if (!empty($translatedreldata)) {
              foreach ($translatedreldata as $catkey => $translatedreldatasub) {
                if ($translatedreldatasub['value'] != '') {
                  $videodetails[0][$translatedreldatasub['field_name']] = $translatedreldatasub['value'];
                }
              }
            }
          }
          if (!empty($videodetails)) {
            $Videodescription[$key]['Title'] = $videodetails[0]['Title'];
            $Videodescription[$key]['slug'] = $videodetails[0]['slug'];
            $Videodescription[$key]['description'] = $videodetails[0]['description'];
            $Videodescription[$key]['ID'] = $videodetails[0]['ID'];
            $Videodescription[$key]['ImageName'] = $videodetails[0]['ImageName'];
            $Videodescription[$key]['ImageType'] = $videodetails[0]['ImageType'];
          }
        }
      }
    }
    /* ---------------------- Breaking News or add    ----------------------- */
    $Advertisedescription = array();
    if ($NewsOrAddType == '1') {
      $newsModel = $this->findBreakingNews();
      if (!empty($newsModel)) {
        foreach ($newsModel as $newsModelsub) {
//var_dump($newsModelsub->ID);
          if ($lang_id != '' || $lang_id != '1') {
            $newid = $newsModelsub->ID;
            $sql = 'CALL Getdetails_by_lang(:lang_id,"breakingnews",:ID)';
            $command = Yii::$app->db->createCommand($sql);
            $command->bindParam(":ID", $newid);
            $command->bindParam(":lang_id", $lang_id);
            $translatedbrnwsdata = $command->queryAll();
            if (!empty($translatedbrnwsdata)) {
              foreach ($translatedbrnwsdata as $translatedbrnwsdatasub) {
                if ($translatedbrnwsdatasub['value'] != '') {
                  $newsModelsub->$translatedbrnwsdatasub['field_name'] = $translatedbrnwsdatasub['value'];
                } else {
                  $newsModelsub->$translatedbrnwsdatasub['field_name'] = '';
                }
              }
            }
          }
        }
      }
    } else {
      $newsModel = array();
      if ($AdvertisementID != '') {
        $AdvertisementIDarray = explode(',', $AdvertisementID);
        foreach ($AdvertisementIDarray as $key => $AdvertisementIDvar) {
          $sql = 'CALL Admin_advertisement_video_list("",:advertiseid,"","","")';
          $command = Yii::$app->db->createCommand($sql);
          $command->bindParam(":advertiseid", $AdvertisementIDvar);
          $advertisedetails = $command->queryAll();
          if (!empty($advertisedetails)) {
            $Advertisedescription[$key]['ToDate'] = $advertisedetails[0]['ToDate'];
            $Advertisedescription[$key]['FromDate'] = $advertisedetails[0]['FromDate'];
            $Advertisedescription[$key]['LandingLink'] = $advertisedetails[0]['LandingLink'];
            $Advertisedescription[$key]['ID'] = $advertisedetails[0]['ID'];
            $Advertisedescription[$key]['ImagePath'] = $advertisedetails[0]['ImagePath'];
          }
        }
      }
    }
    /* ---------------------- Breaking News or add    ----------------------- */
    $Category_Detail = \backend\models\Category::find()->where(['slug' => (!empty($_GET['CategoryID'])) ? $_GET['CategoryID'] : 0])->asArray()->One();
    return $this->render('index', [
          'HomePageModel' => $HomePageData,
          'searchModel' => $inlist,
          'RelatedVideolist' => $Videodescription,
          'modelMember' => $modelMember,
          'newsModel' => $newsModel,
          'Advertise' => $Advertisedescription,
          'Videogeographics' => $Videogeographics,
          'Customadvertise' => $Customadvertise,
          'Category_Detail' => $Category_Detail,
          'is_favourite' => $is_fvrt,
          'is_watch' => $is_watch,
          'shared_on' => $shared_on,
    ]);
  }

  public function actionVideolike() {

    if (!empty($_POST)) {
      $request = Yii::$app->request;
      $videoid = $request->post('Videoid');
      $ActionType = $request->post('Type');
      $cookies = Yii::$app->response->cookies;
      if (!Yii::$app->getUser()->isGuest) {
        $modelVideolike = new \frontend\models\Videolike();
        $userID = Yii::$app->user->identity->UserID;
        $modelMember = \frontend\models\Member::find()->where(['UserID' => $userID])->one();
        if (!empty($modelMember)) {
          $modelVideolike->VideoID = $videoid;
          $modelVideolike->MemberID = $modelMember->MemberID;
          $modelVideolike->UserID = $userID;
          $modelVideolike->Type = $ActionType;
          $modelVideolike->save();
          if ($ActionType == '1') {
            $model = new \backend\models\Video();
            $find = $model->findOne($videoid);
            if (!empty($find)) {
              $likecount = $find->LikeCount;
              $find->LikeCount = $likecount + 1;
              $find->update();
              echo $find->LikeCount;
            }
          }
        }
      } else {
        if ($ActionType == '1') {
          if (!$cookies->has($videoid . 'cookies')) {
            $model = new \backend\models\Video();
            $find = $model->findOne($videoid);
            if (!empty($find)) {
              $likecount = $find->LikeCount;
              $find->LikeCount = $likecount + 1;
              $find->update();
              echo $find->LikeCount;
// add a new cookie to the response to be sent
              $cookies->add(new \yii\web\Cookie([
                  'name' => $videoid . 'cookies',
                  'value' => $videoid,
                  'expire' => time() + 86400 * 365,
              ]));
            } else {
              
            }
          }
        } elseif ($ActionType == '4') {
          
        } else {
          Yii::$app->session->setFlash('error', Yii::t('frontend', 'mustlogin'));
          return $this->redirect(Yii::$app->getUrlManager()->getBaseUrl() . '/member/login');
        }
      }
    } else {
      
    }
  }

  public function actionVideounlike() {

    if (!empty($_POST)) {
      $request = Yii::$app->request;
      $videoid = $request->post('Videoid');
      $ActionType = $request->post('Type');
      if (!Yii::$app->getUser()->isGuest) {
        $userID = Yii::$app->user->identity->UserID;
        $modelVideolike = \frontend\models\Videolike::find()->where(['UserID' => $userID, 'VideoID' => $videoid, 'Type' => $ActionType])->one();
        $modelVideolike->delete();
        if ($ActionType == '1') {
          $model = new \backend\models\Video();
          $find = $model->findOne($videoid);
          if (!empty($find)) {
            $likecount = $find->LikeCount;
            $find->LikeCount = $likecount - 1;
            $find->update();
            echo $find->LikeCount;
          }
        }
      } else {
        if ($ActionType == '1') {
          $model = new \backend\models\Video();
          $find = $model->findOne($videoid);
          if (!empty($find)) {
            $likecount = $find->LikeCount;
            $find->LikeCount = $likecount - 1;
            $find->update();
            $cookies = Yii::$app->response->cookies;
            $cookies->remove($videoid . 'cookies');
            unset($cookies[$videoid . 'cookies']);
            echo $find->LikeCount;
          }
        }
      }
    }
  }

  public function actionVideodownload() {
    $objInfo = \S3::getObjectInfo(S3BUCKET, 'Videos/Streaming/mp4_Videos_32_1446874140794');
    $obj = \S3::getObject(S3BUCKET, 'Videos/Streaming/mp4_Videos_32_1446874140794');
    header('Content-type: ' . $objInfo->header['_info']['content_type']);
    echo $obj->body;
  }

  public function actionDownloadvideo($videoid) {
    $videodata = \frontend\models\Video::find()->where(['ID' => $videoid])->asArray()->one();
    $videostreamurl = $videodata['VideoStreamURL'];
    $path = S3_BUCKETABSOLUTE_PATH . '/Videos/' . $videostreamurl . '.mp4';
    $Random_Number = rand(0, 9999999999); //Random number to be added to name.
    $time = time();
//echo $path;die;

    $NewFileName = $Random_Number . $time . '.mp4'; //new file name
// $downloadPAth = "../../frontend/web/uploads/test.mp4";
    $downloadPAth = "../../frontend/web/uploads/" . $NewFileName;
    file_put_contents($downloadPAth, fopen($path, 'r'));
    header('Content-Description: application/force-download');
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($downloadPAth));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($downloadPAth));
    ob_clean();
    flush();
    readfile($downloadPAth);
    ignore_user_abort(true);
    unlink($downloadPAth);
    exit;
  }

  protected function findBreakingNews() {
    if (($model = Breakingnews::find()->where(['Status' => 1])->orderBy(['Created' => SORT_DESC])->all()) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('The requested page does not exist.');
    }
  }

  public function actionCheckRedis() {
    echo microtime() . '<br/>';
    echo count(Video::find()->where(['LangID' => NULL])->all());
    echo '<br/>' . microtime();
  }

}
