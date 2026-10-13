        <?php
        use yii\helpers\Html;
        use yii\web\View;
        use yii\helpers\Url;
        use frontend\controllers\SearchController;
        /* @var $this yii\web\View */
        $this->title = 'Search Results';
        $this->params['breadcrumbs'][] = $this->title;
        $this->registerJsFile('../js/jquery.lazy_content.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
        $this->registerJs(' /* $(".lazyvideosection").lazyContent({
         threshold: 50,
         load: function(element) {
             element.find(".loading").hide();
             element.find("img").each(function() {
                 var $img = $(this);
                 $img.attr("src", $img.data("src"));
                 $img.load(function() { $img.addClass("loaded") });
             });
             element.find(".lazyvideopost").show();
         }
     }); */ ', View::POS_READY);
        $request = Yii::$app->request;
        $videoid = $request->get('Video');
        ?>
        <div class="col-md-11 single-page">  
            <div class="col-md-12">
                <div class="playlists-wraper">
                    <div class="search-heading">
                        <h1>Search Results</h1>
                    </div>  
                    <div class="search_result">
                        <h4>Search Keyword: <span style="color:aqua"><?php echo $videoid;?></span></h4>
                        <?php
                        $videosearchvar='';
                        if(!empty($videoDetails))
                        {
                         foreach($videoDetails as $videoDetailssub)
                         {
                            $videotitle=$videoDetailssub['Title'];
                            $videodescription=$videoDetailssub['description'];
                            $newvideodescription=SearchController::highlight($videodescription,$videoid);
                            $newvideotitle=SearchController::highlight($videotitle,$videoid);
                            echo '<div class="playlists-single-wraper ">
                            <div class="col-md-3 playlists-img-wraper video-image-box">
                            <img  src="'. Yii::$app->getUrlManager()->getBaseUrl().'/images/site-lazy.png" data-src="'.ImagesUrl($videoDetailssub).'" style="width:100%;" alt="" class="lazyload lazy-hidden" onerror="this.error=false;this.src=\''.Yii::$app->getUrlManager()->getBaseUrl().'/images/placeholder.png\'" />
                            <a href="'.Url::toRoute(['/'.$videoDetailssub['slug'].'-'.$videoDetailssub['ID']]).'"><span class="vd-button"></span>
                            </a>
                            </div>          
                            <div class="col-md-8 search-name-wraper">
                            <a href="'.Url::toRoute(['/'.$videoDetailssub['slug'].'-'.$videoDetailssub['ID']]).'"><h1>'.$newvideotitle.'</h1></a>
                            <p>'.$newvideodescription.'</p>
                            </div></div>';
                        }
                    }
                    else
                    {
                        echo '<div>'.Yii::t('frontend','NoRecordsearch').'</div>';   
                    }
                    ?>
                    </div></div></div></div>