<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\spinner\Spinner;

$content = '';
$placeholder = Yii::$app->request->baseUrl . '/images/thumbnail-default.jpg';
$placeholderJs = json_encode($placeholder);
$videoId = (isset($model) && !empty($model->ID)) ? (int) $model->ID : 0;
$selectedFullId = (isset($model) && !empty($model->FullVideoId)) ? (int) $model->FullVideoId : 0;
$searchUrl = Url::to(array('video/video-thumb-list'));

if (!empty($videosList)) {
    foreach ($videosList as $videolistsub) {
        $vid = is_object($videolistsub) ? $videolistsub->VideoID : (isset($videolistsub['VideoID']) ? $videolistsub['VideoID'] : '');
        $imageName = is_object($videolistsub) ? $videolistsub->ImageName : (isset($videolistsub['ImageName']) ? $videolistsub['ImageName'] : '');
        $imageType = is_object($videolistsub) ? $videolistsub->ImageType : (isset($videolistsub['ImageType']) ? $videolistsub['ImageType'] : 1);
        $title = is_object($videolistsub)
            ? (isset($videolistsub->Title) ? $videolistsub->Title : '')
            : (isset($videolistsub['Title']) ? $videolistsub['Title'] : '');
        if ((int) $vid === $videoId) {
            continue;
        }
        if ($title === '' && !empty($vid)) {
            $vm = \backend\models\Video::find()->select('Title')->where(array('ID' => $vid))->one();
            $title = $vm ? $vm->Title : '';
        }
        $thumbSrc = ($imageName != '') ? ImagesUrl(array('ImageName' => $imageName, 'ImageType' => $imageType)) : $placeholder;
        $checked = ((int) $vid === $selectedFullId) ? ' checked="checked"' : '';
        $content .= '<div class="video_block col-lg-3 col-sm-4 col-xs-6" data-title="' . Html::encode(strtolower($title)) . '">'
            . '<input type="radio" name="fullvideo" class="videothumbradio" value="' . Html::encode($vid) . '"' . $checked . '>'
            . '<img class="thumbnail img-responsive" style="width:100%;height:120px;object-fit:cover;background:#222;" src="' . Html::encode($thumbSrc) . '" onerror="this.onerror=null;this.src=' . $placeholderJs . ';">'
            . '<p>' . Html::encode($title) . '</p></div>';
    }
}
$addvideobutton = Html::label('Add Full Video', '', array('class' => 'addfullvideo btn btn-primary', 'style' => 'cursor:pointer'));
?>
<div class="modal fade bs-example-modal-lg filterPopupModel" id="FullVideoModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title pull-left" style="padding-top: 7.5px;"> Full Video </h4>
                    <div class="pull-right">
                        <input type="text" id="full_video_input" class="form-control videoname filterInput" placeholder="Enter Video Title ..." style="width:400px;display:inline-block;">
                        <a title="Clear text" class="clear_text" href="javascript:void(0);" id="full_video_clear">
                            <span class="close_icon glyphicon glyphicon-remove"></span>
                        </a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="alert alert-info" style="margin-bottom:10px;">Video title type karo — list me se radio select karke Add dabao.</div>
                    <div class="alert alert-danger addvdoslcterrshw" style="display:none">Please Select Video</div>
                    <div class="displaycontetnForFullVideo"><?= $content; ?></div>
                </div>
                <div class="panel-footer"><?= $addvideobutton; ?>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div id="spinnerLoaderForFullVideo" style="display:none;">
        <?php
        echo Spinner::widget(array(
            'preset' => Spinner::LARGE,
            'color' => 'blue',
            'align' => 'center',
        ));
        ?>
    </div>
</div>
<?php
$this->registerJs('
(function(){
  var searchUrl = ' . json_encode($searchUrl) . ';
  var videoId = ' . (int) $videoId . ';
  var placeholder = ' . $placeholderJs . ';
  var initialHtml = null;
  var timer = null;

  function ensureInitial() {
    if (initialHtml === null) {
      initialHtml = $(".displaycontetnForFullVideo").html();
    }
  }

  function keepCheckedBlocks($wrapper) {
    var kept = [];
    $wrapper.find(".video_block").each(function(){
      if ($(this).find("input:radio").is(":checked")) {
        kept.push($(this).clone(true));
      }
    });
    return kept;
  }

  function appendFullItem($wrapper, item) {
    if (!item || !item.VideoID) { return; }
    if ($wrapper.find(\'input:radio[value="\'+item.VideoID+\'"]\').length) { return; }
    var src = item.thumbUrl || "";
    var title = item.Title || item.MetaKeywords || "";
    var html = \'<div class="video_block col-lg-3 col-sm-4 col-xs-6" data-title="\'+$("<div/>").text((title||"").toLowerCase()).html()+\'">\'
      + \'<input type="radio" name="fullvideo" class="videothumbradio" value="\'+item.VideoID+\'">\'
      + \'<img class="thumbnail img-responsive" style="width:100%;height:120px;object-fit:cover;background:#222;" src="\'+src+\'" onerror="this.onerror=null;this.src=\\\'\'+placeholder+\'\\\';">\'
      + \'<p>\'+$("<div/>").text(title).html()+\'</p></div>\';
    $wrapper.append(html);
  }

  function runFullSearch(q) {
    ensureInitial();
    var $wrapper = $(".displaycontetnForFullVideo");
    q = $.trim(q || "");
    if (q === "") {
      $wrapper.html(initialHtml);
      return;
    }
    var kept = keepCheckedBlocks($wrapper);
    $("#spinnerLoaderForFullVideo").show();
    $.ajax({
      url: searchUrl,
      type: "GET",
      dataType: "json",
      data: { q: q, id: videoId },
      success: function(items) {
        $wrapper.empty();
        $.each(kept, function(i, el){ $wrapper.append(el); });
        if ($.isArray(items) && items.length) {
          $.each(items, function(i, item){ appendFullItem($wrapper, item); });
        } else if (!kept.length) {
          $wrapper.html("<div class=\\"col-xs-12\\">No Records Found</div>");
        }
      },
      error: function() {
        $wrapper.html(initialHtml);
        $wrapper.find(".video_block").each(function(){
          var t = (($(this).attr("data-title") || $(this).find("p").text() || "") + "").toLowerCase();
          $(this).toggle(t.indexOf(q.toLowerCase()) !== -1);
        });
      },
      complete: function() {
        $("#spinnerLoaderForFullVideo").hide();
      }
    });
  }

  $(document).on("keyup input", "#full_video_input", function(){
    var q = $.trim($(this).val() || "");
    ensureInitial();
    clearTimeout(timer);
    timer = setTimeout(function(){ runFullSearch(q); }, 300);
  });

  $(document).on("click", "#full_video_clear", function(e){
    e.preventDefault();
    $("#full_video_input").val("");
    runFullSearch("");
  });

  $("#FullVideoModel").on("shown.bs.modal", function(){
    ensureInitial();
  });
})();
');
?>
