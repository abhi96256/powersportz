/**
 * This funciton used for filter record
*/
function filterPopup($this){

        var modelName = $($this).closest('.filterPopupModel').attr("id");
       // $("#"+modelName+" .spinner_div").show();
        if($($this).val() == ''){
           $('#'+modelName+' .panel-body .video_block').show();
        }else{
           //console.log(modelName);
            $.each($('#'+modelName+' .panel-body .video_block p'),
            function(i, val) {
                if ($(val).text().indexOf($($this).val()) == -1) {
                        $(this).closest('.video_block').hide();
                } else {
                        $(this).closest('.video_block').show();
                }
            });
        }
        //setTimeout(function(){ $("#"+modelName+" .spinner_div").hide(); }, 3000);
        
}

$(".filterPopupModel input").keypress(function(event){
    if (event.keyCode == 10 || event.keyCode == 13) 
        event.preventDefault();
});


function RequiredValidation(obj,error,modelId){
    if(obj.length <= 0){
        $("#"+modelId+" .panel-footer .error-summary").remove();
        $("#"+modelId+" .panel-footer").append("<span class='error-summary'>"+error+"</span>");
         return false;
    }else{
        return true;
    }
}
/**
* obj = Set list of all checked value object
* max_length = set validation for how many checkbox checked
* error = set error message for checked max length
*/
function getCheckedValue(obj,max_length,error,id){
    max_length = max_length || 0;
    error = error || '';
   var checkedvideo = '';
   console.log(max_length);
   if($(obj).length != max_length && max_length != 0){
        if($(obj).length >= max_length){
            error = error.replace('{limit}',' maximum '+max_length);
            console.log(error);
        }else if($(obj).length <= max_length){
            error = error.replace('{limit}',' minimum '+max_length);
            console.log(error);
        }
        var modelId = $(obj).closest('.modal').attr('id');
        $("#"+modelId+" .panel-footer .error-summary").remove();
        $("#"+modelId+" .panel-footer").append("<span class='error-summary'>"+error+"</span>");
        return false;
   }
   $(obj).each(function(){
        if(checkedvideo != ''){
            checkedvideo += ',';
        }
        checkedvideo += $(this).val();
    });
    return checkedvideo;
}
function setCheckedValue(obj,val){
    var modelId = $(obj).closest('.modal').attr('id');
    $("#"+modelId+" .panel-footer .error-summary").remove();
    if(val != ''){
        var selectedValue = val.split(",");
        $(obj).each(function(){
             if($.inArray(this.value ,selectedValue) > -1){
                $(this).prop("checked", true);
            }else{
                $(this).prop("checked", false);
            }
        });
    }
}
