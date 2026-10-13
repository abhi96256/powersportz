<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Playlists;
use frontend\models\PlaylistsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\Homepage;
use backend\models\Breakingnews;

class PlaylistdetailsController extends \yii\web\Controller {

  public $enableCsrfValidation = false;

  public function actionIndex() {
    if (isset($_SESSION['language_id'])) {
      $lang_code = $_SESSION['language_id'];
      Yii::$app->language = $lang_code;
    }

    $isVideoRestricted = 0;

    $Videogeographics = array();
    $HomePageData = Homepage::find()->where(['HomeID' => '1'])->one();
    $NewsOrAddType = $HomePageData->NewsOrAdd;
    $AdvertisementID = $HomePageData->AdvertisementID;
    $lang_code = Yii::$app->language;
    if (isset($_SESSION['language_id'])) {
      $lang_code = $_SESSION['language_id'];
    }
    $lang_data = \backend\models\Langauge::getLanguageId($lang_code);
    if (!empty($lang_data)) {
      $lang_id = $lang_data['LanguageID'];
    } else {
      $lang_id = '';
    }
    $PlayListId = Yii::$app->getRequest()->getQueryParam('id');
    $playlistdetails = Playlists::find()->where('slug="' . $PlayListId . '"')->one();
    if (!empty($playlistdetails) && isset($playlistdetails->ID)) {
      $PlayListId = $playlistdetails->ID;
    } else {
      throw new \yii\web\NotFoundHttpException('Oops, Video is no longer available.');
    }

    $country_code = GetIPDetails();
    $CountryData = \backend\models\Country::find()->where(['Code' => $country_code])->asArray()->one();
    $Playlistgeographics = array();
    if (!empty($CountryData)) {
      $countryid = $CountryData['ID'];
      $Playlistgeographics = \backend\models\Playlistgeographic::find()->where(['PlayListID' => $PlayListId, 'CountryID' => $countryid])->asArray()->one();
    }
    $orderbyvar = 'pv.DisplayIndex  DESC,PublishDate  DESC';
    $sql = 'CALL Video_Get_PlayListDetail (:TopicId,:orderbyvar)';
    $var_one = '2';
    $command = Yii::$app->db->createCommand($sql);
    $command->bindParam(":TopicId", $PlayListId);
    $command->bindParam(":orderbyvar", $orderbyvar);
    $inlist = $command->queryAll();
    $modelMember = array();
    $Customvideo = array();
    $Customplaylist = array();
    $Customadvertise = array();
    if (!empty($inlist)) {

      $videoid = $inlist[0]['ID'];
      if (Yii::$app->getRequest()->getQueryParam('video')) {
        $videoid = Yii::$app->getRequest()->getQueryParam('video');
        $videodetailss = \backend\models\Video::find()->where("concat(slug,'-',ID) ='" . $videoid . "'")->one();

        echo $videoid = $videodetailss->ID;
      }

      if (!empty($CountryData)) {
        $countryid = $CountryData['ID'];
        $Videogeographics = \backend\models\Videogeographic::find()->where(['VideoID' => $videoid, 'CountryID' => $countryid])->asArray()->one();
      }
      $sql = 'CALL Select_Custom_Advertise ("1",:PlaylistId,:VideoId,"")';
      $command = Yii::$app->db->createCommand($sql);
      $command->bindParam(":PlaylistId", $PlayListId);
      $command->bindParam(":VideoId", $videoid);
      $Customadvertise = $command->queryAll();
      if ($lang_id != '' || $lang_id != '1') {
        foreach ($inlist as $plyvdokey => $inlistsub) {
          $playlvdid = $inlistsub['ID'];
          $sql = 'CALL Getdetails_by_lang(:lang_id,"video",:playvd_id)';
          $command = Yii::$app->db->createCommand($sql);
          $command->bindParam(":playvd_id", $playlvdid);
          $command->bindParam(":lang_id", $lang_id);
          $translatedplayvddata = $command->queryAll();
          if (!empty($translatedplayvddata)) {
            foreach ($translatedplayvddata as $translatedplayvddatasub) {
              if ($translatedplayvddatasub['value'] != '') {
                $inlist[$plyvdokey][$translatedplayvddatasub['field_name']] = $translatedplayvddatasub['value'];
              }
            }
          }
        }
        $sql = 'CALL Getdetails_by_lang(:lang_id,"playlist",:play_id)';
        $command = Yii::$app->db->createCommand($sql);
        $command->bindParam(":play_id", $PlayListId);
        $command->bindParam(":lang_id", $lang_id);
        $translatedplaydata = $command->queryAll();
        if (!empty($translatedplaydata)) {
          if ($translatedplaydata[0]['value'] != '') {
            $inlist[0]['PlayListTitle'] = $translatedplaydata[0]['value'];
          }
        }
      }
    } else {
      return $this->redirect(Yii::$app->getUrlManager()->getBaseUrl() . '/playlists');
    }
    if (!Yii::$app->getUser()->isGuest) {
      $userID = Yii::$app->user->identity->UserID;
      if (Yii::$app->getRequest()->getQueryParam('video')) {
        $videoid = Yii::$app->getRequest()->getQueryParam('video');
        $modelMember = \frontend\models\Videolike::find()->where(['UserID' => $userID, 'VideoID' => $videoid])->asArray()->all();
      } else {
        $modelMember = \frontend\models\Videolike::find()->where(['UserID' => $userID, 'VideoID' => $inlist[0]['ID']])->asArray()->all();
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
    /* if ($_SERVER['REMOTE_ADDR'] == '202.131.115.250') {
      echo '<pre>';
      print_r($inlist);
      echo '</pre>';
      exit;
      } */
    /* ---------------------- Breaking News or add    ----------------------- */
    return $this->render('index', [
          'searchModel' => $inlist,
          'modelMember' => $modelMember,
          'Videogeographics' => $Videogeographics,
          'Playlistgeographics' => $Playlistgeographics,
          'Customadvertise' => $Customadvertise,
          'HomePageModel' => $HomePageData,
          'newsModel' => $newsModel,
          'Advertise' => $Advertisedescription,
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

  protected function findBreakingNews() {
    if (($model = Breakingnews::find()->where(['Status' => 1])->orderBy(['Created' => SORT_DESC])->all()) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('The requested page does not exist.');
    }
  }

}
