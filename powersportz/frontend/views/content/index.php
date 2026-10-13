<?php

use yii\helpers\Html;
use yii\web\View;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $this yii\web\View */
$this->title = $title . ' | Power Sportz';
$this->params['breadcrumbs'][] = $this->title;
?>
<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700" rel="stylesheet">
<div class="col-md-10 single-page">   
  <div class="col-md-12 content-data">
    <?php
    echo $description;
    ?>            
  </div>
</div>
<script type="text/javascript">
  try {
    ga('send', {
      hitType: 'pageview', title: '<?php echo $title ?>', location: location.pathname
    });
  } catch (e) {
    console.log(e);
  }
</script>