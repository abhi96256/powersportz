<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Schedule;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\Homepage;
use backend\models\Breakingnews;

class ScheduleController extends \yii\web\Controller {

    public function actionIndex() {

        $HomePageData = Homepage::find()->where(['HomeID' => '1'])->one();
        $NewsOrAddType = $HomePageData->NewsOrAdd;
        $AdvertisementID = $HomePageData->AdvertisementID;
        $lang_code = Yii::$app->language;
        if (isset($_SESSION['language_id'])) {
            $lang_code = $_SESSION['language_id'];
            Yii::$app->language = $lang_code;
        }
        $lang_data = \backend\models\Langauge::getLanguageId($lang_code);
        if (!empty($lang_data)) {
            $lang_id = $lang_data['LanguageID'];
        } else {
            $lang_id = '';
        }

        if (Yii::$app->getRequest()->getQueryParam('sdate')) {
            $scheduledate = Yii::$app->getRequest()->getQueryParam('sdate');
            $fscheduledate = ConvertDateToUTC($scheduledate .' 00:00:00','Y-m-d H:i:s');
            $tscheduledate = ConvertDateToUTC($scheduledate .' 23:59:59','Y-m-d H:i:s');
        } else {
            $fscheduledate = ConvertDateToUTC(date('Y-m-d').' 00:00:00','Y-m-d H:i:s');
            $tscheduledate = ConvertDateToUTC(date('Y-m-d').' 23:59:59','Y-m-d H:i:s');
        } 
        $query = Schedule::find();  
        $query->andWhere(['>=', 'ScheduleFromTime',$fscheduledate ]);
        $query->andWhere(['<=', 'ScheduleFromTime', $tscheduledate]);
        $result = $query->All();
        $data = []; 
        foreach ($result as $key => $row) {
            $data[strtotime($row->ScheduleFromTime).'-'.strtotime($row->ScheduleTime)][] =$row; 
        }
        $orderbyvar = '';

        $sql1 = 'CALL Schedule_GetNow_Data ()';
        $command1 = Yii::$app->db->createCommand($sql1);
        $maindata = $command1->queryOne();
        $mainid = $maindata['ScheduleID'];

        //Start By Hiren
        //Get main video and acccompny video list
        $var_two = 1;
        $sort = 'v.Created DESC';
        $sql = 'CALL Admin_video_category ("",:IDType,"",:sort,"","")';
        $command = Yii::$app->db->createCommand($sql);
        $command->bindParam(":IDType", $var_two);
        $command->bindParam(":sort", $sort);
        $outlist = $command->queryAll();

        $modelHomepage = Homepage::findOne(1);
        $recordedScheduleVideoImage = $scheduleInfo = array();
        if (!empty($modelHomepage->ScheduleVideoID)) {
            $recordedScheduleVideoImage = array_shift(array_filter($outlist, function($arr)use($modelHomepage) {
                        return $arr['ID'] == $modelHomepage->ScheduleVideoID;
                    }));
            if (isset($recordedScheduleVideoImage['ID'])) {
                $sql = 'CALL Video_GetDetail (:VideoId)';
                $command = Yii::$app->db->createCommand($sql);
                $command->bindParam(":VideoId", $recordedScheduleVideoImage['ID']);
                $scheduleInfo = $command->queryAll();
            }
        }
        //End

        // $sql = 'CALL Schedule_GetLIst (:Scheduledate,:PreScheduledate,:PastScheduledate,:MainScheduleID,:orderbyvar)';
        // $var_one = '2';
        // $command = Yii::$app->db->createCommand($sql);
        // $command->bindParam(":Scheduledate", $scheduledate);
        // $command->bindParam(":PreScheduledate", $preutcdate);
        // $command->bindParam(":PastScheduledate", $pastutcdate);
        // $command->bindParam(":MainScheduleID", $mainid);
        // $command->bindParam("orderbyvar", $orderbyvar);
        // $inlist = $command->queryAll();
        // $group = [];
        // foreach ($inlist as $value) {
        //     $group[$value['timeformat']][] = $value;
        // }

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
       
        return $this->render('index', [
                    'searchModel' =>$data,
                    'searchModelmain' => $maindata,
                    'HomePageModel' => $HomePageData,
                    'newsModel' => $newsModel,
                    'Advertise' => $Advertisedescription,
                    'recordedScheduleVideoImage' => $recordedScheduleVideoImage,
                    'scheduleInfo' => $scheduleInfo,
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
                    return $this->redirect('../member/login');
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
