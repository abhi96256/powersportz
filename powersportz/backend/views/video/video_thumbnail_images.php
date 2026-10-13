<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\spinner\Spinner;

$content = '';
$placeholder = Yii::$app->request->baseUrl . '/images/thumbnail-default.jpg';
$placeholderJs = json_encode($placeholder);
$searchUrl = Url::to(array('video/thumb-image-list'), true);

if (!empty($VideoThumbImageList)) {
    foreach ($VideoThumbImageList as $videolistsub) {
        $videothumb = isset($videolistsub['ImageName']) ? $videolistsub['ImageName'] : '';
        $title = isset($videolistsub['Title']) ? $videolistsub['Title'] : '';
        $imageId = isset($videolistsub['ImageID']) ? $videolistsub['ImageID'] : '';
        if ($videothumb != '') {
            $src = Html::encode(ImagesUrl($videolistsub));
            $videothumbpage = '<img class="thumbnail img-responsive" style="width:100%;height:120px;object-fit:cover;background:#222;" src="' . $src . '" onerror="this.onerror=null;this.src=' . $placeholderJs . ';">';
        } else {
            $videothumbpage = Html::img('@web/images/thumbnail-default.jpg', array(
                'class' => 'thumbnail img-responsive',
                'style' => 'width:100%;height:120px;object-fit:cover;',
            ));
        }
        $content .= '<div class="video_block col-lg-3 col-sm-4 col-xs-6" data-title="' . Html::encode(strtolower($title)) . '">'
            . '<input type="checkbox" name="videothumbimages" class="videothumbimagechkbox videothumbchkbox" value="' . Html::encode($imageId) . '">'
            . $videothumbpage
            . '<p>' . Html::encode($title) . '</p></div>';
    }
}
$addthumbImagesbutton = Html::label('Add Thumb Images', '', array('class' => 'addthumbimages btn btn-primary', 'style' => 'cursor:pointer'));
?>
<div class="modal fade bs-example-modal-lg filterPopupModel" id="VideoThumbnailImageModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
     data-search-url="<?= Html::encode($searchUrl) ?>">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left" style="padding-top: 7.5px;"> Video Thumbnail </h4>
                    <div class="pull-right">
                        <input type="text" id="videoThumbnailImage_input" class="form-control videoname filterInput" placeholder="Type to search..." style="width:400px;display:inline-block;" autocomplete="off">
                        <a title="Clear text" class="clear_text" href="javascript:void(0);" id="videoThumbnailImage_clear">
                            <span class="close_icon glyphicon glyphicon-remove"></span>
                        </a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="alert alert-info" style="margin-bottom:10px;">Type karte hi results dikhenge — Enter dabane ki zarurat nahi.</div>
                    <div class="alert alert-danger addvdoslcterrshw" style="display:none">Please Select Thumb Images</div>
                    <div class="displaycontetnForThumbImages" id="thumbImagesInitial"><?= $content; ?></div>
                </div>
                <div class="panel-footer"><?= $addthumbImagesbutton; ?>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div id="spinnerLoaderForThumbImages" style="display:none;">
        <?php echo Spinner::widget(array('preset' => Spinner::LARGE, 'color' => 'blue', 'align' => 'center')); ?>
    </div>
</div>
<?php
$this->registerJs(<<<'JS'
(function(){
  var $modal = $("#VideoThumbnailImageModel");
  var searchUrl = $modal.data("search-url");
  var initialHtml = null;
  var timer = null;
  var reqSeq = 0;

  function ensureInitial() {
    if (initialHtml === null) {
      initialHtml = $(".displaycontetnForThumbImages").html();
    }
  }

  function appendItem($wrapper, item, keptIds) {
    if (!item || !item.ImageID) return;
    if (keptIds[item.ImageID] || $wrapper.find('input:checkbox[value="'+item.ImageID+'"]').length) return;
    var src = item.thumbUrl || "";
    var title = item.Title || "";
    var html = '<div class="video_block col-lg-3 col-sm-4 col-xs-6" data-title="'+$("<div/>").text((title||"").toLowerCase()).html()+'">'
      + '<input type="checkbox" name="videothumbimages" class="videothumbimagechkbox videothumbchkbox" value="'+item.ImageID+'">'
      + '<img class="thumbnail img-responsive" style="width:100%;height:120px;object-fit:cover;background:#222;" src="'+src+'" onerror="this.style.opacity=0.3">'
      + '<p>'+$("<div/>").text(title).html()+'</p></div>';
    $wrapper.append(html);
  }

  function runSearch(q) {
    ensureInitial();
    var $wrapper = $(".displaycontetnForThumbImages");
    q = $.trim(q || "");
    if (q === "") {
      $wrapper.html(initialHtml);
      return;
    }
    if (typeof filterPopup === "function") {
      filterPopup($("#videoThumbnailImage_input"));
    }
    var kept = {};
    $wrapper.find("input:checkbox:checked").each(function(){ kept[$(this).val()] = true; });
    var seq = ++reqSeq;
    $("#spinnerLoaderForThumbImages").show();
    $.ajax({
      url: searchUrl,
      type: "GET",
      dataType: "json",
      cache: false,
      data: { q: q },
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
        if (seq === reqSeq) $("#spinnerLoaderForThumbImages").hide();
      }
    });
  }

  $(document).off("keyup.psThumb input.psThumb paste.psThumb", "#videoThumbnailImage_input")
    .on("keyup.psThumb input.psThumb paste.psThumb", "#videoThumbnailImage_input", function(){
      var q = $.trim($(this).val() || "");
      ensureInitial();
      if (typeof filterPopup === "function") { filterPopup($(this)); }
      clearTimeout(timer);
      timer = setTimeout(function(){ runSearch(q); }, 200);
    });

  $(document).off("click.psThumb", "#videoThumbnailImage_clear").on("click.psThumb", "#videoThumbnailImage_clear", function(e){
    e.preventDefault();
    $("#videoThumbnailImage_input").val("");
    runSearch("");
  });

  $modal.on("shown.bs.modal", function(){ ensureInitial(); });
})();
JS
);
?>
