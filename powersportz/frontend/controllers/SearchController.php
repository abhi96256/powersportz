<?php

namespace frontend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
class SearchController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        $lang_code=Yii::$app->language;
                    $lang_data=\backend\models\Langauge::getLanguageId($lang_code);
            if(!empty($lang_data)){
                $lang_id=$lang_data['LanguageID'];
            }else{
                $lang_id='';
            }
        if(Yii::$app->request->get('Video'))
        {
                $request = Yii::$app->request;
                $videoid = $request->get('Video');
                $videoid=preg_replace('/[^A-Za-z0-9\-]/', '', $videoid);
                $sql =  'CALL Video_GetList(:Video,"",0)';
                    $command = Yii::$app->db->createCommand($sql);
                    $command->bindParam(":Video",$videoid);
                    $videodetails= $command->queryAll();
                    if(empty($videodetails)){
                          $sql =  'CALL Video_GetList(:Video,"",1)';
                    $command = Yii::$app->db->createCommand($sql);
                    $command->bindParam(":Video",$videoid);
                    $videodetails= $command->queryAll();
                    }
                if($lang_id!='' || $lang_id!='1'){
                    if(!empty($videodetails)){
                        foreach($videodetails as $srchkey=>$videodetailssub){
                        //var_dump($videodetailssub['ID']);
                          $videoid=$videodetailssub['ID'];
                      $sql = 'CALL Getdetails_by_lang(:lang_id,"video",:video_id)';
                      $command = Yii::$app->db->createCommand($sql);
                      $command->bindParam(":video_id", $videoid);
                      $command->bindParam(":lang_id", $lang_id);
                      $translatedsrvddata = $command->queryAll();
                            if(!empty($translatedsrvddata)){
                                foreach($translatedsrvddata as $translatedsrvddatasub){
                                    if($translatedsrvddatasub['value']!=''){
                                            $videodetails[$srchkey][$translatedsrvddatasub['field_name']]=$translatedsrvddatasub['value'];
                                    }
                                }    
                            }
                        }    
                    }
                }
        }
        else
        {
                    $videodetails= array();
        }
        return $this->render('index',['videoDetails'=>$videodetails]);
    }
    public static function highlight($text, $words) {
                    preg_match_all('~\w+~', $words, $m);
        if(!$m)
        return $text;
                    $re = '~\\b(' .preg_quote(implode('|', $m[0])). ')\\b~i';
        return preg_replace($re, '<span style="color:aqua">$0</span>', $text);
}

}
    