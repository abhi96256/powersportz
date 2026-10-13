<?php

namespace backend\modules\academy\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\helpers\Url;
use backend\modules\academy\models\School;
use backend\models\User;

class SchoolController extends BaseController
{
    public function actionIndex()
    {
        $this->requireAdmin();
        $provider = new ActiveDataProvider([
            'query' => School::find(),
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'attributes' => ['id', 'name', 'contact_email', 'created_at'],
            ],
        ]);

        if ($provider->getTotalCount() === 0) {
            $provider->setSort(false);
        }

        if ($error = Yii::$app->request->get('error')) {
            Yii::$app->session->setFlash('error', $error);
        }
        if ($success = Yii::$app->request->get('success')) {
            Yii::$app->session->setFlash('success', $success);
        }

        return $this->render('index', [
            'dataProvider' => $provider,
        ]);
    }

    public function actionCreate()
    {
        $this->requireAdmin();
        $model = new School();
        $model->scenario = 'create';

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $username = $model->contact_email;
            $password = trim($model->password);
            if ($password === '') {
                $password = $this->generatePassword();
            }

            if ($this->findExistingUser($username)) {
                $model->addError('contact_email', 'Email already exists');
            } else {
                $now = date('Y-m-d H:i:s');
                $user = new User();
                $user->UserType = 3;
                $user->Status = 1;
                $user->Created = $now;
                $user->Updated = $now;
                $user->LastLogin = $now;
                $user->UserName = new Expression("AES_ENCRYPT('" . $username . "',Password('" . AESKEY . "'))");
                $user->Email = new Expression("AES_ENCRYPT('" . $model->contact_email . "',Password('" . AESKEY . "'))");
                $user->Password = md5($password);
                $user->ConfirmPassword = $user->Password;
                $user->save(false);

                $model->user_id = $user->UserID;
                if ($model->status === null || $model->status === '') {
                    $model->status = 1;
                }
                $model->created_at = $now;
                $model->updated_at = $now;
                $model->save(false);

                $this->sendCredentialsEmail($model->contact_email, $username, $password, false);
                return $this->redirect([
                    'index',
                    'success' => 'School created and credentials emailed.',
                ]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $this->requireAdmin();
        $model = School::findOne($id);
        if ($model === null) {
            throw new \yii\web\NotFoundHttpException('School not found.');
        }

        $user = $model->user_id ? User::findOne($model->user_id) : null;
        $originalEmail = $model->contact_email;
        $originalPasswordHash = $user ? $user->Password : null;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $now = date('Y-m-d H:i:s');
            $newPassword = trim((string) $model->password);
            $passwordProvided = $newPassword !== '';
            $emailChanged = $model->contact_email !== $originalEmail;
            $passwordChanged = $passwordProvided && $originalPasswordHash !== null
                ? md5($newPassword) !== $originalPasswordHash
                : $passwordProvided;

            if ($emailChanged && $user) {
                $existingUser = User::find()
                    ->where(['UserName' => new Expression("AES_ENCRYPT('" . $model->contact_email . "',Password('" . AESKEY . "'))")])
                    ->andWhere(['!=', 'UserID', $user->UserID])
                    ->exists();
                if ($existingUser) {
                    $model->addError('contact_email', 'Email already exists');
                    return $this->render('update', [
                        'model' => $model,
                    ]);
                }
            }

            if ($user) {
                if ($emailChanged) {
                    $user->UserName = new Expression("AES_ENCRYPT('" . $model->contact_email . "',Password('" . AESKEY . "'))");
                    $user->Email = new Expression("AES_ENCRYPT('" . $model->contact_email . "',Password('" . AESKEY . "'))");
                }
                if ($passwordChanged) {
                    $user->Password = md5($newPassword);
                    $user->ConfirmPassword = $user->Password;
                }
                $user->Updated = $now;
                $user->save(false);
            }

            $model->updated_at = $now;
            $model->save(false);
            $isUpdate = ($emailChanged || $passwordChanged);
            if ($isUpdate) {
                $passwordForEmail = $passwordProvided ? $newPassword : null;
                $this->sendCredentialsEmail($model->contact_email, $model->contact_email, $passwordForEmail, $isUpdate);
            }
            return $this->redirect([
                'index',
                'success' => 'School updated.',
            ]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    private function generatePassword()
    {
        return substr(str_replace(['+', '/', '='], '', base64_encode(random_bytes(12))), 0, 10);
    }

    private function findExistingUser($username)
    {
        return User::find()
            ->where(['UserName' => new Expression("AES_ENCRYPT('" . $username . "',Password('" . AESKEY . "'))")])
            ->exists();
    }

    private function sendCredentialsEmail($to, $username, $password = null, $isUpdate = false)
    {
        // Set the login URL
        $loginUrl = Url::to(['/site/login'], true);
        
        // Set the password line based on whether it's provided or not
        $passwordLine = $password ? "Password: {$password}\n" : "Password: Unchanged, Please use your existing password.\n";
        
        // Determine the intro message based on whether it's an update or new account creation
        $intro = $isUpdate ? "We are excited to inform you that your PowerSportz academy login has been updated.\n\n" : "We are excited to inform you that your PowerSportz academy account has been successfully created!\n\n";

        // Compose the email
        Yii::$app->mailer->compose()
            ->setFrom(['no-reply@powersportz.tv' => 'PowerSportz Academy'])
            ->setTo($to)
            ->setSubject('PowerSportz Academy Login')
            ->setTextBody(
                "Dear {$username},\n\n" .  // Academy Name is the username in this case
                $intro .
                "You can now access the platform and manage your academy’s activities.\n\n" .
                "Login Details:\n" .
                "Login URL: {$loginUrl}\n" .
                "Username: {$username}\n" .
                $passwordLine .
                "\nIf you encounter any issues or need assistance, please don’t hesitate to reach out to our support team at support@powersportz.tv.\n\n" .
                "Thank you for choosing PowerSportz. We look forward to supporting your academy's growth and success!\n\n" .
                "Best regards,\n" .
                "The PowerSportz Team"
            )
            ->send();
    }
}
