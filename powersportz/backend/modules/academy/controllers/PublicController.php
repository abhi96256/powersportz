<?php

namespace backend\modules\academy\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use backend\modules\academy\models\Player;
use backend\modules\academy\models\School;
use backend\modules\academy\models\Otp;
use backend\modules\academy\components\CertificateService;

class PublicController extends Controller
{
    public $layout = 'main';

    public function actionIndex()
    {
        $email = '';
        if (Yii::$app->request->isPost) {
            $email = trim(Yii::$app->request->post('email', ''));
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                Yii::$app->session->setFlash('error', 'Please enter a valid email.');
            } else {
                $player = Player::find()->where(['email' => $email, 'status' => 1])->one();
                if ($player === null) {
                    Yii::$app->session->setFlash('error', 'No player found for this email.');
                } else {
                    $otp = $this->createOtp($player);
                    $this->sendOtpEmail($email, $otp->otp);
                    return $this->redirect(['verify', 'email' => $email]);
                }
            }
        }

        return $this->render('index', [
            'email' => $email,
        ]);
    }

    public function actionVerify($email = '')
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new NotFoundHttpException('Invalid email.');
        }
        $player = Player::find()->where(['email' => $email, 'status' => 1])->one();
        if ($player === null) {
            throw new NotFoundHttpException('Player not found.');
        }

        $downloadUrl = '';
        if (Yii::$app->request->isPost) {
            $otpValue = trim(Yii::$app->request->post('otp', ''));
            $otp = Otp::find()
                ->where(['email' => $email, 'consumed_at' => null])
                ->orderBy(['id' => SORT_DESC])
                ->one();

            if ($otp === null || $otp->otp !== $otpValue || strtotime($otp->expires_at) < time()) {
                Yii::$app->session->setFlash('error', 'Invalid or expired OTP.');
            } else {
                $otp->consumed_at = date('Y-m-d H:i:s');
                $otp->save(false);

                $token = bin2hex(random_bytes(16));
                $player->download_token = $token;
                $player->download_token_expires_at = date('Y-m-d H:i:s', time() + 15 * 60);
                $player->save(false);
                $downloadUrl = Yii::$app->urlManager->createAbsoluteUrl(['academy/public/download', 'token' => $token]);
            }
        }

        return $this->render('verify', [
            'email' => $email,
            'downloadUrl' => $downloadUrl,
        ]);
    }

    public function actionDownload($token)
    {
        $player = Player::find()
            ->where(['download_token' => $token, 'status' => 1])
            ->one();
        if ($player === null || strtotime($player->download_token_expires_at) < time()) {
            throw new NotFoundHttpException('Download link expired.');
        }

        $school = School::findOne($player->school_id);
        $schoolName = $school ? $school->name : 'Academy';

        $dir = Yii::getAlias('@backend') . '/../upload/academy/certificates';
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }
        $fileName = 'certificate_' . $player->id . '.pdf';
        $filePath = $dir . '/' . $fileName;

        if (!file_exists($filePath)) {
            $service = new CertificateService();
            $content = $service->renderPdf($player, $schoolName);
            file_put_contents($filePath, $content);
            $player->certificate_pdf_path = $filePath;
            $player->save(false);
        }

        return Yii::$app->response->sendFile($filePath, $fileName, [
            'mimeType' => 'application/pdf',
        ]);
    }

    private function createOtp(Player $player)
    {
        $otpValue = str_pad((string) random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
        $otp = new Otp();
        $otp->player_id = $player->id;
        $otp->email = $player->email;
        $otp->otp = $otpValue;
        $otp->created_at = date('Y-m-d H:i:s');
        $otp->expires_at = date('Y-m-d H:i:s', time() + 5 * 60);
        $otp->save(false);
        return $otp;
    }

    private function sendOtpEmail($email, $otp)
    {
        Yii::$app->mailer->compose()
            ->setTo($email)
            ->setSubject('Your Powersportz Academy OTP')
            ->setTextBody("Your OTP is: {$otp}\nThis code expires in 5 minutes.")
            ->send();
    }
}
