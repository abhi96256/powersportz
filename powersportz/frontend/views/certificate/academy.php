<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'PS Academy';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="academy-intro-page">
        <div class="academy-logo">
            <img src="<?= Yii::getAlias('@web') ?>/images/Power-sportz-logo-n.png" alt="">
        </div>
        <h1 class="text-center">About Power Sportz Academy</h1>

        <p>
            Power Sportz Academy is the learning and certification arm of Power Sportz, created to bring structured
            life skills development into school sport and physical education.
        </p>

        <p>
            At the heart of the Academy is the CPD UK-accredited Sports Life Skills Framework, India's first globally
            benchmarked model designed to help students develop essential competencies through real sporting environments.
        </p>

        <p>
            A CPD UK-accredited certificate signifies that the learning pathway follows internationally recognised
            standards of structured development.
        </p>

        <p>Power Sportz Academy is built on a simple belief:</p>

        <p><strong>Life skills are best developed through performance, not lectures.</strong></p>

        <p>
            By embedding structured observation, reflection, and assessment into everyday sporting activities, the Academy
            supports holistic development without adding classroom burden or academic load.
        </p>

        <p>
            The programme aligns with the experiential and competency-based learning vision of NEP 2020.
        </p>

        <p>
            The Sports Life Skills Framework has been conceptualized by Ms Kanthi D Suresh, Founder &amp; Director, under
            the guidance of educational and sports advisors.
        </p>

        <p>
            With a strong commitment to bridging sport and education, Kanthi has led the development of a structured
            pathway that brings global accreditation standards into school sports environments, enabling recognition of
            life skills developed through participation.
        </p>

        <p>
            Certificates issued through this platform confirm successful participation in a CPD UK-accredited
            sports-integrated learning framework designed to support students' long-term personal and professional growth.
        </p>

        <div class="academy-intro-actions">
            <?= Html::a('Download Certificate', Url::toRoute('/certificate'), ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
</div>

<style>
.academy-intro-page {
    max-width: 960px;
    margin: 40px auto;
    padding: 28px 30px;
    background: #f7f7f7;
    border: 1px solid #e4e4e4;
    color: #202020;
    font-family: "Segoe UI", Tahoma, Arial, sans-serif;
    line-height: 1.65;
}
.academy-intro-page h1 {
    margin: 0 0 18px;
    font-size: 34px;
    font-weight: 700;
    color: #151515;
}
.academy-intro-page p {
    margin: 0 0 14px;
    font-size: 16px;
}
.academy-intro-actions {
    margin-top: 20px;
    text-align: center;
}
.academy-intro-actions .btn-primary {
    background: #c01616;
    border-color: #c01616;
    color: #fff !important;
    padding: 10px 22px;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}
.academy-logo {
    text-align: center;
    margin-bottom: 20px;
}

@media (max-width: 767px) {
    .academy-intro-page {
        margin: 20px 12px;
        padding: 20px 16px;
    }
    .academy-intro-page h1 {
        font-size: 26px;
    }
    .academy-intro-page p {
        font-size: 15px;
    }
}
</style>
