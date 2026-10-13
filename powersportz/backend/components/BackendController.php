<?php

namespace backend\components;

use Yii;
use backend\models\UserRules;
use yii\filters\AccessControl;

class BackendController extends \yii\web\Controller {

    public $enableCsrfValidation = false;

    public function init() {
        parent::init();
        if (Yii::$app->user->isGuest) {
            \Yii::$app->getResponse()->redirect(\Yii::$app->getUser()->loginUrl);
        }        
    }

    function convertToUTCTimeZone($oTime, $oTimeZone, $nTimeZone) {
        $date = new \DateTime($oTime, new \DateTimeZone($oTimeZone));
        $date->setTimezone(new \DateTimeZone($nTimeZone));
        return $date->format('Y-m-d H:i:s');
    }

    public function behaviors() {

        $access_rules[] = [
            'allow' => true,
            'actions' => ['login', 'signup'],
            'roles' => ['?'],
        ];
        $access_rules[] = [
            'allow' => true,
            'actions' => ['error'],
            'roles' => ['*'],
        ];

        $access_rules[] = [
            'allow' => true,
            'actions' => ['logout'],
            'roles' => ['@'],
        ];

        /* $access_rules[] =  ['allow'=>false,
          'roles' => ['@'],
          ]; */
        if (!Yii::$app->user->isGuest) {           
            //Below code added by Hiren Dave on 10th Apr 2018 if user is aleady login and he has not a latest password which Kanthi has requested then its
            // redirected on logout
            $session = Yii::$app->session;
            if(!$session->has('isLoginWithNewPassword'))                
                $this->redirect(['site/logout']);

            $role_id = Yii::$app->user->identity->UserType;
            if (($member = \backend\models\Member::find()->where(['UserID' => Yii::$app->user->id])->asArray()->One()) !== null) {
                $role_id = $member['Designation'];
            }
            $controller_name = Yii::$app->controller->id;
            $controller_name = implode("", array_map('ucwords', explode("-", $controller_name))) . 'Controller';
            if ($role_id == 1) {
                $access_rules[] = [
                    'allow' => true,
                    'actions' => [Yii::$app->controller->action->id],
                    'roles' => ['@'],
                ];
            } else if (($userRules_menu = UserRules::findOne(["controller_name" => $controller_name, 'role_id' => $role_id])) !== null) {

                $access_rules[] = [
                    'allow' => true,
                    'actions' => explode(",", $userRules_menu->action_name),
                    'roles' => ['@'],
                ];
            }
        }

        return [
            'access' => [
                'class' => AccessControl::className(),
                // 'only' => ['login', 'logout', 'signup'],
                'rules' => $access_rules,
            ],
        ];
    }

}
?>    
