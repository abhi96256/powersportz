<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Schedule;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Content;

class AboutUsController extends \yii\web\Controller {

    public function actionIndex() {
        if(isset($_SESSION['language_id'])){
            $lang_code = $_SESSION['language_id'];
            Yii::$app->language = $lang_code;
        }
        $data = $this->findContent();
        
        $description = $title = '';
        if(!empty($data->Description)){
           $description = $data->Description; 
           $title = $data->Title; 
        } else {
            return $this->goHome();
        }


        return $this->render('/content/index', [            
            'description' => $description,
            'title' => $title,
        ]);
    }

    
    protected function findContent() {
        if (($model = Content::find()->where(['Status' => 1,'slug' => 'about-us'])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
