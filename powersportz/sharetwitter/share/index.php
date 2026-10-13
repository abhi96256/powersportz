<?php 

session_start();
/*echo '<pre>';
print_r($_SESSION);die;*/
?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js">
</script>
<script type="text/javascript" src="jquery.oauthpopup.js">
</script><script type="text/javascript">// <![CDATA[
$(document).ready(function(){
    $('#connect').click(function(){
        $.oauthpopup({
            path: 'http://powersports3.e2logy.com/sharetwitter/share/connect.php',
            callback: function(){
               window.location.reload();
            }
        });
    });
    $("#tweet").click(function(){
         $.ajax({
            type :'POST',
            url: 'http://powersports3.e2logy.com/sharetwitter/share/connect.php?tweet=true', 
            data : {message : 'This is testing purpose',video_url: 'http://powersports3.e2logy.com/sharetwitter/index.php',image_url : 'https://transcodingvideo.s3.amazonaws.com/Videos/Thumb/1/Thumb_Videos_1_300_1452252227912_00001.png'},
            success: function(result){
                    console.log(result);
          }});
    });
});
// ]]></script>

<?php 
if (!empty($_SESSION['twitter'])) {
	echo "connected";
    echo "<input type='button' name='tweet' id='tweet'  value='tweet' />";
    echo "<br/>";
}

?>
<input id="connect" type="button" value="Connect with Twitter" />
 <a href="signout.php">Sign Out</a>