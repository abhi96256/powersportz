<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;

Modal::begin([
    'header' => '<h2>Embeded Snippet</h2>',
    'id' => 'my-embed-modal',
    'footer' => Html::button(Yii::t('app', 'Copy To Clipboard'), ['class' => 'click-to-copy']),
    'toggleButton' => ['label' => 'Click Here To Get Live Tv Snippet', ['class' => 'btn btn-primary btn btn-info']],


]);
?>
<h2>Live TV Embed</h2>
<textarea id="copy-to-clipboard" readonly="readonly"><?= htmlentities('<iframe src="' . Yii::$app->params['domainName'] . 'embed/live-tv" frameborder="0"  ></iframe>') ?></textarea>
<h2>Player 1 Embed</h2>
<textarea id="copy-to-clipboard" readonly="readonly"><?= htmlentities('<iframe src="' . Yii::$app->params['domainName'] . 'embed/live-tv?id=1" frameborder="0"  ></iframe>') ?></textarea>
<h2>Player 2 Embed</h2>
<textarea id="copy-to-clipboard" readonly="readonly"><?= htmlentities('<iframe src="' . Yii::$app->params['domainName'] . 'embed/live-tv?id=2" frameborder="0"  ></iframe>') ?></textarea>
<h2>Player 3 Embed</h2>
<textarea id="copy-to-clipboard" readonly="readonly"><?= htmlentities('<iframe src="' . Yii::$app->params['domainName'] . 'embed/live-tv?id=3" frameborder="0"  ></iframe>') ?></textarea>
<?php
Modal::end();
$this->registerCss('#my-embed-modal .modal-dialog{z-index:9999}');
$this->registerJs('      
    $(".click-to-copy").click(function(e){
        e.preventDefault();
        /* Select the text field */
        console.log($("#copy-to-clipboard").text());
        $("#copy-to-clipboard").select();
        /* Copy the text inside the text field */
        document.execCommand("copy");
        $(this).text("Copied To Clipboard").attr("disabled","disabled");
    });    
    ');
?>