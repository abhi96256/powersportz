<?php

use yii\helpers\Html;
use yii\web\View;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $this yii\web\View */
$this->title = 'Live Score | Power Sportz';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
$mainvideovar = '';
$ruleslist = '';
$varzero = 0;
foreach ($model as $key => $rulesarray) {
  $classvar = '';
  $ismainvar = '0';
  if (Yii::$app->getRequest()->getQueryParam('tab')) {
    $rulesid = Yii::$app->getRequest()->getQueryParam('tab');
    if (in_array($rulesid, $rulesarray)) {
      $classvar = 'class="active parent-active"';
      $mainvideovar .= '<h2>' . $rulesarray['Title'] . '</h2>' . $rulesarray['Description'];
    }
  } else {
    if ($mainvideovar == '') {
      if ($varzero == 0) {
        $classvar = 'class="active parent-active"';
      }
      $mainvideovar .= '<h2>' . $model[0]['Title'] . ': </h2>' . $model[0]['Description'];
    }
  }
  $ruleslist .= '<li ' . $classvar . '><a href="' . Url::toRoute(["livescore/index", "tab" => $rulesarray['slug']]) . '"> <span>' . $rulesarray['GameName'] . '</span></a></li>';
  $varzero++;
}
?>
<div class="col-md-10 single-page">
  <div class="col-md-2" style="padding:0;">
    <div id="togglebtn">Rules</div>
    <ul class="left-menu">
      <?php
      echo $ruleslist;
      ?>
    </ul>
  </div>
  <div class="col-md-10 white-back">
    <?php
    echo $mainvideovar;
    ?>            
  </div>
</div>
<script type="text/javascript">
  try {
    ga('send', {hitType: 'pageview', title: 'Game Rules', location: location.pathname});
  } catch (e) {
    console.log(e);
  }
</script>