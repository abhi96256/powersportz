<?php
namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use frontend\models\Homepage;
use backend\models\Breakingnews;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class SiteController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex() {
        $country_code = GetIPDetails();
        $CountryData = \backend\models\Country::find()->where(['Code' => $country_code])->asArray()->one();
        if (!empty($CountryData)) {
            $countryid = $CountryData['ID'];
        } else {
            $countryid = '';
        }
        $Videogeographics = array();
        $Customvideo=array();
        $Customadvertise=array();
        $HomepageModel = $this->findModel();
        $MainVideoType = $HomepageModel->MainVideoType;
        $NewsOrAddType = $HomepageModel->NewsOrAdd;
        $AccompanyingID = $HomepageModel->AccompanyingID;
        $CategoryID = $HomepageModel->CategoryID;
        $AdvertisementID = $HomepageModel->AdvertisementID;
        if ($MainVideoType == '1') {
            $VideoID = $HomepageModel->VideoID;
            if ($countryid != '') {
                $Videogeographics = \backend\models\Videogeographic::find()->where(['VideoID' => $VideoID, 'CountryID' => $countryid])->asArray()->one();
            }
            $sql = 'CALL Video_GetDetail (:VideoId)';
            $var_one = '2';
            $command = Yii::$app->db->createCommand($sql);
            $command->bindParam(":VideoId", $VideoID);
            $inlist = $command->queryAll();
            if(!empty($inlist)){
            $sql = 'CALL Select_Custom_Advertise ("","",:VideoId,"")';
            $command = Yii::$app->db->createCommand($sql);
            $command->bindParam(":VideoId", $VideoID);
            $Customadvertise = $command->queryAll();
//        $Customvideo= \frontend\models\Customadvideo::find()->where(['VideoID'=>$inlist[0]['ID']])->asArray()->all();            
//        if(!empty($Customvideo)){
//            $Customadid = $Customvideo[0]['CustomAdvertiseID']; 
//            $Customadvertise= \frontend\models\Customadvertisement::find()->where(['CustomAdvertiseID'=>$Customadid])->asArray()->all();       
//        } 
            }
        } else {
            $inlist = array();
        }
        $Videodescription = array();
        $Categorydescription = array();
        $Advertisedescription = array();
        $Categorygeographicsarray = array();
        $AccompanyingID='';
        if(!empty($AccompanyingID)) {
            $AccompanyingIDarray = explode(',', $AccompanyingID);
            foreach ($AccompanyingIDarray as $key => $AccompanyingIDvar) {
                $sql = 'CALL Video_GetList("",:Video)';
                $command = Yii::$app->db->createCommand($sql);
                $command->bindParam(":Video", $AccompanyingIDvar);
                $videodetails = $command->queryAll();
                if (!empty($videodetails)) {
                    $Videodescription[$key]['Title'] = $videodetails[0]['Title'];
                    $Videodescription[$key]['description'] = $videodetails[0]['description'];
                    $Videodescription[$key]['ID'] = $videodetails[0]['ID'];
                    $Videodescription[$key]['ImageName'] = $videodetails[0]['ImageName'];
                }
            }
        }
        if (!empty($CategoryID)) {
            $CategoryIDarray = explode(',', $CategoryID);
            $var_one = 1;
            foreach ($CategoryIDarray as $key => $CategoryIDvar) {
                if ($countryid != '') {
                    $Categorygeographics = \backend\models\Categorygeographic::find()->where(['CategID' => $CategoryIDvar, 'CountryID' => $countryid])->asArray()->one();
                    if(!empty($Categorygeographics)){
                        array_push($Categorygeographicsarray, $Categorygeographics);
                    }
                     }
                $sql = 'CALL Category_Get_List(:CategID,:Type,"","","","")';
                $command = Yii::$app->db->createCommand($sql);
                $command->bindParam(":CategID", $CategoryIDvar);
                $command->bindParam(":Type", $var_one);
                $videodetails = $command->queryAll();

                if (!empty($videodetails)) {
                    foreach ($videodetails as $key1 => $videodetailsarray) {
                        $Categorydescription[$videodetailsarray['CategoryName']][$key1]['CategoryID'] = $videodetailsarray['CategoryID'];
                        $Categorydescription[$videodetailsarray['CategoryName']][$key1]['CategTitle'] = $videodetailsarray['CategoryName'];
                        $Categorydescription[$videodetailsarray['CategoryName']][$key1]['Title'] = $videodetailsarray['Title'];
                        $Categorydescription[$videodetailsarray['CategoryName']][$key1]['description'] = $videodetailsarray['description'];
                        $Categorydescription[$videodetailsarray['CategoryName']][$key1]['ID'] = $videodetailsarray['ID'];
                        $Categorydescription[$videodetailsarray['CategoryName']][$key1]['ImageName'] = $videodetailsarray['ImageName'];
                    }
                }
            }
        }
        if ($NewsOrAddType == '1') {
            $newsModel = $this->findBreakingNews();
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
        return $this->render('index', [
                    'HomePageModel' => $HomepageModel,
                    'VideoDetails' => $inlist,
                    'newsModel' => $newsModel,
                    'AccompanyingVideo' => $Videodescription,
                    'Categories' => $Categorydescription,
                    'Advertise' => $Advertisedescription,
                    'Videogeographics' => $Videogeographics,
                    'Categorygeographics' => $Categorygeographicsarray,
                    'Customadvertise'=>$Customadvertise
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin() {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout() {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup() {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
                    'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset() {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
                    'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token) {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
                    'model' => $model,
        ]);
    }

    protected function findModel() {
        if (($model = Homepage::findOne(['HomeID' => 1])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findBreakingNews() {
        if (($model = Breakingnews::findAll(['Status' => 1])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function isMobileDevice(){
    $aMobileUA = array(
        '/iphone/i' => 'iPhone', 
        '/ipod/i' => 'iPod', 
        '/ipad/i' => 'iPad', 
        '/android/i' => 'Android', 
        '/blackberry/i' => 'BlackBerry', 
        '/webos/i' => 'Mobile'
    );

    //Return true if Mobile User Agent is detected
    foreach($aMobileUA as $sMobileKey => $sMobileOS){
        if(preg_match($sMobileKey, $_SERVER['HTTP_USER_AGENT'])){
            return true;
        }
    }
    //Otherwise return false..  
    return false;
}

    public function convert_number($number) {
        if (($number < 0) || ($number > 999999999)) {
            throw new Exception("Number is out of range");
        }

        $Gn = floor($number / 1000000);  /* Millions (giga) */
        $number -= $Gn * 1000000;
        $kn = floor($number / 1000);     /* Thousands (kilo) */
        $number -= $kn * 1000;
        $Hn = floor($number / 100);      /* Hundreds (hecto) */
        $number -= $Hn * 100;
        $Dn = floor($number / 10);       /* Tens (deca) */
        $n = $number % 10;               /* Ones */

        $res = "";

        if ($Gn) {
            $res .= $this->convert_number($Gn) . " Million";
        }

        if ($kn) {
            $res .= (empty($res) ? "" : " ") .
                    $this->convert_number($kn) . " Thousand";
        }

        if ($Hn) {
            $res .= (empty($res) ? "" : " ") .
                    $this->convert_number($Hn) . " Hundred";
        }

        $ones = array("", "first", "second", "third", "four", "five", "six",
            "seven", "eight", "nine", "ten", "Eleven", "Twelve", "Thirteen",
            "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen",
            "Nineteen");
        $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty",
            "Seventy", "Eigthy", "Ninety");

        if ($Dn || $n) {
            if (!empty($res)) {
                $res .= " and ";
            }

            if ($Dn < 2) {
                $res .= $ones[$Dn * 10 + $n];
            } else {
                $res .= $tens[$Dn];

                if ($n) {
                    $res .= "-" . $ones[$n];
                }
            }
        }

        if (empty($res)) {
            $res = "zero";
        }

        return $res;
    }
   public function array_value_recursive($key, array $arr){
    $val = array();
    array_walk_recursive($arr, function($v, $k) use($key, &$val){
        if($k == $key) array_push($val, $v);
    });
    return count($val) > 1 ? $val : array_pop($val);
}

}
