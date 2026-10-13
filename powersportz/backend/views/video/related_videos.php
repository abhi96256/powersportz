<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\spinner\Spinner;

$content = '';
$placeholder = Yii::$app->request->baseUrl . '/images/thumbnail-default.jpg';
$placeholderJs = json_encode($placeholder);
$videoId = (isset($model) && !empty($model->ID)) ? (int) $model->ID : 0;
$searchUrl = Url::to(array('video/video-thumb-list'), true);

if (!empty($videosList)) {
    foreach ($videosList as $videolistsub) {
        $vid = is_object($videolistsub) ? $videolistsub->VideoID : (isset($videolistsub['VideoID']) ? $videolistsub['VideoID'] : '');
        $imageName = is_object($videolistsub) ? $videolistsub->ImageName : (isset($videolistsub['ImageName']) ? $videolistsub['ImageName'] : '');
        $imageType = is_object($videolistsub) ? $videolistsub->ImageType : (isset($videolistsub['ImageType']) ? $videolistsub['ImageType'] : 1);
        $title = is_object($videolistsub)
            ? (isset($videolistsub->Title) ? $videolistsub->Title : '')
            : (isset($videolistsub['Title']) ? $videolistsub['Title'] : '');

        if ($title === '' && !empty($vid)) {
            $vm = \backend\models\Video::find()->select('Title')->where(array('ID' => $vid))->one();
            $title = $vm ? $vm->Title : '';
        }

        $thumbSrc = ($imageName != '') ? ImagesUrl(array('ImageName' => $imageName, 'ImageType' => $imageType)) : $placeholder;

        $content .= '<div class="video_block col-lg-3 col-sm-4 col-xs-6" data-title="' . Html::encode(strtolower($title)) . '">'
            . '<input type="checkbox" name="videothumb" class="videothumbchkbox" value="' . Html::encode($vid) . '">'
            . '<img class="thumbnail img-responsive related-video-thumb" src="' . Html::encode($thumbSrc) . '" '
            . 'onerror="this.onerror=null;this.src=' . $placeholderJs . ';" '
            . 'style="width:100%;height:120px;object-fit:cover;background:#222;">'
            . '<p>' . Html::encode($title) . '</p></div>';
    }
}
$addvideobutton = Html::label('Add Related Videos', '', array('class' => 'addrelatedvideo btn btn-primary', 'style' => 'cursor:pointer'));
?>

<div class="modal fade bs-example-modal-lg filterPopupModel" id="RelatedVideoModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
     data-search-url="<?= Html::encode($searchUrl) ?>" data-video-id="<?= (int) $videoId ?>">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left" style="padding-top: 7.5px;"> Related Videos </h4>
                    <div class="pull-right">
                        <input type="text" id="related_videos_input" class="form-control videoname filterInput" placeholder="Type to search..." style="width:400px;display:inline-block;" autocomplete="off">
                        <a title="Clear text" class="clear_text" href="javascript:void(0);" id="related_videos_clear">
                            <span class="close_icon glyphicon glyphicon-remove"></span>
                        </a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="alert alert-info" style="margin-bottom:10px;">Type karte hi results dikhenge — Enter dabane ki zarurat nahi.</div>
                    <div class="alert alert-danger addvdoslcterrshw" style="display:none">Please Select Video</div>
                    <div class="displaycontetnForRelatedVideo"><?= $content; ?></div>
                </div>
                <div class="panel-footer"><?= $addvideobutton; ?>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div id="spinnerLoaderForRelatedVideo" style="display:none;">
        <?php echo Spinner::widget(array('preset' => Spinner::LARGE, 'color' => 'blue', 'align' => 'center')); ?>
    </div>
</div>
<?php
$this->registerJs(<<<'JS'
(function(){
  var $modal = $("#RelatedVideoModel");
  var searchUrl = $modal.data("search-url");
  var videoId = $modal.data("video-id") || 0;
  var placeholder = $modal.find(".related-video-thumb").first().attr("onerror") ? "" : "";
  var initialHtml = null;
  var timer = null;
  var reqSeq = 0;

  function ensureInitial() {
    if (initialHtml === null) {
      initialHtml = $(".displaycontetnForRelatedVideo").html();
    }
  }

  function appendItem($wrapper, item, keptIds) {
    if (!item || !item.VideoID) return;
    if (keptIds[item.VideoID] || $wrapper.find('input:checkbox[value="'+item.VideoID+'"]').length) return;
    var src = item.thumbUrl || "";
    var title = item.Title || "";
    var html = '<div class="video_block col-lg-3 col-sm-4 col-xs-6" data-title="'+$("<div/>").text((title||"").toLowerCase()).html()+'">'
      + '<input type="checkbox" name="videothumb" class="videothumbchkbox" value="'+item.VideoID+'">'
      + '<img class="thumbnail img-responsive" style="width:100%;height:120px;object-fit:cover;background:#222;" src="'+src+'" onerror="this.style.opacity=0.3">'
      + '<p>'+$("<div/>").text(title).html()+'</p></div>';
    $wrapper.append(html);
  }

  function runSearch(q) {
    ensureInitial();
    var $wrapper = $(".displaycontetnForRelatedVideo");
    q = $.trim(q || "");
    if (q === "") {
      $wrapper.html(initialHtml);
      return;
    }
    // Instant local filter first
    if (typeof filterPopup === "function") {
      filterPopup($("#related_videos_input"));
    }
    var kept = {};
    $wrapper.find("input:checkbox:checked").each(function(){ kept[$(this).val()] = true; });
    var seq = ++reqSeq;
    $("#spinnerLoaderForRelatedVideo").show();
    $.ajax({
      url: searchUrl,
      type: "GET",
      dataType: "json",
      cache: false,
      data: { q: q, id: videoId },
      success: function(items) {
        if (seq !== reqSeq) return;
        var checkedHtml = [];
        $wrapper.find(".video_block").each(function(){
          if ($(this).find("input:checkbox").is(":checked")) {
            checkedHtml.push($(this).clone(true));
          }
        });
        $wrapper.empty();
        $.each(checkedHtml, function(i, el){ $wrapper.append(el); });
        if ($.isArray(items) && items.length) {
          $.each(items, function(i, item){ appendItem($wrapper, item, kept); });
        } else if (!checkedHtml.length) {
          $wrapper.html('<div class="col-xs-12">No Records Found</div>');
        }
      },
      complete: function() {
        if (seq === reqSeq) $("#spinnerLoaderForRelatedVideo").hide();
      }
    });
  }

  $(document).off("keyup.psRel input.psRel paste.psRel", "#related_videos_input")
    .on("keyup.psRel input.psRel paste.psRel", "#related_videos_input", function(){
      var q = $.trim($(this).val() || "");
      ensureInitial();
      if (typeof filterPopup === "function") { filterPopup($(this)); }
      clearTimeout(timer);
      timer = setTimeout(function(){ runSearch(q); }, 200);
    });

  $(document).off("click.psRel", "#related_videos_clear").on("click.psRel", "#related_videos_clear", function(e){
    e.preventDefault();
    $("#related_videos_input").val("");
    runSearch("");
  });

  $modal.on("shown.bs.modal", function(){ ensureInitial(); });
})();
JS
);
?>
