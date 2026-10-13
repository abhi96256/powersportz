/**
 * This funciton used for filter record
*/
function filterPopup($this){

        var modelName = $($this).closest('.filterPopupModel').attr("id");
       // $("#"+modelName+" .spinner_div").show();
        var q = $.trim(($($this).val() || '')).toLowerCase();
        if(q == ''){
           $('#'+modelName+' .panel-body .video_block').show();
        }else{
            $.each($('#'+modelName+' .panel-body .video_block'),
            function(i, val) {
                var title = (($(val).attr('data-title') || $(val).find('p').text() || '') + '').toLowerCase();
                if (title.indexOf(q) == -1) {
                        $(this).hide();
                } else {
                        $(this).show();
                }
            });
        }
        
}

// Type karte hi turant filter (Enter ki zarurat nahi)
$(document).on('keyup input paste', '.filterPopupModel input.filterInput, .filterPopupModel input.videoname', function(){
    filterPopup($(this));
});

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
