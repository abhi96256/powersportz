<?php

/* @var $this \yii\web\View */
/* @var $content string */
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use kartik\spinner\Spinner;
use yii\helpers\Url;

AppAsset::register($this);
$session = Yii::$app->session;
$userType = $session->get('userType');
?>
<?php header('Access-Control-Allow-Origin: *'); ?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
<style>
#spinnerLoader {
    background: rgba(3, 0, 0, 0.48) none repeat scroll 0 0;
    cursor: pointer;
    display: block;
    height: 100%;
    left: 0;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 9;
}
#spinnerLoaderForPopup {
    background: rgba(3, 0, 0, 0.48) none repeat scroll 0 0;
    cursor: pointer;
    display: block;
    height: 100%;
    left: 0;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 9;
}
</style>
</head>
<body>
<?php $this->beginBody() ?>
<?php //echo str_replace(,"/",str_replace("backend","frontend",\Yii::$app->basePath)); ?>
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Power Sportz',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    /*if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems = [
            ['label' => 'Home', 'url' => ['/homepage/update']],
        ];
        
         
        $menuItems[] = [
            'label' => 'Thumbnail',
            'url' => ['/images/index'],
            'active'=>Yii::$app->controller->id == 'image',
        ];
       
         $menuItems[] = [
            'label' => 'Video',
            'items' =>  [
                            ['label' => 'Video', 'url' => ['/video/index'],'active'=>Yii::$app->controller->id == 'video'],
                            ['label' => 'Schedule', 'url' =>['/schedule/index'],'active'=>Yii::$app->controller->id == 'schedule'],
                            ['label' => 'Playlist', 'url' =>['/playlist/index'],'active'=>Yii::$app->controller->id == 'playlist'],
                            ['label' => 'Category', 'url' =>['/category/index'],'active'=>Yii::$app->controller->id == 'category'],
                            ['label' => 'Action', 'url' =>['/topics/index'],'active'=>Yii::$app->controller->id == 'topics'],
                        ],
        ];
        
        $menuItems[] = [
            'label' => 'Contents',
            'items' => [
                    ['label' => 'Breaking News', 'url' => ['/breakingnews/index'],'active'=>Yii::$app->controller->id == 'breakingnews'],
                    ['label' => 'Advertisement', 'url' =>['/advertisements/index'],'active'=>Yii::$app->controller->id == 'advertisements'],
                    ['label' => 'Custom Advertisement', 'url' =>['/customadvertisement/index'],'active'=>Yii::$app->controller->id == 'customadvertisement'],
                    ['label' => 'GameRules', 'url' =>['/gamerule/index'],'active'=>Yii::$app->controller->id == 'gamerule'],
                    ],
        ];
       
        $menuItems[] = [
            'label' => 'Subscriber',
            'url' => ['/member/index'],
            'active'=>Yii::$app->controller->id == 'member',
        ];
         
        $menuItems[] = [
            'label' => 'Staff Role',
            'url' => ['/user-role/index'],
        ];
        $menuItems[] = [
            'label' => 'Staff User',
            'url' => ['/staff/index'],
            'active'=>Yii::$app->controller->id == 'staff'
        ];
        $menuItems[] = [
            'label' => 'Admin User',
            'url' => ['/user/index'],
            'active'=>Yii::$app->controller->id == 'user',
        ];
        $menuItems[] = [
            'label' => 'Logout (' . Yii::$app->user->identity->UserName . ')',
            'url' => ['/site/logout'],
            'linkOptions' => ['data-method' => 'post']
        ];       
    }*/
    $menuItems = backend\models\Homepage::SetRoleBasedHeaderMenu();
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?php /*echo Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]);*/ ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>
<div id="spinnerLoader" style="display:none;">
<?php echo Spinner::widget([
                'preset' => Spinner::LARGE,
                'color' => 'blue',
                'align' => 'center'
        ]);
?>
</div>    
    
<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Power Sportz <?= date('Y') ?></p>
    </div>
</footer>    
<?php $this->endBody() 
?>
<script>    
$('.alert').delay(2000).slideUp();
$(document).on('pjax:send', function() {
    $("#spinnerLoader").show();
})    
$(document).on('pjax:complete', function() {
    $("#spinnerLoader").hide();
});

$("#w0").on("afterValidate", function (event, messages) {
    //console.log(messages);
    var count = 0;
     $.each(messages, function(key, value) {
        if(typeof value[0] !='undefined' && value[0]!='') {
            count++;
        }
    });
    if(count == 0) {
        $("#spinnerLoader").show();  
    }
});

function showloader() {
    var errorSummary = $(".error-summary ul").html();
    if(errorSummary == '') {
        $("#spinnerLoader").show();  
    }    
}

 function shareonSocial(msg){
    $('.shared_video').each( function() {
        if($(this).is(':checked')){
            var description = msg.videoDesc;
            var redirect_link = "https://testvideoout.s3.amazonaws.com/Videos/Thumb/Thumb_Videos_33_1446878140907_00001.png";//msg.VideoURL,
            var picture = msg.thumbimage;
            var title = msg.videoTitle;

            if($(this).val() == 0){
                     var params = {
                          description : description,
                          link :redirect_link,
                          picture : picture,
                          name : title,
                           source : redirect_link
                    };
                     FB.api('/me/feed', 'post',params 
                         , function(response) {
                              if (!response || response.error) {
                                alert("Couldn't Publish Dat'");
                              } 
              });
            }else if($(this).val() == 1){
                     var payload = {
                          "content": {
                            "title": title,
                            "description": description,
                            "submitted-url": redirect_link,  
                            "submitted-image-url": picture
                          },
                          "visibility": {
                            "code": "anyone"
                          }  
                        };
                    console.log(payload);
                    IN.API.Raw("/people/~/shares?format=json")
                      .method("POST")
                      .body(JSON.stringify(payload))
                      .result(function(){ console.log("test"); })
                      .error(function(error){ console.log(error); });
           }else if($(this).val() == 2){

           }else if($(this).val() == 3){
                console.log("login");
                 var options = {
                  contenturl: 'https://plus.google.com/pages/',
                  contentdeeplinkid: '/pages',
                  clientid: '10412981768-7q9q88kkdmm1b529mg9aktk7gb1nhe22.apps.googleusercontent.com',
                 // cookiepolicy: 'single_host_origin',
                  prefilltext: 'Create your Google+ Page too!',
                  calltoactionlabel: 'CREATE',
                  calltoactionurl: 'http://plus.google.com/pages/create',
                  calltoactiondeeplinkid: '/pages/create'
                };
                // Call the render method when appropriate within your app to display
                // the button.
                gapi.interactivepost.render('sharePost', options);
           }
           else if($(this).val() == 4){
                var options = {
                  note: description,
                  link: redirect_link, // where the pin is from
                  image_url: picture // the image url
                }
                PDK.request('/pins/', 'POST', options, function(response) {
                  if (!response || response.error) {
                    alert('The pin was not created');
                  } else {
                    var pin = response.data;
                    console.log(pin);
                  }
                });
           }
        }
    });
 }

  //gapi.client.setApiKey(apiKey);

$("#customad-post-form").on('beforeSubmit', function (e) {
            $("#customad-post-form").find('.form-group').removeClass('has-error');
            $("#customad-post-form").find('.form-group .help-block').text('');
            var shortVideo = $("#video-videourl").val();
            var fullVideo = $("#video-fullvideourl").val();
            $("#spinnerLoader").show();
            var updatedID = '<?php if(isset($_GET['id']) && $_GET['id']!='') { echo $_GET['id']; } ?>';
            if(shortVideo == '' && updatedID == '') {
                alert('Please upload video');
                return false;
            }
           
            if(updatedID == '')  { 
                    var URL  = '<?php echo Url::toRoute('customadvertisement/createajax'); ?>';
                    var datastring = $("#customad-post-form").serialize();
                    
            } else {         
                    var URL  = '<?php echo Url::toRoute('customadvertisement/updateajax'); ?>';
                    var datastring = $("#customad-post-form").serialize();
                    datastring+='&id='+updatedID;
            }
            $.ajax({
                        type : 'POST',
                        url : URL,
                        data : datastring,
                        dataType: 'json',
                        async: false, 
                        success : function(msg) {
                            $("#spinnerLoader").hide();
                            if(msg.status == 'ok') {

                              //  shareonSocial(msg);
                                var file = [];
                                var bucket = new AWS.S3({params: {Bucket: '<?php echo S3BUCKET; ?>'}});
                                var fileChooser = document.getElementById('customadvertisement-videourl');
                               
                                if (fileChooser.files) {
                                  var file = fileChooser.files[0];
                                }
                    
                              
                                if(file!='' && file!=undefined) {
                                        /**** Short video ******/

                                        bucket.listObjects({
                                            Bucket: '<?= S3BUCKETFORVIDEO ?>', /* required */
                                            Prefix: '<?= VIDEOS."/Thumb/" ?>'+msg.id
                                          }, function(err, data) {
                                            if (err){
                                              console.log(err, err.stack); // an error occurred
                                            } else{
                                              var arr = new Array();
                                              $.each(data.Contents, function(item, key_name){
                                                  var jsonArg1 = new Object();
                                                      jsonArg1.Key = key_name.Key;

                                                    arr.push(jsonArg1);
                                              });
                                         
                                                 bucket.deleteObjects({
                                                  Bucket: '<?= S3BUCKETFORVIDEO ?>', 
                                                  Delete: { 
                                                    Objects: arr,
                                                    Quiet: true || false
                                                  },
                                                  }, function(err, data) {
                                                      if (err) console.log(err, err.stack); // an error occurred
                                                      else     console.log(data);           // successful response
                                                });
                                            }            // successful response
                                          });
                                         var bucket = new AWS.S3({params: {Bucket: '<?php echo S3BUCKET; ?>'}});                                      
                                          var updatedFile = fileChooser.files[0]['name'];
                                          var extension = updatedFile.split('.').pop();
                                          var updatedFileString = $.now()+'.'+extension;
                                          var finalImageName = msg.id+'_1200'+'_'+updatedFileString;
                                          var renameFile = '<?php echo ADVIDEOS ?>/<?php echo ADVIDEOS ?>_'+finalImageName;
                                          var params = {Key: renameFile, ContentType: file.type, Body: file};
                                          
                                          $("#progressForShortVideo").show();    
                                           bucket.upload(params).on('httpUploadProgress', function(evt) {
                                          var percentage = parseInt((evt.loaded * 100) / evt.total);
                                          $("#progress-barForShortVideo")
                                              .css("width", percentage + "%")
                                              .attr("aria-valuenow", percentage)
                                              .text(percentage + "%");
                                          }).send(function(err, data) {
                                              
                                              $.ajax({
                                                  type : 'POST',
                                                  url : '<?php echo Url::toRoute('customadvertisement/updatevideo'); ?>',
                                                  data : 'id='+msg.id+'&filename='+renameFile,
                                                  dataType: 'json',
                                                  async: false, 
                                                  success : function(msgOfFile) {
                                                      if(msgOfFile.status == 'ok') {
                                                            document.location.href='<?php echo Yii::$app->urlmanager->createUrl("customadvertisement/index"); ?>'+'?id='+msg.id;
                                                      }    
                                                  }    
                                              });


                                          }); 
                                } else {
                                  
                                        document.location.href='<?php echo Url::toRoute('customadvertisement/index'); ?>';
                                }    
                            } else {
                              $.each(msg, function (key, val) {
                                wrapper = $('[name="Customadvertisement['+key+']"]').closest(".form-group");
                                wrapper.addClass('has-error');
                                wrapper.find('.help-block').text(val);
                              });
                                // alert("Something went wrong");
                                return false;
                            }
                      }
            });
            return false;
});
$("#video-post-form").on('beforeSubmit', function (e) {
            // Sync CKEditor HTML into textarea before serialize/validate payload
            if (typeof CKEDITOR !== 'undefined') {
                for (var inst in CKEDITOR.instances) {
                    if (CKEDITOR.instances.hasOwnProperty(inst)) {
                        try { CKEDITOR.instances[inst].updateElement(); } catch (err) {}
                    }
                }
            }

            var shortVideo = $("#video-videourl").val();
            var fullVideo = $("#video-fullvideourl").val();
            $("#spinnerLoader").show();
            var updatedID = '<?php if(isset($_GET['id']) && $_GET['id']!='') { echo $_GET['id']; } ?>';
            if(shortVideo == '' && updatedID == '') {
                alert('Please upload video');
                $("#spinnerLoader").hide();
                return false;
            }
            var SVID = '<?= (!empty($_GET["svid"])) ? $_GET["svid"] : "" ?>';
            if(updatedID == '')  { 
                    var URL  = '<?php echo Url::toRoute('video/createajax'); ?>';
                    var datastring = $("#video-post-form").serialize();
                    if(SVID != ''){
                        datastring+='&SVID='+SVID;
                    }
            } else {         
                    var URL  = '<?php echo Url::toRoute('video/updateajax'); ?>';
                    var datastring = $("#video-post-form").serialize();
                    datastring+='&id='+updatedID;
            }
            // Force related/thumbnail hidden values into payload (search UI can leave serialize incomplete)
            var relIds = $("input[name='Video[IsRelatedVideoId]']").val() || '';
            var thumbIds = $("input[name='Video[IsthumbnailVideoId]']").val() || '';
            var defThumbIds = $("input[name='Video[IsDefaultthumbnailVideoId]']").val() || '';
            datastring += '&Video%5BIsRelatedVideoId%5D=' + encodeURIComponent(relIds);
            datastring += '&Video%5BIsthumbnailVideoId%5D=' + encodeURIComponent(thumbIds);
            datastring += '&Video%5BIsDefaultthumbnailVideoId%5D=' + encodeURIComponent(defThumbIds);
            $.ajax({
                        type : 'POST',
                        url : URL,
                        data : datastring,
                        dataType: 'json',
                        async: false, 
                        success : function(msg) {
                            if(msg && msg.status == 'ok') {

                                //shareonSocial(msg);
                                var file = [];
                                var bucket = new AWS.S3({params: {Bucket: '<?php echo S3BUCKET; ?>'}});
                                var fileChooser = document.getElementById('video-videourl');
                    
                                if(SVID == ''){
                                  var file = fileChooser && fileChooser.files ? fileChooser.files[0] : null;
                                }
                                if(file || SVID != '') {
                                        /**** Short video ******/

                                        bucket.listObjects({
                                            Bucket: '<?= S3BUCKETFORVIDEO ?>', /* required */
                                            Prefix: '<?= VIDEOS."/Thumb/" ?>'+msg.id
                                          }, function(err, data) {
                                            if (err){
                                              console.log(err, err.stack); // an error occurred
                                            } else{
                                              var arr = new Array();
                                              $.each(data.Contents, function(item, key_name){
                                                  var jsonArg1 = new Object();
                                                      jsonArg1.Key = key_name.Key;

                                                    arr.push(jsonArg1);
                                              });
                                         
                                                 bucket.deleteObjects({
                                                  Bucket: '<?= S3BUCKETFORVIDEO ?>', 
                                                  Delete: { 
                                                    Objects: arr,
                                                    Quiet: true || false
                                                  },
                                                  }, function(err, data) {
                                                      if (err) console.log(err, err.stack); // an error occurred
                                                      else     console.log(data);           // successful response
                                                });
                                            }            // successful response
                                          });
                                        //Video transfer into one bucket to other bucket which uploded by subcriber
                                        if(SVID != ''){
                                            var updatedFile = msg.UplodedVideoUrl;
                                            var Old_filename = updatedFile.split("/").pop();
                                            var finalImageName = msg.id+'_'+msg.thumb_sec+'_'+Old_filename;
                                            var renameFile = 'production/<?php echo VIDEOS ?>/<?php echo VIDEOS ?>_'+finalImageName;
                                            //var params = {Key: renameFile, Body: stream};
                                            var params = {
                                                    Bucket : "<?php echo S3BUCKET; ?>", /* Another bucket working fine */ 
                                                    CopySource : updatedFile, /* required */
                                                    Key : renameFile, /* required */
                                                    ACL : 'public-read',
                                                };
                                              bucket.copyObject(params, function(err, data) {
                                                  if (err)
                                                      console.log(err, err); // an error occurred
                                                  else {
                                                      console.log(data); // successful response
                                                      $.ajax({
                                                          type : 'POST',
                                                          url : '<?php echo Url::toRoute('video/updatevideo'); ?>',
                                                          data : 'id='+msg.id+'&filename='+renameFile,
                                                          dataType: 'json',
                                                          async: false, 
                                                          success : function(msgOfFile) {
                                                              if(msgOfFile.status == 'ok') {
                                                                  document.location.href='<?php echo Yii::$app->urlmanager->createUrl("video/update"); ?>'+'?id='+msg.id;
  //                                                                document.location.href='<?php echo Url::toRoute('video/subscriber-uploded-video-index'); ?>';
                                                              }    
                                                          }    
                                                      });
                                                  }
                                              });
                                       }else{   //Video transfer into one bucket
                                          var bucket = new AWS.S3({params: {Bucket: '<?php echo S3BUCKET; ?>'}});                                      
                                          var updatedFile = fileChooser.files[0]['name'];
                                          var extension = updatedFile.split('.').pop();
                                          var updatedFileString = $.now()+'.'+extension;
                                          var finalImageName = msg.id+'_'+msg.thumb_sec+'_'+updatedFileString;
                                          // MediaConvert watches production/Videos/ — without this prefix stream never builds
                                          var renameFile = 'production/<?php echo VIDEOS ?>/<?php echo VIDEOS ?>_'+finalImageName;
                                          var params = {Key: renameFile, ContentType: file.type, Body: file};
                                          
                                          $("#progressForShortVideo").show();    
                                           bucket.upload(params).on('httpUploadProgress', function(evt) {
                                          var percentage = parseInt((evt.loaded * 100) / evt.total);
                                          $("#progress-barForShortVideo")
                                              .css("width", percentage + "%")
                                              .attr("aria-valuenow", percentage)
                                              .text(percentage + "%");
                                          }).send(function(err, data) {
                                              
                                              $.ajax({
                                                  type : 'POST',
                                                  url : '<?php echo Url::toRoute('video/updatevideo'); ?>',
                                                  data : 'id='+msg.id+'&filename='+renameFile,
                                                  dataType: 'json',
                                                  async: false, 
                                                  success : function(msgOfFile) {
                                                      if(msgOfFile.status == 'ok') {
                                                          document.location.href='<?php echo Yii::$app->urlmanager->createUrl("video/update"); ?>'+'?id='+msg.id;
                                                      }    
                                                  }    
                                              });


                                          }); 
                                        }
                                } else {
                                        // No new file: stay on update page so related/thumbs counts are visible
                                        $("#spinnerLoader").hide();
                                        if (msg.id) {
                                          document.location.href='<?php echo Yii::$app->urlmanager->createUrl("video/update"); ?>'+'?id='+msg.id;
                                        } else {
                                          document.location.href='<?php echo Url::toRoute('video/index'); ?>';
                                        }
                                }    
                            } else {
                                var errMap = (msg && msg.errors) ? msg.errors : msg;
                                var errText = [];
                                if (errMap && typeof errMap === 'object') {
                                  $.each(errMap, function (key, val) {
                                    var text = $.isArray(val) ? val.join(', ') : val;
                                    wrapper = $('[name="Video['+key+']"]').closest(".form-group");
                                    if (wrapper.length) {
                                      wrapper.addClass('has-error');
                                      wrapper.find('.help-block').text(text);
                                    }
                                    errText.push(key + ': ' + text);
                                  });
                                }
                                alert(errText.length ? errText.join("\\n") : "Update failed. Please check required fields (Title, Description, Meta Keywords, etc).");
                                $("#spinnerLoader").hide();
                                return false;
                            }
                      },
                      error: function(xhr, status, err) {
                        $("#spinnerLoader").hide();
                        var msg = 'Save failed';
                        if (xhr && xhr.responseText) {
                          try {
                            var parsed = JSON.parse(xhr.responseText);
                            if (parsed && parsed.errors) {
                              var parts = [];
                              $.each(parsed.errors, function(k, v){
                                parts.push(k + ': ' + ($.isArray(v) ? v.join(', ') : v));
                              });
                              msg = parts.join('\\n') || msg;
                            } else if (parsed && parsed.message) {
                              msg = parsed.message;
                            }
                          } catch (e) {
                            // HTML/PHP error page – show short snippet
                            var t = xhr.responseText.replace(/<[^>]+>/g, ' ').replace(/\\s+/g, ' ');
                            if (t.indexOf('General error: 2014') !== -1) {
                              msg = 'Database busy error. Please try Upload/Update again.';
                            } else {
                              msg = 'Server error. Please try again.';
                            }
                          }
                        }
                        alert(msg);
                      }
            });
            return false;
});


  window.fbAsyncInit = function() {
    FB.init({
      appId      : '948450055241654',
      xfbml      : true,
      version    : 'v2.5'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "<?php echo Yii::$app->request->baseUrl ?>/js/facebook_sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));

  window.___gcfg = {
    lang: 'en',
    parsetags: 'onload'
  };
</script>
<script type="text/javascript"  src="http://platform.linkedin.com/in.js">
    api_key: 75kwnizivzgmf1
    authorize: true
   
</script>

<script src="<?php echo Yii::$app->request->baseUrl ?>/js/google_platform.js" async defer></script>
<script src="<?php echo Yii::$app->request->baseUrl ?>/js/google_client.js?onload=handleClientLoad"></script>
<script src="<?php echo Yii::$app->request->baseUrl ?>/js/google_client_platform.js" async defer></script>

<script>

    window.pAsyncInit = function() {
        PDK.init({
            appId: "4804750724657332984", // Change this
            cookie: true
        });
    };

    (function(d, s, id){
        var js, pjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "<?php echo Yii::$app->request->baseUrl ?>/js/pintrest_sdk.js";
        pjs.parentNode.insertBefore(js, pjs);
    }(document, 'script', 'pinterest-jssdk'));
</script>


<script>window.twttr = (function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0],
    t = window.twttr || {};
  if (d.getElementById(id)) return t;
  js = d.createElement(s);
  js.id = id;
  js.src = "<?php echo Yii::$app->request->baseUrl ?>/js/twitter.js";
  fjs.parentNode.insertBefore(js, fjs);
 
  t._e = [];
  t.ready = function(f) {
    t._e.push(f);
  };
 
  return t;
}(document, "script", "twitter-wjs"));</script>
<script type="text/javascript">
  $('.container').on('click','img.thumbnail.img-responsive',function(){
    var _ele = $(this);
    console.log(_ele.siblings('.videothumbchkbox').is(':checked'));
    if(_ele.siblings('.videothumbchkbox').is(':checked'))
      _ele.siblings('.videothumbchkbox').prop('checked', false);
    else
      _ele.siblings('.videothumbchkbox').prop('checked', true);
    
  });
</script>
</body>
</html>
<?php $this->endPage() ?>