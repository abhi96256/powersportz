<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'PS Academy';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="acad-outer">

    <!-- Top: Logo + Title -->
    <div class="acad-header">
        <img src="<?= Yii::getAlias('@web') ?>/images/desktop_logo1.png" alt="Power Sportz" class="acad-header-logo">
        <h1>About Power Sportz Academy</h1>
    </div>

    <!-- Main 2-column layout -->
    <div class="acad-main-row">

        <!-- LEFT: Text Content -->
        <div class="acad-left">
            <p>Power Sportz Academy is the learning and certification arm of Power Sportz, created to bring structured life skills development into school sport and physical education.</p>

            <p>At the heart of the Academy is the <strong>CPD UK-accredited Sports Life Skills Framework</strong>, India's first globally benchmarked model designed to help students develop essential competencies through real sporting environments.</p>

            <p>A CPD UK-accredited certificate signifies that the learning pathway follows internationally recognised standards of structured development.</p>

            <p>Power Sportz Academy is built on a simple belief:</p>
            <p class="acad-belief">&ldquo;Life skills are best developed through performance, not lectures.&rdquo;</p>

            <p>By embedding structured observation, reflection, and assessment into everyday sporting activities, the Academy supports holistic development without adding classroom burden or academic load.</p>

            <p>The programme aligns with the experiential and competency-based learning vision of <strong>NEP 2020</strong>.</p>

            <p>The Sports Life Skills Framework has been conceptualized by <strong>Ms Kanthi D Suresh</strong>, Founder &amp; Director, under the guidance of educational and sports advisors.</p>

            <p>Certificates issued through this platform confirm successful participation in a CPD UK-accredited sports-integrated learning framework designed to support students&rsquo; long-term personal and professional growth.</p>

            <div class="acad-btns">
                <?= Html::a('&#11123; Download Certificate', Url::toRoute('/certificate'), ['class' => 'acad-btn-red']) ?>
            </div>
        </div>

        <!-- RIGHT: Premium QR Panel -->
        <div class="acad-right">
            <div class="acad-qr-panel">
                <div class="acad-qr-badge">CPD UK ACCREDITED</div>
                <div class="acad-qr-title">Verify Accreditation</div>
                <div class="acad-qr-sub">Scan QR Code to verify our CPD UK certification</div>

                <div class="acad-qr-imgs">
                    <div class="acad-qr-item">
                        <img src="<?= Yii::getAlias('@web') ?>/images/CPD UK Accreditation QR-2.png" alt="CPD QR Code">
                    </div>
                </div>

                <div class="acad-qr-accno">
                    <span class="acad-acc-label">Accreditation No.</span>
                    <span class="acad-acc-number">788856</span>
                </div>

                <div class="acad-qr-tagline">Authentic &bull; Transparent &bull; Trusted</div>
            </div>
        </div>

    </div><!-- end acad-main-row -->

</div><!-- end acad-outer -->

<style>
/* ===== OUTER WRAPPER ===== */
.acad-outer {
    max-width: 1020px;
    margin: 36px auto 40px;
    font-family: "Segoe UI", Tahoma, Arial, sans-serif;
    color: #202020;
}

/* ===== HEADER ===== */
.acad-header {
    text-align: center;
    padding: 28px 24px 20px;
    background: #fff;
    border: 1px solid #e2e2e2;
    border-bottom: none;
    border-radius: 8px 8px 0 0;
}
.acad-header-logo {
    max-width: 100px;
    height: auto;
    margin-bottom: 14px;
}
.acad-header h1 {
    font-size: 30px;
    font-weight: 800;
    color: #111;
    margin: 0;
}

/* ===== MAIN ROW ===== */
.acad-main-row {
    display: flex;
    gap: 0;
    border: 1px solid #e2e2e2;
    border-radius: 0 0 8px 8px;
    overflow: hidden;
}

/* ===== LEFT COLUMN ===== */
.acad-left {
    flex: 1.5;
    background: #fafafa;
    padding: 28px 30px;
    line-height: 1.7;
    font-size: 15px;
    color: #2a2a2a;
    border-right: 1px solid #e2e2e2;
}
.acad-left p {
    margin: 0 0 13px;
}
.acad-belief {
    font-style: italic;
    font-size: 16px !important;
    color: #c01616;
    font-weight: 600;
    border-left: 3px solid #c01616;
    padding-left: 12px;
    margin: 14px 0 !important;
}
.acad-btns {
    margin-top: 22px;
    display: flex;
    justify-content: center;
    gap: 12px;
    flex-wrap: wrap;
}
.acad-btn-red {
    display: inline-block;
    background: #c01616;
    color: #fff !important;
    padding: 10px 22px;
    border-radius: 4px;
    font-weight: 700;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    text-decoration: none;
    transition: background 0.2s;
}
.acad-btn-red:hover { background: #a01010; }
.acad-btn-outline {
    display: inline-block;
    border: 2px solid #c01616;
    color: #c01616 !important;
    padding: 9px 20px;
    border-radius: 4px;
    font-weight: 600;
    font-size: 14px;
    text-decoration: none;
    transition: all 0.2s;
}
.acad-btn-outline:hover { background: #c01616; color: #fff !important; }

/* ===== RIGHT COLUMN: Premium QR Panel ===== */
.acad-right {
    flex: 0 0 290px;
    background: linear-gradient(160deg, #0d1b3e 0%, #1a2f5e 60%, #0d1b3e 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 30px 20px;
}
.acad-qr-panel {
    text-align: center;
    color: #fff;
    width: 100%;
}
.acad-qr-badge {
    display: inline-block;
    background: #c01616;
    color: #fff;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 2px;
    padding: 5px 14px;
    border-radius: 20px;
    margin-bottom: 14px;
    text-transform: uppercase;
}
.acad-qr-title {
    font-size: 20px;
    font-weight: 800;
    color: #fff;
    margin-bottom: 5px;
    letter-spacing: 0.3px;
}
.acad-qr-sub {
    font-size: 12px;
    color: #a8c0e0;
    margin-bottom: 20px;
    line-height: 1.5;
}
.acad-qr-imgs {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 14px;
    margin-bottom: 20px;
}
.acad-qr-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 7px;
}
.acad-qr-item img {
    width: 140px;
    height: 140px;
    object-fit: contain;
    border-radius: 8px;
    background: #fff;
    padding: 6px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.4);
}
.acad-qr-item span {
    font-size: 11px;
    color: #7aa8d8;
    font-weight: 600;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}
.acad-qr-divider {
    width: 1px;
    height: 60px;
    background: rgba(255,255,255,0.15);
    flex-shrink: 0;
}
.acad-qr-accno {
    background: rgba(255,255,255,0.08);
    border-radius: 6px;
    padding: 10px 14px;
    margin-bottom: 14px;
    display: flex;
    flex-direction: column;
    gap: 3px;
}
.acad-acc-label {
    font-size: 10px;
    color: #8ab0d8;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    font-weight: 600;
}
.acad-acc-number {
    font-size: 22px;
    font-weight: 900;
    color: #fff;
    letter-spacing: 2px;
}
.acad-qr-tagline {
    font-size: 11px;
    color: #6a96c4;
    letter-spacing: 0.8px;
    font-style: italic;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 767px) {
    .acad-main-row {
        flex-direction: column;
    }
    .acad-right {
        flex: none;
        padding: 28px 16px;
    }
    .acad-left {
        padding: 20px 16px;
        border-right: none;
        border-bottom: 1px solid #e2e2e2;
    }
    .acad-header h1 {
        font-size: 22px;
    }
    .acad-qr-item img {
        width: 90px;
        height: 90px;
    }
}
</style>
