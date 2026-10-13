/******************* PublishVideo Process ***************************/

function psVideoSaveFilename(updateVideoUrl, vid, renameFile, redirectUrl) {
  jQuery.ajax({
    type: 'POST',
    url: updateVideoUrl,
    data: 'id=' + encodeURIComponent(vid) + '&filename=' + encodeURIComponent(renameFile),
    dataType: 'json',
    success: function(msgOfFile) {
      if (msgOfFile && msgOfFile.status === 'ok') {
        window.location.href = redirectUrl + '?id=' + vid;
        return;
      }
      jQuery('#spinnerLoader').hide();
      alert('Video uploaded but could not save file path. Please refresh and try again.');
    },
    error: function() {
      jQuery('#spinnerLoader').hide();
      alert('Video uploaded but could not save file path. Please refresh and try again.');
    }
  });
}

function psGetSelectedVideoFile() {
  var input = document.getElementById('video-videourl');
  if (input && input.files && input.files.length) {
    return input.files[0];
  }
  var $inp = jQuery('#video-videourl');
  if ($inp.length) {
    try {
      var stack = $inp.fileinput('getFileStack');
      if (stack && stack.length) {
        return stack[0];
      }
    } catch (e) {}
  }
  return null;
}

function psVideoAfterSave(msg, form, updatedID) {
  var viewUrl = form.data('view-url');
  var updatePageUrl = form.data('update-page-url');
  var updateVideoUrl = form.data('update-video-url');
  var s3Bucket = form.data('s3-bucket');
  var s3VideoBucket = form.data('s3-video-bucket');
  var videosPrefix = form.data('videos-prefix');
  var svid = form.data('svid') || '';
  var vid = msg.id || updatedID;
  var file = psGetSelectedVideoFile();

  if (!file && svid === '') {
    jQuery('#spinnerLoader').hide();
    if (vid) {
      window.location.href = viewUrl + '?id=' + vid;
    }
    return;
  }

  if (typeof AWS === 'undefined') {
    jQuery('#spinnerLoader').hide();
    alert('AWS upload library not loaded. Video details saved — please re-open and upload the file.');
    return;
  }

  var bucket = new AWS.S3({ params: { Bucket: s3Bucket } });
  bucket.listObjects({
    Bucket: s3VideoBucket,
    Prefix: videosPrefix + '/Thumb/' + vid
  }, function(err, data) {
    if (!err && data && data.Contents && data.Contents.length) {
      var arr = [];
      jQuery.each(data.Contents, function(item, keyName) {
        arr.push({ Key: keyName.Key });
      });
      bucket.deleteObjects({
        Bucket: s3VideoBucket,
        Delete: { Objects: arr, Quiet: true }
      }, function() {});
    }
  });

  var thumbSec = msg.thumb_sec || '120';
  if (svid !== '') {
    var updatedFile = msg.UplodedVideoUrl;
    var oldFilename = updatedFile.split('/').pop();
    var finalImageName = vid + '_' + thumbSec + '_' + oldFilename;
    var renameFile = 'production/' + videosPrefix + '/' + videosPrefix + '_' + finalImageName;
    bucket.copyObject({
      Bucket: s3Bucket,
      CopySource: updatedFile,
      Key: renameFile,
      ACL: 'public-read'
    }, function(copyErr) {
      if (copyErr) {
        jQuery('#spinnerLoader').hide();
        alert('Video upload failed. Please try again.');
        return;
      }
      psVideoSaveFilename(updateVideoUrl, vid, renameFile, updatePageUrl);
    });
    return;
  }

  var extension = file.name.split('.').pop();
  var updatedFileString = jQuery.now() + '.' + extension;
  var finalImageName = vid + '_' + thumbSec + '_' + updatedFileString;
  var renameFile = 'production/' + videosPrefix + '/' + videosPrefix + '_' + finalImageName;
  var params = { Key: renameFile, ContentType: file.type, Body: file };

  jQuery('#progressForShortVideo').show();
  bucket.upload(params).on('httpUploadProgress', function(evt) {
    var percentage = parseInt((evt.loaded * 100) / evt.total, 10);
    jQuery('#progress-barForShortVideo')
      .css('width', percentage + '%')
      .attr('aria-valuenow', percentage)
      .text(percentage + '%');
  }).send(function(uploadErr) {
    if (uploadErr) {
      jQuery('#spinnerLoader').hide();
      alert('Video upload failed. Please try again.');
      return;
    }
    psVideoSaveFilename(updateVideoUrl, vid, renameFile, updatePageUrl);
  });
}

function psVideoSaveForm() {
  var form = jQuery('#video-post-form');
  if (!form.length) {
    alert('Form not found.');
    return false;
  }
  if (typeof CKEDITOR !== 'undefined') {
    for (var inst in CKEDITOR.instances) {
      if (CKEDITOR.instances.hasOwnProperty(inst)) {
        try { CKEDITOR.instances[inst].updateElement(); } catch (err) {}
      }
    }
  }
  var updatedID = jQuery('input[name="Video[ID]"]').val() || form.data('video-id') || '';
  updatedID = String(updatedID);
  var shortVideo = jQuery('#video-videourl').val();
  var hasFile = psGetSelectedVideoFile() !== null;
  var svid = form.data('svid') || '';
  if (!hasFile && shortVideo === '' && updatedID === '' && svid === '') {
    alert('Please upload video');
    return false;
  }
  jQuery('#spinnerLoader').show();
  var URL = (updatedID === '') ? form.data('create-url') : form.data('update-url');
  var datastring = form.serialize();
  if (updatedID !== '') {
    datastring += '&id=' + encodeURIComponent(updatedID);
  }
  if (svid !== '') {
    datastring += '&SVID=' + encodeURIComponent(svid);
  }
  var relIds = jQuery('input[name="Video[IsRelatedVideoId]"]').val() || '';
  var thumbIds = jQuery('input[name="Video[IsthumbnailVideoId]"]').val() || '';
  var defThumbIds = jQuery('input[name="Video[IsDefaultthumbnailVideoId]"]').val() || '';
  datastring += '&Video%5BIsRelatedVideoId%5D=' + encodeURIComponent(relIds);
  datastring += '&Video%5BIsthumbnailVideoId%5D=' + encodeURIComponent(thumbIds);
  datastring += '&Video%5BIsDefaultthumbnailVideoId%5D=' + encodeURIComponent(defThumbIds);
  jQuery.ajax({
    type: 'POST',
    url: URL,
    data: datastring,
    dataType: 'json',
    success: function(msg) {
      if (msg && msg.status === 'ok') {
        psVideoAfterSave(msg, form, updatedID);
        return;
      }
      jQuery('#spinnerLoader').hide();
      var errText = [];
      if (msg && msg.errors) {
        jQuery.each(msg.errors, function(k, v) {
          errText.push(k + ': ' + (jQuery.isArray(v) ? v.join(', ') : v));
        });
      }
      alert(errText.length ? errText.join('\n') : 'Save failed. Check required fields.');
    },
    error: function(xhr) {
      jQuery('#spinnerLoader').hide();
      var msg = 'Server error. Please try again.';
      if (xhr && xhr.responseText) {
        if (xhr.responseText.indexOf('General error: 2014') !== -1) {
          msg = 'Database busy. Please try again.';
        } else {
          try {
            var parsed = JSON.parse(xhr.responseText);
            if (parsed && parsed.errors) {
              var parts = [];
              jQuery.each(parsed.errors, function(k, v) {
                parts.push(k + ': ' + (jQuery.isArray(v) ? v.join(', ') : v));
              });
              msg = parts.join('\n');
            }
          } catch (e) {}
        }
      }
      alert(msg);
    }
  });
  return false;
}

jQuery(document).on('click', '#uploadvideo', function(e) {
  e.preventDefault();
  psVideoSaveForm();
});

$("#video-videourl").change(function () {
  $("#uploadvideo").html("Upload");
});

/************************  Generated Thumbnail images *****************************/
$(document).on("click", ".defaultthumbnailVideoPopup", function () {
  setCheckedValue($("#DefaultVideoThumbnailImageModel input[name='videothumbimages']"), $("input[name='Video[IsDefaultthumbnailVideoId]']").val());
  $('#DefaultVideoThumbnailImageModel').modal('show');
});

$(document).on("click", ".addgeneratedthumbimages", function () {
  ThumbcheckedVideo = $("#DefaultVideoThumbnailImageModel input[name='videothumbimages']:checked");
  $("input[name='Video[IsDefaultthumbnailVideoId]']").val(getCheckedValue(ThumbcheckedVideo) || '');
  $('#DefaultVideoThumbnailImageModel').modal('hide');
  $(".count_default_thumbnail_images").html($(ThumbcheckedVideo).length + " generated thumbnail selected.")
});

/**********************************  Stop ************************************/



/*************************** Related video ************************************/
$(document).on("click", ".relatedVideosPopup", function () {
  if ($('#related_videos_input').val() != '') {
    $('#related_videos_input').val('');
    if (typeof filterPopup === 'function') {
      filterPopup($('#related_videos_input'));
    }
  }
  setCheckedValue($("#RelatedVideoModel input[name='videothumb']"), $("input[name='Video[IsRelatedVideoId]']").val());
  $('#RelatedVideoModel').modal('show');
});

$(document).on("click", ".addrelatedvideo", function () {
  var error = "Select at least one video";
  checkedVideo = $("#RelatedVideoModel input[name='videothumb']:checked");
  if (RequiredValidation(checkedVideo, error, "RelatedVideoModel")) {
    $("input[name='Video[IsRelatedVideoId]']").val(getCheckedValue(checkedVideo) || '');
    $('#RelatedVideoModel').modal('hide');
    $(".count_related_video").html($(checkedVideo).length + " Related Videos Selected.")
  }
});

/*************************** Thumbnail video ************************************/

$(document).on("click", ".thumbnailVideoPopup", function () {
  if ($('#videoThumbnailImage_input').val() != '') {
    $('#videoThumbnailImage_input').val('');
  }
  setCheckedValue($("#VideoThumbnailImageModel input[name='videothumbimages']"), $("input[name='Video[IsthumbnailVideoId]']").val());
  $('#VideoThumbnailImageModel').modal('show');
});

$(document).on("click", ".addthumbimages", function () {
  ThumbcheckedVideo = $("#VideoThumbnailImageModel input[name='videothumbimages']:checked");
  var ids = getCheckedValue(ThumbcheckedVideo);
  if (ids === false) {
    ids = '';
  }
  $("input[name='Video[IsthumbnailVideoId]']").val(ids || '');
  $('#VideoThumbnailImageModel').modal('hide');
  $(".count_thumbnail_images").html($(ThumbcheckedVideo).length + " thumbnail selected.")
});

/*************************** Full video ************************************/

$(".full_video_popup").click(function () {
  if ($('#full_video_input').val() != '') {
    $('#full_video_input').val('');
    filterPopup($('#full_video_input'));
  }
  setCheckedValue($("#FullVideoModel input[name='fullvideo']"), $("input[name='Video[FullVideoId]']").val());
  $('#FullVideoModel').modal('show');
});

//When user click on add video then open popup
$(".addfullvideo").click(function () {
  var error = "Select at least one video";
  ThumbcheckedVideo = $("#FullVideoModel input[name='fullvideo']:checked");
  //Store video id in form
  //    if(RequiredValidation(ThumbcheckedVideo,error)){
  if ($(ThumbcheckedVideo).length > 0) {
    $("input[name='Video[FullVideoId]']").val(getCheckedValue(ThumbcheckedVideo));
    $(".full_video_name").html("<b>" + $(ThumbcheckedVideo).next('img').next('p').html() + "</b> Video selected.")
  }
  $('#FullVideoModel').modal('hide');
  //  }
});


$("#video-is_skip_adv").click(function () {
  if ($("#video-is_skip_adv").is(":checked")) {
    $("#showSkipTime").show();
  } else {
    $("#showSkipTime").hide();
  }
});
$("#customadvertisement-isexternal input").on('change', function () {

  if (this.value == 0) {
    $("#showVideo").show();
    $("#showUrl").hide();
  } else {
    $("#showUrl").show();
    $("#showVideo").hide();
  }
});
/*var clientId = '10412981768-7q9q88kkdmm1b529mg9aktk7gb1nhe22.apps.googleusercontent.com';
// Enter the API key from the Google Develoepr Console - to handle any unauthenticated
// requests in the code.
// The provided key works for this sample only when run from
// https://google-api-javascript-client.googlecode.com/hg/samples/authSample.html
// To use in your own application, replace this API key with your own.
var apiKey = 'AIzaSyBgMwxzKI70CM5wb2772vtxW6TKC0N_pNg';
// To enter one or more authentication scopes, refer to the documentation for the API.
var scopes = 'https://www.googleapis.com/auth/plus.me';
*/


function handleClientLoad() {
  console.log("load");
  gapi.client.setApiKey(apiKey);
}


function getProcess(id, status) {
  $.ajax({
    type: "POST",
    url: "update-video-status",
    data: { "video_id": id, "status": status },
    success: function (r) {
      window.location.reload();
    },
  });
}


$.oauthpopup = function (options) {
  options.windowName = options.windowName || 'ConnectWithOAuth'; // should not include space for IE
  options.windowOptions = options.windowOptions || 'location=0,status=0,width=800,height=400';
  options.callback = options.callback || function () { window.location.reload(); };
  var that = this;
  console.log(options.path);
  that._oauthWindow = window.open(options.path, options.windowName, options.windowOptions);
  that._oauthInterval = window.setInterval(function () {
    if (that._oauthWindow.closed) {
      window.clearInterval(that._oauthInterval);
      options.callback();
    }
  }, 1000);
};


$(".shared_video").click(function () {
  $this = $(this);
  // alert($(this).is(':checked'));
  // alert($(this).val());
  if ($(this).is(':checked')) {
    if ($(this).val() == 0) {
      console.log("fb");
      FB.getLoginStatus(function (response) {
        console.log(response);
        if (response.status === 'connected') {
          console.log('Logged in.');
        }
        else {
          FB.login(function (response) {
            if (response.authResponse == null) {
              $($this).removeAttr('checked');
            }
          }, { scope: 'publish_actions' });
        }
      });
    } else if ($(this).val() == 3) {
      console.log("Google+");
      gapi.auth.authorize({ client_id: clientId, scope: scopes, immediate: false }, function (authResult) {
        if (authResult && !authResult.error) {
          console.log("login !!!");
        } else {
          $($this).removeAttr('checked');
        }
      });
    } else if ($(this).val() == 1) {
      console.log("Linkedin");
      IN.UI.Authorize().place()
      IN.Event.on(IN, "auth", function () { });
    } else if ($(this).val() == 2) {
      console.log("Twitter");
      twitterOauthPopup();

    } else if ($(this).val() == 3) {
      gapi.auth.authorize({ client_id: clientId, scope: scopes, immediate: true },
        function (authresult) {
          if (authResult && !authResult.error) {
            console.log("login !!!");
          } else {
            console.log("Not login");
          }
        });
    } else if ($(this).val() == 4) {
      console.log("Pintrest");
      PDK.login({ scope: 'read_public, write_public' }, function (session) {
        if (!session) {
          alert('The user chose not to grant permissions or closed the pop-up');
        } else {
          console.log('Thanks for authenticating. Getting your information...');
          PDK.me(function (response) {
            if (!response || response.error) {
              alert('Oops, there was a problem getting your information');
            } else {
              console.log('Welcome,  ' + response.data.first_name + '!');
            }
          });
        }
      });
    }
  }
});

/************************** Subscriber Uploded Video *****************************/
/**
* When admin can reject any video then call this funciton.
*/
function getReject(id, memberid) {
  //alert("hiii");
  $("#spinnerLoader").show();
  var videoid = id;
  var mid = memberid;
  var datastring = 'SID=' + videoid + '&MemberID=' + mid;
  $.ajax({
    type: 'POST',
    url: '../member/uploadvideoreject',
    data: datastring,
    success: function (msg) {

      location.reload();
      $("#spinnerLoader").hide();
    }
  });
}