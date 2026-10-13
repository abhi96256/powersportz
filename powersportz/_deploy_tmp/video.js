/******************* PublishVideo Process ***************************/

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