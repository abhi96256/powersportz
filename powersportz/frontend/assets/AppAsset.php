<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/style1.css',
        'css/responsive-v2.css',
        'css/custom-scrollbar.css',
        'css/darkstyle1.css',
        'css/ddsmoothmenu1.css',
        'css/jquery.fancybox.css',
        'css/jquery-ui.css',
        'css/owl.carousel.css',
        'css/animate.css',        
        'css/responsiveslides.css',        
        //'css/common.css',
        'font-awesome/css/font-awesome.min.css',
      //  'css/jquery.lazyloadxt.spinner.css'
    ];
    public $js = [
        //'js/modernizr.custom.js',
        //'js/jquery.lazy_content.js',
        'js/owl.carousel.js',
        //'js/jquery.fancybox.pack.js',
        'js/nice-scroll.js',
        'js/ddsmoothmenu.js',
        //'js/jquery.selectbox-0.2.js',
        //'js/instafeed.min.js',
        //'js/wow.js',
        'js/custom.js',
        'js/responsiveslides.min.js',
        'js/bootstrap.min.js',
        'js/jquery.form.min.js',
        'js/jquery.textrotator.js',
        // 'js/jquery.lazy_content.js',
       // 'js/lazyload.min.js',
      //  'js/jquery.lazyloadxt.js',
        //'js/jwplayer.js',
        //'js/endless_scroll_min.js'
        'js/blazy.js',
        'js/closest.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
