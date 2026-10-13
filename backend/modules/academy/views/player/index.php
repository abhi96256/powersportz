<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $school backend\modules\academy\models\School|null */

$this->title = 'Academy Players';
$this->registerCss(
    ".academy-header {\n" .
    "    margin: 6px 0 5px 0;\n" .
    "}\n" .
    ".academy-switcher {\n" .
    "    display: inline-flex;\n" .
    "    gap: 8px;\n" .
    "    margin-top: 16px;\n" .
    "}\n" .
    ".academy-switcher a {\n" .
    "    display: inline-block;\n" .
    "    padding: 6px 12px;\n" .
    "    text-decoration: none;\n" .
    "    background: #f2f2f2;\n" .
    "    color: #222;\n" .
    "    border: 1px solid #d8d8d8;\n" .
    "    font-size: 13px;\n" .
    "}\n" .
    ".academy-switcher a.is-active {\n" .
    "    background: #c00f;\n" .
    "    border-color: #d9534f;\n" .
    "    color: #fff;\n" .
    "}\n" .
    ".academy-title-row {\n" .
    "    display: flex;\n" .
    "    justify-content: space-between;\n" .
    "    align-items: center;\n" .
    "    margin: 20px 0;\n" .
    "}\n" .
    ".academy-title-block {\n" .
    "    margin: 0;\n" .
    "}\n" .
    ".academy-school-name {\n" .
    "    margin: 0 0 20px 0;\n" .
    "    font-size: 34px;\n" .
    "    font-weight: 600;\n" .
    "}\n" .
    ".academy-page-title {\n" .
    "    margin: 0;\n" .
    "    font-size: 22px;\n" .
    "    font-weight: 600;\n" .
    "}\n" .
    ".academy-action {\n" .
    "    margin-left: 20px;\n" .
    "   margin-top: 36px;\n" .
    "}\n".
    ".target {
        margin-top: 4px;
    }\n"
);
$schoolId = $school ? (int) $school->id : null;
$isAdmin = (int) Yii::$app->user->identity->UserType === 1;
?>

<div class="academy-player-index">
    <div class="academy-header">
        <div class="academy-switcher">
            <?= Html::a('Student', $schoolId ? ['/academy/player/index', 'school_id' => $schoolId] : ['/academy/player/index'], [
                'class' => Yii::$app->controller->id == 'player' ? 'is-active' : '',
            ]) ?>
            <?= Html::a('Teacher', $schoolId ? ['/academy/teacher/index', 'school_id' => $schoolId] : ['/academy/teacher/index'], [
                'class' => Yii::$app->controller->id == 'teacher' ? 'is-active' : '',
            ]) ?>
        </div>
    </div>

    <div class="academy-title-row">
        <div class="academy-title-block">
            <?php if ($isAdmin && $school !== null): ?>
                <div class="academy-school-name"><?= Html::encode($school->name) ?></div>
            <?php endif; ?>
            <?= Html::tag($isAdmin ? 'h2' : 'h1', Html::encode($this->title), ['class' => 'academy-page-title']) ?>
        </div>

        <div class="academy-action">
            <?= Html::a('Upload File', $schoolId ? ['upload', 'school_id' => $schoolId] : ['upload'], ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{items}\n{pager}{summary}",
        'summaryOptions' => ['class' => 'summary pull-right'],
        'columns' => [
            'certificate_id',
            'name',
            'email',
            'class',
            'section',
            'level_completed',
            'programme_name',
            'academic_year',
            'date_of_completion',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Certificate',
                'template' => '{view} {download}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('View', ['download', 'id' => $model->id, 'inline' => 1], [
                            'class' => 'btn btn-xs btn-info target',
                            'target' => '_blank',
                            'data-pjax' => '0',
                            'title' => 'View Certificate',
                        ]);
                    },
                    'download' => function ($url, $model) {
                        return Html::a('Download', ['download', 'id' => $model->id, 'inline' => 0], [
                            'class' => 'btn btn-xs btn-info target',
                            'target' => '_blank',
                            'data-pjax' => '0',
                            'title' => 'Download Certificate',
                        ]);
                    },
                ],
            ],
        ],
    ]) ?>
</div>
