<?php

namespace frontend\controllers;
use frontend\models\Gamerule;
use yii\helpers\ArrayHelper;
use Yii;
class LivescoreController extends \yii\web\Controller
{
    public function actionIndex()
    {
        if(isset($_SESSION['language_id'])){
            $lang_code = $_SESSION['language_id'];
            Yii::$app->language = $lang_code;
        }
        //$model = $this->findModel(); 
        $model=Gamerule::find()->where(['Status' => 1])
->orderBy(['GameName' => SORT_ASC])->asArray()->all();
        //ArrayHelper::toArray($model, $properties);
        return $this->render('index', [
                'model' => $model,
            ]);
    }
    
    /**
     * Finds the Gamerule model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Gamerule the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel() {
        if (($model = Gamerule::findAll(['Status'=>1])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
