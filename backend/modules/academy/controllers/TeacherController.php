<?php

namespace backend\modules\academy\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
use backend\modules\academy\models\Teacher;
use backend\modules\academy\models\School;
use backend\modules\academy\models\ImportForm;
use backend\modules\academy\components\CertificateService;
use yii\db\Query;

class TeacherController extends BaseController
{
    public function actionDownload($id, $inline = 1)
    {
        $this->requireAdminOrSchool();
        $model = Teacher::findOne($id);
        if ($model === null) {
            throw new \yii\web\NotFoundHttpException('Record not found.');
        }

        // Access check for School logins
        if ((int)Yii::$app->user->identity->UserType === 3) {
            $school = $this->getSchoolForUser();
            if ($school === null || (int)$model->school_id !== (int)$school->id) {
                throw new \yii\web\ForbiddenHttpException('Access denied.');
            }
        }

        $schoolRow = (new Query())
            ->select(['name', 'principal'])
            ->from('academy_school')
            ->where(['id' => $model->school_id])
            ->one();
        $schoolName = is_array($schoolRow) && isset($schoolRow['name']) ? $schoolRow['name'] : '';
        $schoolPrincipal = is_array($schoolRow) && isset($schoolRow['principal']) ? $schoolRow['principal'] : '';

        $html = $this->renderPartial('_certificate', [
            'record' => $model,
            'type' => 'teacher',
            'schoolName' => $schoolName ?: '',
            'schoolPrincipal' => $schoolPrincipal ?: '',
        ]);

        $certificateService = new CertificateService();
        $backgroundPath = Yii::getAlias('@backend') . '/web/images/teacher-certificate-bg-n.png';
        
        $pdfContent = $certificateService->renderPdfFromHtml($html, $backgroundPath);

        return Yii::$app->response->sendContentAsFile(
            $pdfContent,
            'teacher_certificate_' . $model->certificate_id . '.pdf',
            [
                'mimeType' => 'application/pdf',
                'inline' => (bool)$inline,
            ]
        );
    }

function get_client_ip() { $ipaddress = ''; if (getenv('HTTP_CLIENT_IP')) $ipaddress = getenv('HTTP_CLIENT_IP'); else if(getenv('HTTP_X_FORWARDED_FOR')) $ipaddress = getenv('HTTP_X_FORWARDED_FOR'); else if(getenv('HTTP_X_FORWARDED')) $ipaddress = getenv('HTTP_X_FORWARDED'); else if(getenv('HTTP_FORWARDED_FOR')) $ipaddress = getenv('HTTP_FORWARDED_FOR'); else if(getenv('HTTP_FORWARDED')) $ipaddress = getenv('HTTP_FORWARDED'); else if(getenv('REMOTE_ADDR')) $ipaddress = getenv('REMOTE_ADDR'); else $ipaddress = 'UNKNOWN'; return $ipaddress; }
    public function actionIndex()
    {
        $this->requireAdminOrSchool();
        $query = Teacher::find();
        $userType = (int) Yii::$app->user->identity->UserType;
        $schoolId = (int) Yii::$app->request->get('school_id');
        $school = null;
        if ($userType === 3) {
            $school = $this->getSchoolForUser();
            if ($school !== null) {
                $query->andWhere(['school_id' => $school->id]);
            } else {
                $query->andWhere('1=0');
                Yii::$app->session->setFlash('error', 'No school is linked to this login.');
            }
        } else {
            if ($schoolId > 0) {
                $school = School::findOne($schoolId);
                $query->andWhere(['school_id' => $schoolId]);
            }
        }

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => ['id' => SORT_ASC],
            ],
        ]);

        if ($error = Yii::$app->request->get('error')) {
            Yii::$app->session->setFlash('error', $error);
        }
        if ($success = Yii::$app->request->get('success')) {
            Yii::$app->session->setFlash('success', $success);
        }

        return $this->render('index', [
            'dataProvider' => $provider,
            'school' => $school,
        ]);
    }

    public function actionCreate()
    {
        $this->requireSchool();
        $model = new Teacher();
        $school = $this->getSchoolForUser();
        if ($school === null) {
            Yii::$app->session->setFlash('error', 'No school is linked to this login.');
            return $this->redirect(['index']);
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->school_id = $school ? $school->id : null;
            $model->created_at = date('Y-m-d H:i:s');
            $model->updated_at = $model->created_at;
            $model->status = 1;
            $model->save(false);
            Yii::$app->session->setFlash('success', 'Teacher created.');
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'school' => $school,
        ]);
    }

    public function actionUpload()
    {
        $this->requireAdminOrSchool();

        $form = new ImportForm();
        $userType = (int) Yii::$app->user->identity->UserType;
        $schoolId = (int) Yii::$app->request->get('school_id');
        $school = null;

        if ($userType === 3) {
            $school = $this->getSchoolForUser();

            if ($school === null) {
                Yii::$app->session->setFlash('error', 'No school is linked to this login.');
                return $this->redirect(['index']);
            }
        } else {
            if ($schoolId > 0) {
                $school = School::findOne($schoolId);
            }

            if ($school === null) {
                Yii::$app->session->setFlash('error', 'Please select a school to upload.');
                return $this->redirect(['/academy/school/index']);
            }
        }

        if ($form->load(Yii::$app->request->post())) {
            $form->school_id = $school->id;
            $form->loadFile();

            if ($form->validate()) {
                $isAdminUpload = ((int) Yii::$app->user->identity->UserType === 1) ? 1 : 0;

                $result = $this->importExcel($form->school_id, $form->file, $isAdminUpload);

                $redirectParams = ['index', 'school_id' => $school->id];

                if (!empty($result['errors'])) {
                    $redirectParams['error'] = implode(' <br> ', $result['errors']);
                    return $this->redirect($redirectParams);
                }

                $message = "Imported {$result['created']} teachers, updated {$result['updated']}, skipped {$result['skipped']}.";

                $redirectParams['success'] = $message;

                return $this->redirect($redirectParams);
            }
        }

        return $this->render('upload', [
            'model' => $form,
            'school' => $school,
        ]);
    }

    private function importExcel($schoolId, UploadedFile $file, $isAdminUpload)
    {
        $created = 0;
        $updated = 0;
        $skipped = 0;
        $errors = [];

        if ($schoolId === null) {
            return [
                'created' => 0,
                'updated' => 0,
                'skipped' => 0,
                'errors' => ['Please select a school.']
            ];
        }

        $dir = Yii::getAlias('@backend') . '/../upload/academy/imports';

        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        $path = $dir . '/' . time() . '_' . $file->baseName . '.' . $file->extension;
        $file->saveAs($path);

        $rows = $this->readExcelRows($path);

        if (file_exists($path)) {
            @unlink($path);
        }

        if ($rows === null) {
            return [
                'created' => 0,
                'updated' => 0,
                'skipped' => 0,
                'errors' => ['Unable to read Excel file.']
            ];
        }

        if (empty($rows)) {
            return [
                'created' => 0,
                'updated' => 0,
                'skipped' => 0,
                'errors' => ['The uploaded sheet is empty.']
            ];
        }

        $header = null;
        $rowIndex = 0;
        $preparedRows = [];
        $sheetCertificateIds = [];

        $requiredFields = [
            'name' => 'Name',
            'email' => 'Email',
            'levels_covered' => 'Levels Covered',
            'cpd_hours' => 'CPD Hours',
            'programme_name' => 'Programme Name',
            'academic_year' => 'Academic Year',
            'date_of_completion' => 'Date of Completion',
        ];

        foreach ($rows as $row) {
            $rowIndex++;

            if ($rowIndex === 1) {
                $header = $this->normalizeHeader($row);
                $validationError = $this->validateRequiredColumns($header);

                if ($validationError !== null) {
                    return [
                        'created' => 0,
                        'updated' => 0,
                        'skipped' => 0,
                        'errors' => [$validationError]
                    ];
                }

                continue;
            }

            $data = $this->mapRow($header, $row);

            if ($this->isRowEmpty($data)) {
                $skipped++;
                continue;
            }

            $data['email'] = $this->normalizeEmail($data['email']);
            $data['certificate_id'] = trim((string) $data['certificate_id']);

            $missingFields = $this->getMissingRequiredFields($data, $requiredFields);

            if (!empty($missingFields)) {
                $this->addGroupedError(
                    $errors,
                    'missing required values for ' . implode(', ', $missingFields) . '.',
                    $rowIndex
                );
                continue;
            }

            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $this->addGroupedError(
                    $errors,
                    'invalid email format.',
                    $rowIndex
                );
                continue;
            }

            $normalizedDate = $this->normalizeDateOfCompletion($data['date_of_completion']);

            if ($normalizedDate === null) {
                $this->addGroupedError(
                    $errors,
                    'Date of Completion must be in DD/MM/YYYY, DD-MM-YYYY, DD/MM/YY or DD-MM-YY format.',
                    $rowIndex
                );
                continue;
            }

            $data['date_of_completion'] = $normalizedDate;

            if ($data['certificate_id'] !== '') {
                $certificateKey = strtoupper($data['certificate_id']);

                if (isset($sheetCertificateIds[$certificateKey])) {
                    $this->addGroupedError(
                        $errors,
                        "duplicate Certificate ID '{$data['certificate_id']}' also used in row {$sheetCertificateIds[$certificateKey]}.",
                        $rowIndex
                    );
                    continue;
                }

                $sheetCertificateIds[$certificateKey] = $rowIndex;
            }

            $teacher = null;

            if ($data['certificate_id'] !== '') {
                $teacher = Teacher::findOne([
                    'certificate_id' => $data['certificate_id'],
                    'school_id' => $schoolId
                ]);
            }

            if ($teacher === null) {
                $teacher = Teacher::findOne([
                    'school_id' => $schoolId,
                    'email' => $data['email']
                ]);
            }

            if ($data['certificate_id'] !== '') {
                $certificateOwner = Teacher::findOne([
                    'certificate_id' => $data['certificate_id'],
                    'school_id' => $schoolId
                ]);

                if (
                    $certificateOwner !== null &&
                    ($teacher === null || (int) $certificateOwner->id !== (int) $teacher->id)
                ) {
                    $this->addGroupedError(
                        $errors,
                        "Certificate ID '{$data['certificate_id']}' already exists for another teacher in this school.",
                        $rowIndex
                    );
                    continue;
                }
            }

            $preparedRows[] = [
                'row' => $rowIndex,
                'data' => $data,
                'model' => $teacher,
            ];
        }

        if (!empty($errors)) {
            return [
                'created' => 0,
                'updated' => 0,
                'skipped' => $skipped,
                'errors' => $this->buildGroupedErrorMessages($errors, 20),
            ];
        }

        if (empty($preparedRows)) {
            return [
                'created' => 0,
                'updated' => 0,
                'skipped' => $skipped,
                'errors' => ['No valid rows found to import.'],
            ];
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            foreach ($preparedRows as $preparedRow) {
                $rowData = $preparedRow['data'];
                $rowNumber = $preparedRow['row'];
                $teacher = $preparedRow['model'];

                $isNew = false;

                if ($teacher === null) {
                    $teacher = new Teacher();
                    $teacher->school_id = $schoolId;
                    $teacher->created_at = date('Y-m-d H:i:s');
                    $created++;
                    $isNew = true;
                } else {
                    $updated++;
                }

                if ($isNew) {
                    if ($rowData['certificate_id'] === '') {
                        $teacher->certificate_id = $this->generateCertificateId($schoolId);
                    } else {
                        $teacher->certificate_id = $rowData['certificate_id'];
                        $this->syncCertificateSequence($schoolId, $teacher->certificate_id);
                    }
                } else {
                    $teacher->certificate_id = $teacher->getOldAttribute('certificate_id');

                    if (!empty($teacher->certificate_id)) {
                        $this->syncCertificateSequence($schoolId, $teacher->certificate_id);
                    }
                }

                $teacher->name = $rowData['name'];
                $teacher->email = $rowData['email'];
                $teacher->levels_covered = $rowData['levels_covered'];
                $teacher->cpd_hours = $rowData['cpd_hours'];
                $teacher->programme_name = $rowData['programme_name'];
                $teacher->academic_year = $rowData['academic_year'];
                $teacher->date_of_completion = $rowData['date_of_completion'];

                $teacher->status = 1;
                $teacher->is_admin_upload = $isAdminUpload;
                $teacher->updated_at = date('Y-m-d H:i:s');

                if (!$teacher->save(false)) {
                    throw new \Exception("Row {$rowNumber}: failed to save.");
                }
            }

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();

            Yii::error('Teacher import failed: ' . $e->getMessage(), __METHOD__);

            return [
                'created' => 0,
                'updated' => 0,
                'skipped' => $skipped,
                'errors' => [$e->getMessage()],
            ];
        }

        return [
            'created' => $created,
            'updated' => $updated,
            'skipped' => $skipped,
            'errors' => []
        ];
    }

    private function addGroupedError(&$errors, $message, $rowIndex)
    {
        if (!isset($errors[$message])) {
            $errors[$message] = [];
        }

        $errors[$message][] = $rowIndex;
    }

    private function buildGroupedErrorMessages(array $errors, $maxRowsToShow = 20)
    {
        $messages = [];

        foreach ($errors as $message => $rows) {
            $totalRows = count($rows);
            $visibleRows = array_slice($rows, 0, $maxRowsToShow);

            $rowText = implode(', ', $visibleRows);

            if ($totalRows > $maxRowsToShow) {
                $rowText .= ' and ' . ($totalRows - $maxRowsToShow) . ' more';
            }

            $messages[] = 'Rows ' . $rowText . ': ' . $message;
        }

        return $messages;
    }

    private function isRowEmpty(array $data)
    {
        foreach ($data as $value) {
            if (trim((string) $value) !== '') {
                return false;
            }
        }

        return true;
    }

    private function normalizeEmail($email)
    {
        return strtolower(trim((string) $email));
    }

    private function getMissingRequiredFields(array $data, array $requiredFields)
    {
        $missing = [];
        foreach ($requiredFields as $key => $label) {
            if (!isset($data[$key]) || trim((string) $data[$key]) === '') {
                $missing[] = $label;
            }
        }

        return $missing;
    }

    private function normalizeDateOfCompletion($value)
    {
        $value = trim((string) $value);

        if ($value === '') {
            return null;
        }

        $formats = [
            'd/m/Y',
            'd-m-Y',
            'd/m/y',
            'd-m-y',
        ];

        foreach ($formats as $format) {
            $date = \DateTime::createFromFormat($format, $value);
            $dateErrors = \DateTime::getLastErrors();

            if ($date === false) {
                continue;
            }

            if (
                $dateErrors !== false &&
                (
                    (int) $dateErrors['warning_count'] > 0 ||
                    (int) $dateErrors['error_count'] > 0
                )
            ) {
                continue;
            }

            if ($date->format($format) !== $value) {
                continue;
            }

            return $date->format('d/m/Y');
        }

        return null;
    }

    private function readExcelRows($path)
    {
        if (!$this->loadPHPExcel()) {
            Yii::error('PHPExcel not found. Expected vendor/PHPExcel/Classes/PHPExcel/IOFactory.php', __METHOD__);
            return null;
        }
        try {
            $spreadsheet = \PHPExcel_IOFactory::load($path);
            $sheet = $spreadsheet->getActiveSheet();
            return $sheet->toArray(null, true, true, false);
        } catch (\Exception $e) {
            Yii::error('Excel read failed: ' . $e->getMessage(), __METHOD__);
            return null;
        }
    }

    private function loadPHPExcel()
    {
        if (class_exists('PHPExcel_IOFactory')) {
            return true;
        }

        $path = Yii::getAlias('@vendor') . '/PHPExcel/Classes/PHPExcel/IOFactory.php';
        if (file_exists($path)) {
            require_once $path;
            return class_exists('PHPExcel_IOFactory');
        }
        return false;
    }

    private function normalizeHeader(array $row)
    {
        $header = [];
        foreach ($row as $index => $value) {
            $key = strtolower(trim((string) $value));
            $key = preg_replace('/[^a-z0-9]+/', '_', $key);
            $key = trim($key, '_');
            $header[$index] = $key;
        }
        return $header;
    }

    private function validateRequiredColumns(array $header)
    {
        $requiredColumns = ['name', 'email', 'levels_covered', 'cpd_hours', 'programme_name', 'academic_year', 'date_of_completion'];
        $alternativeColumns = [
            'name' => ['name', 'teacher_name']
        ];
        $missingColumns = [];

        foreach ($requiredColumns as $required) {
            $found = false;
            $alternatives = isset($alternativeColumns[$required]) ? $alternativeColumns[$required] : [$required];
            
            foreach ($alternatives as $alt) {
                if (in_array($alt, $header)) {
                    $found = true;
                    break;
                }
            }
            
            if (!$found) {
                $missingColumns[] = ucfirst(str_replace('_', ' ', $required));
            }
        }

        if (!empty($missingColumns)) {
            return 'Missing required columns in the uploaded sheet: ' . implode(', ', $missingColumns);
        }

        return null;
    }

    private function mapRow(array $header, array $row)
    {
        $data = [
            'name' => '',
            'email' => '',
            'levels_covered' => '',
            'cpd_hours' => '',
            'programme_name' => '',
            'academic_year' => '',
            'date_of_completion' => '',
            'certificate_id' => '',
        ];

        foreach ($row as $index => $value) {
            $key = isset($header[$index]) ? $header[$index] : '';
            $value = trim((string) $value);

            if (in_array($key, ['name', 'teacher_name'])) {
                $data['name'] = $value;
            } elseif ($key === 'email') {
                $data['email'] = $value;
            } elseif ($key === 'levels_covered') {
                $data['levels_covered'] = $value;
            } elseif ($key === 'cpd_hours') {
                $data['cpd_hours'] = $value;
            } elseif ($key === 'programme_name') {
                $data['programme_name'] = $value;
            } elseif ($key === 'academic_year') {
                $data['academic_year'] = $value;
            } elseif ($key === 'date_of_completion') {
                $data['date_of_completion'] = $value;
            } elseif ($key === 'certificate_id') {
                $data['certificate_id'] = $value;
            }
        }

        if ($data['name'] === '' && isset($row[0])) {
            $data['name'] = trim((string) $row[0]);
        }
        if ($data['email'] === '' && isset($row[1])) {
            $data['email'] = trim((string) $row[1]);
        }

        return $data;
    }
    private function getSchoolForUser()
    {
        $userType = (int) Yii::$app->user->identity->UserType;
        if ($userType === 3) {
            return School::findByUserId(Yii::$app->user->id);
        }
        return null;
    }

    private function syncCertificateSequence($schoolId, $certificateId)
    {
        if (preg_match('/^T(\d{2})(\d+)$/i', $certificateId, $matches)) {
            $year = (int)$matches[1];
            $sequenceNo = (int)$matches[2];

            $db = \Yii::$app->db;
            $db->createCommand(
                "INSERT INTO teacher_certificate_sequences (year, school_id, last_no)
                VALUES (:year, :school_id, :last_no)
                ON DUPLICATE KEY UPDATE last_no = GREATEST(last_no, :last_no)",
                [':year' => $year, ':school_id' => $schoolId, ':last_no' => $sequenceNo]
            )->execute();
        }
    }

    // Generate certificate-id if not provided
    public function generateCertificateId_x($schoolId) 
    {
        do {
            $id = 'HIPSA-SLS-' . date('Y') . '-' . $schoolId . '-' . strtoupper(bin2hex(openssl_random_pseudo_bytes(4)));
            $exists = Teacher::find()->where(['certificate_id' => $id])->exists();
        } while($exists);

        return $id;
    }

    public function generateCertificateId($schoolId)
    {
        $db = \Yii::$app->db;
        $year = (int)date('y');                  
        $prefix = 'T' . sprintf('%02d', $year);  

        return $db->transaction(function($db) use ($schoolId, $year, $prefix) {

            // Ensure sequence row exists
            $db->createCommand(
                "INSERT INTO teacher_certificate_sequences (year, school_id, last_no)
                VALUES (:year, :school_id, 0)
                ON DUPLICATE KEY UPDATE last_no = last_no",
                [':year' => $year, ':school_id' => $schoolId]
            )->execute();

            // Atomically increment and fetch the new number
            $db->createCommand(
                "UPDATE teacher_certificate_sequences
                SET last_no = LAST_INSERT_ID(last_no + 1)
                WHERE year = :year AND school_id = :school_id",
                [':year' => $year, ':school_id' => $schoolId]
            )->execute();

            $next = (int)$db->createCommand("SELECT LAST_INSERT_ID()")->queryScalar();

            // Format: T26000001 (6 digits)
            $number = str_pad((string)$next, 6, '0', STR_PAD_LEFT);
            return $prefix . $number;
        });
    }
}





