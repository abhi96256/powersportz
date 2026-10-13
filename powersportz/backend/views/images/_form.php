<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Images */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
.applist {
    border:1px grey solid; padding: 10px;    
}    
.help-block{
    color: #a94442;
}

</style>

<script src="https://sdk.amazonaws.com/js/aws-sdk-2.1.24.min.js"></script>
<script type="text/javascript">
    AWS.config.update({
        accessKeyId : '<?php echo AWSACCESSKEY; ?>',
        secretAccessKey : '<?php echo AWSSECRETKEY; ?>',
        region: '<?php echo AWSREGION; ?>',
        signatureVersion: 'v4'
    });
</script>

<div class="images-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype'=>'multipart/form-data','id'=>'thumpnail-post-form'],
        ]); ?>
        <?php echo $form->errorSummary($model); ?>
        <?php //echo $form->field($model, 'Title')->textInput(['maxlength' => true]) ?>
        <?php //echo $form->field($model, 'ImageName')->textInput(['maxlength' => true]) ?>
        <div id="applist1" class="applist">
            <div>
                <label class="control-label" >Name</label>
                <input type="text" maxlength="100" name="Title[]" id="Title1" class="form-control" value="<?php echo stripslashes($model->Title); ?>">
                <div class="help-block"></div>
                <label class="control-label" >Image <code>( Recommended image size : 640 X 360 )</code></label>

                <input type="file" name="Image[]" id="Image1" >
                <div class="help-block"></div>
                 <?php 
                if(!$model->isNewRecord) {
                    echo '<img src="'. ImagesUrl($model).'" width="50" height="50">';
                }
                ?>

            </div>    
            <div class="progress" id="progressForShortVideo1" style="display: none;">
                <div class="progress-bar progress-bar-striped active" id="progress-barForShortVideo1" role="progressbar" aria-valuenow1="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                    progress    
                </div>
            </div>
        </div>

        <br>
        <input type="hidden" name="imageID" id="imageID" value="1">
        <input type="hidden" name="hiddenID" id="hiddenID" value="<?php echo $model->ImageID; ?>">
        <?php if($model->isNewRecord) { ?>
        <button type="button" class="btn btn-primary" onclick="addApp();">Add More Thumbnail</button>
        <?php } ?>
        <div class="form-group">
            <br>
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary','onclick'=>'return validate()']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

    <?php
    $this->registerJs('
     $("#thumpnail-post-form").on("beforeSubmit", function (e) {
        $("#spinnerLoader").show();  
        var bucket = new AWS.S3({params: {Bucket: "'.S3BUCKET.'"}});
        var fileChooser = document.getElementsByName("Image[]");
        var Title = document.getElementsByName("Title[]");
        var r=1;
        for(var n=0;n<fileChooser.length;n++) {
            var loopcontinue = false;
            var file = fileChooser[n].files[0];
            if(file) {
                var updatedFile = fileChooser[n].files[0]["name"];
                var extension = updatedFile.split(".").pop();
                var updatedFileString = $.now()+"."+extension;
                var finalImageName = updatedFileString;
                var renameFile = "'.THUMBNAILS.'/Thumb/mainvideo/"+finalImageName;
                var params = {Key: renameFile, ContentType: file.type, Body: file};
                $("#progressForShortVideo"+r).show();
                uploadFile(params,"0",r,finalImageName);
                return false;
            } else {
                var hiddenID = $("#hiddenID").val();
                if(hiddenID !="") {
                    var datastring = "Title="+Title[0].value+"&ImageID="+hiddenID;    
                    $.ajax({
                        type : "POST",
                        url : "'.Url::toRoute('images/add').'",
                        data : datastring,
                        dataType : "json",
                        success : function(msg) {
                            document.location.href= "'.Url::toRoute('images/index').'";
                            return false;    
                        }
                    });
                } 
                return false;
            }
        }
    });    

    function uploadFile(params,id,r,finalImageName) {
        var Title = document.getElementsByName("Title[]");
        var bucket = new AWS.S3({params: {Bucket: "'.S3BUCKET.'"}});    
        var fileID = id;
        var loader = r;
        var uploadedFile = finalImageName;
        bucket.upload(params).on("httpUploadProgress", function(evt) {
            var percentage = parseInt((evt.loaded * 100) / evt.total);
            $("#progress-barForShortVideo"+loader)
            .css("width", percentage + "%")
            .attr("aria-valuenow"+loader, percentage)
            .text(percentage + "%");        
        }).send(function(err, data) {
            var hiddenID = $("#hiddenID").val();
            var datastring = "Title="+Title[fileID].value+"&ImageName="+uploadedFile+"&ImageID="+hiddenID;    
            $.ajax({
                type : "POST",
                url : "'.Url::toRoute('images/add').'",
                data : datastring,
                dataType : "json",
                async : false,
                success : function(msg) {
                    document.location.href= "'.Url::toRoute('images/index').'";
                }
            });
            var fileChooser = document.getElementsByName("Image[]");
            if(hiddenID == "") {
                if(r == fileChooser.length) {
                    document.location.href= "'.Url::toRoute('images/index').'";
                    return false;    
                }
            } else {
                document.location.href= "'.Url::toRoute('images/index').'";
                return false;
            }
            r++;
            var id = parseInt(fileID) + parseInt(1);
            var file = fileChooser[id].files[0];
            if(file) {
                var updatedFile = fileChooser[fileID].files[0]["name"];
                var extension = updatedFile.split(".").pop();
                var updatedFileString = $.now()+"."+extension;
                var finalImageName = updatedFileString;
                var renameFile = "'.THUMBNAILS.'/Thumb/mainvideo/"+finalImageName;
                var params = {Key: renameFile, ContentType: file.type, Body: file};
                $("#progressForShortVideo"+r).show();
                uploadFile(params,id,r,finalImageName);
            }    
        });
    }
    ');   

    ?>

    <script>
        function validate() {
            $('.help-block').text('');
            var numberOfApps = $("#imageID").val();
            error = false;
            for(var n=0; n<numberOfApps; n++) {
                var addID = parseInt(n) + parseInt(1);
                var AppTitle = $("#Title"+addID).val();
                var AppLogo = $("#Image"+addID).val();
                var ext = '';    

                if(typeof AppLogo != 'undefined') {    
                    var ext = AppLogo.split('.').pop().toLowerCase();
                }    
                if(AppTitle == '') {
                    var URLCount = "";
                    <?php if($model->isNewRecord) { ?>
                        console.log(n);
                        if(AppTitle == '') {
                            $("#Title"+addID).next('.help-block').text('Please enter title for image');
                            //alert("Please enter title for image "+addID);
                            error = true;
                        }    
                        if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
                            $("#Image"+addID).next('.help-block').text('Please upload valid file for image');
                            //alert("Please upload valid file for image "+addID);
                            error = true;
                        }
                        <?php } ?>
                    } else {
                        <?php if($model->isNewRecord) { ?>
                            if(AppTitle != '') {
                                var URLCount = "";
                                if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
                                   // alert("Please upload valid file for image "+addID);
                                   $("#Image"+addID).next('.help-block').text('Please upload valid file for image');
                                   error = true;
                               }   
                           }
                           <?php } ?>
                       }
                   }
                   return error != true;
               }        
                function addApp() {
                    var imageID = $("#imageID").val();
                    var addAppID = parseInt(imageID) + parseInt(1);
                    $("#imageID").val(addAppID);    
                    var finalAppString = '<div id="applist'+addAppID+'" class="applist"><span class="glyphicon glyphicon-remove" style="float:right;cursor:pointer;" aria-hidden="true" onclick="removeApp('+addAppID+');" ></span><div><label class="control-label" >Name</label>  <input type="text" maxlength="100" name="Title[]" id="Title'+addAppID+'" class="form-control" value=""><div class="help-block"></div><label class="control-label" >Image <code>( Recommended image size : 640 X 360 )</code></label>  <input type="file" name="Image[]" id="Image'+addAppID+'" ><div class="help-block"></div></div><div class="progress" id="progressForShortVideo'+addAppID+'" style="display: none;"><div class="progress-bar progress-bar-striped active" id="progress-barForShortVideo'+addAppID+'" role="progressbar" aria-valuenow'+addAppID+'="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">progress</div></div></div>';
                    $("#applist"+imageID).after(finalAppString);
                }    
                function removeApp(id) {
                    $("#applist"+id).remove();
                    var imageID = $("#imageID").val();
                    var addAppID = parseInt(imageID) - parseInt(1);
                    $("#imageID").val(addAppID);
                }
            </script>