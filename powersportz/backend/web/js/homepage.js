/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/*$('.filterPopupModel').find(".filterInput").keyup(function() {
       
});*/

function reorderAccompanyingVideosHtml(){
    $(".reorderAccompanyingVideo").html('Loading...');
    var csrfToken = $('meta[name="csrf-token"]').attr("content");
    $.ajax({
            type: "POST",
            url: "reorder-accompanying-videos",
            data: { AccompanyingVideoId: $("#homepage-accompanyingid").val(), _csrf : csrfToken},
            success: function (r) {
                if(r == ''){
                    $(".reorderAccompanyingVideo").attr('disabled',true);
                }else{
                    $(".reorderAccompanyingVideo").attr('disabled',false);
                }
                $("#reorderModalAccompanying").html(r);
                $('#sortable').sortable();
                $(".reorderAccompanyingVideo").html('Reorder Accompanying Videos');
             },
        });
}

function reorderAccompanyingVideos(){
    $("#reorderModalAccompanying").modal('show');
}

function ChangeOrderForAccompnyvideo(){
    console.log($(".orderingVideoId").map(function() {
        return this.value;
    }).get().join(","));
     $("#homepage-accompanyingid").val($(".orderingVideoId").map(function() {
        return this.value;
    }).get().join(","));
    $("#reorderModalAccompanying").modal('hide');
}

/** Start : For Main video**/
$(".addvideolist").click(function(){
    //Check validation
    var error = "Please select recorded video.";
    checkedVideo = $("#myModal input[name='videothumb']:checked");
    //Store video id in form
    if(RequiredValidation(checkedVideo,error,"myModal")){
        $("#homepage-videoid").val(checkedVideo.val());
        $(".show_main_video_image").find('img').attr('src',$(checkedVideo).next('img').attr('src'))
        $('#myModal').modal('hide');
    }

});

/** Stop : For Main video**/

/** Start : For Schedule video**/
$(".addschedulevideolist").click(function(){
    //Check validation
    var error = "Please select recorded video.";
    checkedVideo = $("#myModalSchedule input[name='schedulevideothumb']:checked");
    //Store video id in form
    if(RequiredValidation(checkedVideo,error,"myModalSchedule")){
        $("#homepage-schedulevideoid").val(checkedVideo.val());
        $(".show_recorded__video_image").find('img').attr('src',$(checkedVideo).next('img').attr('src'))
        $('#myModalSchedule').modal('hide');
    }

});

/** Stop : For Main video**/

/** Start : For Accompanying Videos**/
$(".addAccompnyvideolist").click(function(){
    //Check validation
    var error = "Please select accompanying videos.";
    checkedAccompnyVideo = $("#myModalAccompanying input[name='videoaccompanying']:checked");
    //Store video id in form
    if(RequiredValidation(checkedAccompnyVideo,error,"myModalAccompanying")){
        checked_value = getCheckedValue(checkedAccompnyVideo,5,"Please select any 5 Accompanying videos.");
        if(checked_value){
            $("#homepage-accompanyingid").val(checked_value);
            $(".reorderAccompanyingVideo").attr('disabled',false);
            $('#myModalAccompanying').modal('hide');
            reorderAccompanyingVideosHtml();
        }
    }
    
});

/** Stop : For Accompanying Videos**/

/** Start : For Advertisment Videos**/
$(".addadvertisementsvideolist").click(function(){
    //Check validation
    var error = "Please select Advertisements videos.";
    checkedAccompnyVideo = $("#myModalAdvertisements input[name='videoadvertisement']:checked");
   // console.log($("#myModalAdvertisements input[name='videoadvertisement']"));
    //Store video id in form
    if(RequiredValidation(checkedAccompnyVideo,error,"myModalAdvertisements")){
        $("#homepage-advertisementid").val(getCheckedValue(checkedAccompnyVideo));
        $('#myModalAdvertisements').modal('hide');
    }
    
});

/** Stop : For Accompanying Videos**/


