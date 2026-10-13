<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use kartik\spinner\Spinner;

AppAsset::register($this);
$this->registerJs('$(".selectlang").change(function () {
 var langid=$(this).val();
 $.ajax({
   type: "POST",
   url: "' . Yii::$app->urlManager->createUrl('site/changelang') . '",
   data: {lang:langid},
   dataType :"html",
   success: function(msg){
    location.reload();
  }
});
});

');
$_SESSION['language_id'] = 'eng-US';
Yii::$app->language = 'eng-US';
/* TYPE:  1-Like,2-Favourite,3-Watchlist */
$lang_code = Yii::$app->language;
if (isset($_SESSION['language_id'])) {
  $lang_code = $_SESSION['language_id'];
  Yii::$app->language = $lang_code;
}
?>

<?php $this->beginPage() ?>

<?php $this->beginContent('@app/views/layouts/header.php'); ?>
<!-- You may need to put some content here -->
<?php $this->endContent(); ?>
<section class="color-bg wow fadeInDown">
  <?= $this->render('@app/views/layouts/breadcrumb.php'); ?>

  <?= Alert::widget() ?>
  <?= $content ?>
</section>
<!--Start of Footer--> 
</div>
<section id="footer">

  <!--Footer Copyright-->
  <div class="footer-copyright">
    <div class="container-fluid">
      <div class="row">
        <div class="left_side font_hide_show">

          <ul class="left_ul">
            <li class="left_li"><a target="_blank" class="fotter_a" href="https://www.facebook.com/PowerSportzTV/"><i class="fa fa-facebook"></i></a></li>
            <li class="left_li"><a target="_blank" class="fotter_a" href=" https://twitter.com/powersportz_tv">     <i class="fa fa-twitter"></i></a></li>
            <li class="left_li"><a target="_blank" class="fotter_a" href=" https://www.youtube.com/c/PowerSportzTV"><i class="fa fa-youtube"></i></a></li>
            <li class="left_li"><a target="_blank" class="fotter_a" href="https://www.instagram.com/powersportztv/"><i class="fa fa-instagram"></i></a></li>
         
            <li ><a target="_blank" class="fotter_a" href="https://play.google.com/store/apps/details?id=sportz.com.power_sportz"><img alt="Android APP"  src="https://www.powersportz.tv/images/social/android.png" /></a></li>
            <li ><a target="_blank" class="fotter_a" href="https://itunes.apple.com/in/app/power-sportz/id1445112511?mt=8"><img alt="Apple iOS APP"  src="https://www.powersportz.tv/images/social/apple.png" /></a></li>
         </ul>
        </div>
        <!--<div class="col-md-11 footer-copy">-->
        <div class="col-md-3 col-sm-12 col-xs-11 main_section">

          <ul class="fotter_ul font_show_hide">
              <li class="fotter_li"><a target="_blank" class="fotter_a" href="https://www.facebook.com/PowerSportzTV/"><img alt="Facebook" src="/images/social/facebook.png" /></a></li>
              <li class="fotter_li"><a target="_blank" class="fotter_a" href="https://twitter.com/powersportz_tv"><img alt="Twitter" src="/images/social/twitter.png"/></a></li>
            <li class="fotter_li"><a target="_blank" class="fotter_a" href=" https://www.youtube.com/c/PowerSportzTV"><img alt="Youtube" src="/images/social/youtube.png"/></a></li>
            <li class="fotter_li"><a target="_blank" class="fotter_a" href="https://www.instagram.com/powersportztv/"><img alt="Instagram" src="/images/social/instagram.png"/></a></li>
            <li class="fotter_li"><a target="_blank" class="fotter_a" href="https://play.google.com/store/apps/details?id=sportz.com.power_sportz"><img alt="Android APP"  width="25px" src="https://www.powersportz.tv/images/social/android.png"/></a></li>
         <li class="fotter_li"><a target="_blank" class="fotter_a" href="https://itunes.apple.com/in/app/power-sportz/id1445112511?mt=8"><img width="25px" alt="Apple iOS APP"  src="https://www.powersportz.tv/images/social/apple.png"/></a></li>
         
          </ul>
        </div>

        <div class="col-md-6 col-sm-12 col-xs-12 main_section">
          <div class="footer-menu pull-left">




           
		   

            <ul>
              <?php /*
                <li> <?php if(isset($_SESSION['language_id'])){
                $language = $_SESSION['language_id'];
                }else
                {
                $language = Yii::$app->language;
                }?>
                <?= Html::dropDownList('land_id',$language,\frontend\models\Langauge::getActiveLanguageList(),['class'=>'selectlang','style':'color:#000']); ?>
                </li>
               */ ?>
               
                <li>              <?php
                /*
                if (Yii::$app->user->isGuest) {
                echo '<a href="'.Url::toRoute('member/login').'">'.Yii::t('frontend','PS Talent Hunt').'</a>';
                }
                else {
                echo '<a href="'.Url::toRoute('member/logout').'">'.Yii::t('frontend','Logout').'('.Yii::$app->user->identity->UserName .')</a>';
                echo '<a href="'.Url::toRoute('member/myprofile').'">'.Yii::t('frontend','myprofile').'</a>';
                }*/
                ?> </li>  
              <li><a href="<?php echo Url::toRoute('/about-us') ?>"><?php echo Yii::t('frontend', 'About Us'); ?></a></li>
              <li><a href="<?php echo Url::toRoute('/contact-us') ?>"><?php echo Yii::t('frontend', 'Contact Us'); ?></a></li>
              <li><a target="_blank" href="https://powersportz.com/">PS Magazine</a></li>
              <li><a href="<?php echo Url::toRoute('/privacy-policy') ?>"><?php echo Yii::t('frontend', 'Privacy policy'); ?></a></li>
              <li><a href="<?php echo Url::toRoute('/terms-and-conditions') ?>"><?php echo Yii::t('frontend', 'Terms & Conditions'); ?></a></li>


            </ul></div>

          <!--
                               <div class="pull-right my-account">
                                      <div class="log-in">
                        
                                      </div></div> -- >
          
                                      <!--<p class="pull-right">mail@powersports.com   |  (555) 654 - 8765</p>-->
        </div>
      </div>
	  <?php
	/*      
$connect = mysqli_connect("172.31.5.144", "powersport", "Dgt569khd", "powersport");

           $sql_slot="select sum(ViewCount) as sumview from video  ";

           if ($result_slot=mysqli_query($connect,$sql_slot))
  {
 
  while ($row_slot=mysqli_fetch_row($result_slot))
    {
 
      $n=$row_slot[0]+78000000;
    }
  }
  
  $number = $n;

if ($number < 1000000) {
    // Anything less than a million
    $format = number_format($number);
} else if ($number < 1000000000) {
    // Anything less than a billion
    $format = number_format($number / 1000000, 2) . 'M';
} else {
    // At least a billion
    $format = number_format($number / 1000000000, 2) . 'B';
}
  
  
  */
	  ?>
	  
      <p class="copy-right"><?php echo Yii::t('frontend', 'copyright'); ?></p>
	<!--  <p class="copy-right">Visitors : <i><b><?php echo $format; ?></b></i></p> -->
    </div>
  </div>
  <div class="clear"></div>
  <!--Footer Copyright-->

</section>
<!--End of Footer--> 

<div class="water-mark"> </div>
<div id="spinnerLoader" style="display:none;">
  <?php
  echo Spinner::widget([
      'preset' => Spinner::LARGE,
      'color' => 'blue',
      'align' => 'center'
  ]);
  ?>
</div> 
<?php // $this->registerJs('$("img.lazyload").lazyload();'); ?>

<?php $this->endBody() ?> 
<?php
$controller = Yii::$app->controller;
$default_controller = Yii::$app->defaultRoute;
$isHome = (($controller->id === $default_controller) && ($controller->action->id === $controller->defaultAction)) ? true : false;
//if(!in_array($_SERVER['REMOTE_ADDR'], ['192.168.1.118','103.8.43.78'])){
?>
<script type="text/javascript">

  $(document).on('ready', function () {
    setTimeout(function () {
      var bLazy = new Blazy({
        selector: "img.lazyload",
        success: function (ele) {
          $(ele).removeClass('lazy-hidden').addClass('lazy-loaded');
        }, error: function (ele, msg) {

          if (msg === 'missing') {
            ele.src = '<?= Yii::$app->getUrlManager()->getBaseUrl() . '/images/placeholder.png' ?>';
            $(ele).removeClass('lazy-hidden').addClass('lazy-loaded').addClass('has-error');
          } else if (msg === 'invalid') {
            ele.src = '<?= Yii::$app->getUrlManager()->getBaseUrl() . '/images/placeholder.png' ?>';
            $(ele).removeClass('lazy-hidden').addClass('lazy-loaded').addClass('has-error');

          }
        }
      });
    }, 500);

  });

  $(window).on('ajaxComplete', function () {
    setTimeout(function () {
      var bLazy = new Blazy({
        selector: "img.lazyload",
        success: function (ele) {
          $(ele).removeClass('lazy-hidden').addClass('lazy-loaded');
        }, error: function (ele, msg) {

          if (msg === 'missing') {
            ele.src = '<?= Yii::$app->getUrlManager()->getBaseUrl() . '/images/placeholder.png' ?>';
            $(ele).removeClass('lazy-hidden').addClass('lazy-loaded').addClass('has-error');
          } else if (msg === 'invalid') {
            ele.src = '<?= Yii::$app->getUrlManager()->getBaseUrl() . '/images/placeholder.png' ?>';
            $(ele).removeClass('lazy-hidden').addClass('lazy-loaded').addClass('has-error');

          }
        }
      });
    }, 500);

  });

</script> 
<?php // } ?>
<script type="text/javascript">
  $(document).ready(function () {
    $('.favourite-icon-wrap').find('.watch-later,.favourite,.like,.share').
            tooltip();
  });

</script>
</body>

</html>
<?php $this->endPage() ?>