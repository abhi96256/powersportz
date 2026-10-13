<?php

namespace backend\modules\academy\models;

use yii\base\Model;
use yii\web\UploadedFile;

class ImportForm extends Model
{
    public $school_id;
    public $file;

    public function rules()
    {
        return [
            [['school_id'], 'integer'],
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => ['xlsx', 'csv'], 'checkExtensionByMimeType' => false],
        ];
    }

    public function attributeLabels()
    {
        return [
            'school_id' => 'School',
            'file' => 'Excel/CSV File',
        ];
    }

    public function loadFile()
    {
        $this->file = UploadedFile::getInstance($this, 'file');
        return $this->file !== null;
    }
}
