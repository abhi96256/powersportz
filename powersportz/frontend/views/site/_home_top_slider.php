<?php
/**
 * Home top section slider — items from backend TOP HOME SECTION (homepage_top_section).
 * MainVideoType: 1 = recorded video, 2 = external stream, 3 = banner image
 *
 * @var array $TopSectionItems
 */
if (empty($TopSectionItems) || !is_array($TopSectionItems)) {
    return;
}

$slides = array();
foreach ($TopSectionItems as $item) {
    $type = (string)(isset($item['MainVideoType']) ? $item['MainVideoType'] : '');
    $thumb = trim((string)(isset($item['ExternalVideoThumb']) ? $item['ExternalVideoThumb'] : ''));
    if ($type === '1' && $thumb !== '') {
        $poster = CDN_VIDEO_URL . ltrim($thumb, '/');
    } elseif ($thumb !== '') {
        $poster = S3_THUMB_CLOUDFRONT . '/' . THUMBNAILS . '/' . ltrim($thumb, '/');
    } else {
        $poster = Yii::$app->getUrlManager()->getBaseUrl() . '/images/placeholder.png';
    }
    $slides[] = array(
        'type' => $type,
        'poster' => $poster,
        'videoUrl' => trim((string)(isset($item['ExternalVideoURL']) ? $item['ExternalVideoURL'] : '')),
        'link' => trim((string)(isset($item['ExternalRedirectLink']) ? $item['ExternalRedirectLink'] : '')),
        'id' => (int)(isset($item['HomeID']) ? $item['HomeID'] : 0),
    );
}

if (empty($slides)) {
    return;
}
?>
<div id="homeTopCarousel" class="carousel slide home-top-carousel" data-ride="carousel" data-interval="6000" data-pause="hover">
  <ol class="carousel-indicators">
    <?php foreach ($slides as $i => $slide): ?>
      <li data-target="#homeTopCarousel" data-slide-to="<?php echo $i; ?>" class="<?php echo $i === 0 ? 'active' : ''; ?>"></li>
    <?php endforeach; ?>
  </ol>
  <div class="carousel-inner" role="listbox">
    <?php foreach ($slides as $i => $slide): ?>
      <div class="item <?php echo $i === 0 ? 'active' : ''; ?>" data-slide-type="<?php echo htmlspecialchars($slide['type']); ?>">
        <?php if ($slide['type'] === '3'): ?>
          <?php if ($slide['link'] !== ''): ?>
            <a href="<?php echo htmlspecialchars($slide['link']); ?>" target="_blank" rel="noopener">
              <img class="home-top-slide-img" src="<?php echo htmlspecialchars($slide['poster']); ?>" alt="Banner" onerror="this.onerror=null;this.src='<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/images/placeholder.png';">
            </a>
          <?php else: ?>
            <img class="home-top-slide-img" src="<?php echo htmlspecialchars($slide['poster']); ?>" alt="Banner" onerror="this.onerror=null;this.src='<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/images/placeholder.png';">
          <?php endif; ?>
        <?php else: ?>
          <div class="home-top-video-wrap">
            <video
              id="homeTopVideo<?php echo (int)$slide['id']; ?>"
              class="video-js vjs-default-skin vjs-big-play-centered home-top-video"
              controls
              preload="none"
              playsinline
              poster="<?php echo htmlspecialchars($slide['poster']); ?>"
              data-src="<?php echo htmlspecialchars($slide['videoUrl']); ?>"
            ></video>
          </div>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>
  <?php if (count($slides) > 1): ?>
    <a class="left carousel-control" href="#homeTopCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#homeTopCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  <?php endif; ?>
</div>
<?php
$js = <<<'JS'
(function () {
  var players = {};

  function initVideo($el) {
    var id = $el.attr('id');
    if (!id || players[id] || typeof videojs === 'undefined') return;
    var src = $el.attr('data-src');
    if (!src) return;
    var player = videojs(id, {
      controls: true,
      autoplay: false,
      preload: 'none',
      fluid: true,
      sources: [{ src: src, type: 'application/x-mpegURL' }]
    });
    players[id] = player;
    player.on('play', function () {
      $('#homeTopCarousel').carousel('pause');
      Object.keys(players).forEach(function (pid) {
        if (pid !== id && players[pid] && !players[pid].paused()) {
          players[pid].pause();
        }
      });
    });
  }

  $('.home-top-video').each(function () {
    initVideo($(this));
  });

  $('#homeTopCarousel').on('slide.bs.carousel', function () {
    Object.keys(players).forEach(function (pid) {
      if (players[pid] && !players[pid].paused()) {
        players[pid].pause();
      }
    });
  });
})();
JS;
$this->registerJs($js, \yii\web\View::POS_READY);
?>
