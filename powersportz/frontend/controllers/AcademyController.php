<?php

namespace frontend\controllers;

use Yii;
use yii\web\Controller;

class AcademyController extends Controller
{
    public function actionIndex()
    {
        if (isset($_SESSION['language_id'])) {
            $lang_code = $_SESSION['language_id'];
            Yii::$app->language = $lang_code;
        }

        return $this->render('index');
    }

    /**
     * Standalone institutional licence calculator.
     * Direct URL only — not linked from site navigation.
     */
    public function actionInstitutionalLicence()
    {
        $this->layout = false;
        Yii::$app->response->headers->set('X-Robots-Tag', 'noindex, nofollow');

        return $this->renderFile(
            Yii::getAlias('@app/views/academy/institutional-licence.html')
        );
    }
}
