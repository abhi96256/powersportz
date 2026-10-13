<?php

use yii\helpers\Html;

$this->title = 'Download Certificates';
$this->params['breadcrumbs'][] = $this->title;

$studentName = isset($studentName) ? (string) $studentName : '';
$certificates = isset($certificates) && is_array($certificates) ? $certificates : [];
$showClassColumn = false;
foreach ($certificates as $certificate) {
    $classVal = trim((string) (isset($certificate['class']) ? $certificate['class'] : ''));
    $sectionVal = trim((string) (isset($certificate['section']) ? $certificate['section'] : ''));
    if ($classVal !== '' || $sectionVal !== '') {
        $showClassColumn = true;
        break;
    }
}
?>

<div class="row">
    <div class="certificate-download-page">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="certificate-student-summary">
            <div><span class="certificate-student-label">Name:</span> <?= Html::encode($studentName !== '' ? $studentName : '-') ?></div>
            <div><span class="certificate-student-label">Email:</span> <?= Html::encode($email) ?></div>
        </div>

        <div class="table-responsive certificate-table-wrap">
            <table class="table table-bordered table-striped certificate-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Certificate ID</th>
                        <th>Programme</th>
                        <?php if ($showClassColumn) : ?> <th>Class</th> <?php endif; ?>
                        <th>Level</th>
                        <th>School</th>
                        <th>Academic Year</th>
                        <th>Date of Completion</th>
                        <th>Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($certificates)) : ?>
                        <tr>
                            <td colspan="9" class="text-center">No certificates available.</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($certificates as $index => $certificate) : ?>
                            <?php
                                $classText = trim((string) (isset($certificate['class']) ? $certificate['class'] : ''));
                                $sectionText = trim((string) (isset($certificate['section']) ? $certificate['section'] : ''));
                                if ($sectionText !== '') {
                                    $classText = $classText !== '' ? $classText . ' / ' . $sectionText : $sectionText;
                                }
                            ?>
                            <tr>
                                <td><?= (int) $index + 1 ?></td>
                                <td><?= Html::encode(isset($certificate['certificate_id']) ? $certificate['certificate_id'] : '-') ?></td>
                                <td><?= Html::encode(isset($certificate['programme_name']) ? $certificate['programme_name'] : '-') ?></td>
                                <?php if ($showClassColumn) : ?>
                                    <td><?= Html::encode($classText !== '' ? $classText : '-') ?></td>
                                <?php endif; ?>
                                <td><?= Html::encode(isset($certificate['level_completed']) ? $certificate['level_completed'] : '-') ?></td>
                                <td><?= Html::encode(isset($certificate['school_name']) ? $certificate['school_name'] : '-') ?></td>
                                <td><?= Html::encode(isset($certificate['academic_year']) ? $certificate['academic_year'] : '-') ?></td>
                                <td><?= Html::encode(isset($certificate['date_of_completion']) ? $certificate['date_of_completion'] : '-') ?></td>
                                <td><?= Html::encode(isset($certificate['type']) ? $certificate['type'] : 'Certificate') ?></td>
                                <td>
                                    <?php if (!empty($certificate['download_url'])) : ?>
                                        <?= Html::a('View Certificate', $certificate['download_url'], [
                                            'class' => 'btn btn-primary btn-sm certificate-action-btn',
                                            'target' => '_blank',
                                            'rel' => 'noopener noreferrer',
                                        ]) ?>
                                        <?= Html::a('Download', $certificate['download_url'], [
                                            'class' => 'btn btn-default btn-sm certificate-action-btn',
                                            'download' => true,
                                            'rel' => 'noopener noreferrer',
                                        ]) ?>
                                    <?php else : ?>
                                        -
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
.certificate-download-page {
    max-width: 1100px;
    margin: 50px auto;
    background: #767778;
    padding: 20px 24px 26px;
}
.certificate-download-page h1 {
    color: #fff;
    margin: 0 0 16px;
}
.certificate-student-summary {
    margin: 10px 0 16px;
    padding: 10px 12px;
    background: #f1f1f1;
    color: #222;
}
.certificate-student-label {
    font-weight: 600;
}
.certificate-table-wrap {
    background: #fff;
    margin-top: 8px;
}
.certificate-table {
    margin-bottom: 0;
}
.certificate-table th {
    background: #e9e9e9;
    font-size: 12px;
    white-space: nowrap;
    color: #000000;
}
.certificate-table td {
    font-size: 12px;
    vertical-align: middle !important;
    color: #000000;
}
.certificate-table .btn-primary {
    background: #c01616;
    border-color: #c01616;
    color: #fff !important;
}
</style>
