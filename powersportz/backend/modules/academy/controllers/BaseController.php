<?php

namespace backend\modules\academy\controllers;

use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class BaseController extends Controller
{
    protected function requireLogin()
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->getResponse()->redirect(Yii::$app->getUser()->loginUrl)->send();
            Yii::$app->end();
        }
    }

    protected function requireAdminOrSchool()
    {
        $this->requireLogin();
        $userType = (int) Yii::$app->user->identity->UserType;
        if ($userType !== 1 && $userType !== 3) {
            throw new ForbiddenHttpException('Access denied.');
        }
    }

    protected function requireSchool()
    {
        $this->requireLogin();
        $userType = (int) Yii::$app->user->identity->UserType;
        if ($userType !== 3) {
            throw new ForbiddenHttpException('Access denied.');
        }
    }

    protected function requireAdmin()
    {
        $this->requireLogin();
        $userType = (int) Yii::$app->user->identity->UserType;
        if ($userType !== 1) {
            throw new ForbiddenHttpException('Access denied.');
        }
    }
}
