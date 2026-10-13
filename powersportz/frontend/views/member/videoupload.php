<?php

use yii\helpers\Html;
use yii\helpers\Url;
;

use yii\web\View;
/* @var $this yii\web\View */
/* @var $this yii\web\View */
$this->title = Yii::t('frontend', 'uploadvideo');
$this->params['breadcrumbs'][] = $this->title;

//echo "<pre>"; print_r($videolistdetails);die;
?>
<script src="https://sdk.amazonaws.com/js/aws-sdk-2.1.24.min.js"></script>
<script>
    AWS.config.update({
        accessKeyId : '<?=AWSACCESSKEY?>',
        secretAccessKey : '<?=AWSSECRETKEY?>',
        region: '<?=AWSREGION?>',
        signatureVersion: 'v4'
    });
</script>
<?php $this->registerJs("
		

//function after succesful file upload (when server response)
function afterSuccess()
{
	$('#submit-btn').show(); //hide submit button
	$('#loading-img').hide(); //hide submit button
	$('#progressbox').delay( 1000 ).fadeOut(); //hide progress bar

}



//progress bar function
function OnProgress(event, position, total, percentComplete)
{
    //Progress bar
	$('#progressbox').show();
    $('#progressbar').width(percentComplete + '%') //update progressbar percent complete
    $('#statustxt').html(percentComplete + '%'); //update status text
    if(percentComplete>50)
        {
            $('#statustxt').css('color','#000'); //change status text to white after 50%
        }
}

//function to format bites bit.ly/19yoIPO
function bytesToSize(bytes) {
   var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
   if (bytes == 0) return '0 Bytes';
   var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
   return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
}
                       
           "); ?>


<div class="col-md-10 single-page">
    <div class="col-md-3 tab-menu">
       <!-- <ul class="left-menu">
            <li> <a href="<?php //echo Url::toRoute(['member/mywatchlist']) ?> "> <i class="my-wathc-list"></i> <span>My watchlist</span></a> </li>
            <li> <a href="<?php //echo Url::toRoute(['member/myfavourite']) ?> "> <i class="my-favorites"></i> <span>My favorites</span></a> </li>
            <li> <a href="<?php //echo Url::toRoute(['member/myvideo']) ?> "> <i class="my-videos"></i> <span>My videos</span></a> </li>
            <li> <a href="<?php //echo Url::toRoute(['member/myprofile']) ?>"> <i class="profile"></i><span>Profile information</span></a></li>

        </ul>-->
         <?php include('menu.php');?>
    </div>
    <div class="col-md-9 tab-content">
        <div class="tab-content">
            <div id="profile" class="tab-pane fade in active">
                <h3><?php echo Yii::t('frontend','uploadvideo');?></h3>
                <form  action="<?php echo Url::to(['/member/upload']); ?>" method="post" enctype="multipart/form-data" id="MyUploadForm" >
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo Yii::t('frontend','videotitle');?></label>
                        <input type="text" name="videotitle" class="form-control" id="videotitle" placeholder="Video title">
                        <div id="titleerror" style="color: red;" ></div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile"><?php echo Yii::t('frontend','uploadvideo');?></label>


                        <input name="FileInput" id="FileInput" type="file" />

                        <input name="VideoFile" id="hidden_file_input" type="hidden" value="<?= 'videos/'.time().'.mp4'?>" />
                        <p class="help-block"><?php echo Yii::t('frontend','uploadvideoformat');?></p>
                        <img src="../images/ajax-loader-1.gif" id="loading-img" style="display:none;margin: -50px" alt="Please Wait"/>
                        <div id="fileerror" style="color: red;" ></div>
                    </div> 
                    <div class="checkbox">
                        <label>
                            <input id="termsconditions" type="checkbox">
                           <?php echo Yii::t('frontend','termsandconditions');?></label>
                        <div id="tcerror" style="color: red;" ></div>
                    </div>
                    <!--<input type="submit" class="btn btn-default" value="Submit" >-->
                    <input type="buttton"  class="btn btn-default"  id="submit-btn" value=" <?php echo Yii::t('frontend','upload');?>" onclick="uploadFile();" />
                </form>
                 <div class="progress" id="progressForShortVideo" style="display: none;" style="background: red">
                    <div class="progress-bar progress-bar-striped active" id="progress-barForShortVideo" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%" >
                    progress    
                    </div>
                </div>
                <!-- <div id="progressbar"></div > --><!-- <div id="statustxt">0%</div> -->
                <div id="output" style="color: red;" ></div>
            </div>
            <!-- My Profile end -->
        </div>
    </div>
</div>




<script>
    function uploadFile() {
        if (window.File && window.FileReader && window.FileList && window.Blob)
        { 
                if( !$('#videotitle').val()) {
                    $('#titleerror').html('Please Enter Video Title.');
                    return false
                } else {
                    $('#titleerror').html('');    
                }
                if( !$('#FileInput').val()) {
                    $('#fileerror').html('Please Select Video');
                    return false
                } else {
                    $('#fileerror').html('');    
                } 
                if(!$('#termsconditions').is(':checked')) {
                    $('#tcerror').html('Please Accept Terms and Condition ');
                    return false
                } else {
                    $('#tcerror').html('');    
                }   
                var fsize = $('#FileInput')[0].files[0].size;
                var ftype = $('#FileInput')[0].files[0].type;
                console.log(ftype+fsize);
                
                switch(ftype)
                {
                    case 'video/mp4':
                        break;
                    default:
                        $('#output').html('<b>'+ftype+'</b> Unsupported file type!');
                        return false
                }
                var fileChooser = document.getElementById('FileInput');
                var file = fileChooser.files[0];                 
                uploadOnS3bucket(file);           
                $('#submit-btn').hide(); 
                $('#loading-img').show(); 
                $('#output').html('');
        }
        else
        {
            $('#output').html('Please upgrade your browser, because your current browser lacks some new features we need!');
            return false;
        }
    }
    function validateForm() {
        var datastring = $('#MyUploadForm').serialize();
        $.ajax({
            type: 'POST',
            url: '<?php echo Url::to(['/member/upload']); ?>',
            data: {videotitle:$("#videotitle").val(),VideoFile:$("#hidden_file_input").val()},
            success: function (msg) {
                alert(msg);
                return false;
            }
        });
    }
	function uploadOnS3bucket(file){
		var s3bucket_video = '<?=S3BUCKET_VIDEO?>';
		var bucket = new AWS.S3({params: {Bucket: s3bucket_video}});
		if (file){
          var params = {Key: $('#hidden_file_input').val() , ContentType:file.type, Body: file};
			   bucket.upload(params).on('httpUploadProgress', function(evt) {
    			    var percentage = parseInt((evt.loaded * 100) / evt.total);
                      $("#progress-barForShortVideo")
                          .css("width", percentage + "%")
                          .attr("aria-valuenow", percentage)
                          .text(percentage + "%");
                    $("#progressForShortVideo").show(); 

                }).send(function(err, data) {
                //$('#MyUploadForm').submit();
                validateForm();
				return true;
            });
	}
        return false;
	}
</script>