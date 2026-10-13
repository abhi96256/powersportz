<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>How to post tweet on Twitter with PHP</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <style type="text/css">
      #status
    {
        width: 357px;
        height: 28px;
        font-size: 15px;
    }
    img {border-width: 0}
      * {font-family:'Lucida Grande', sans-serif;}
    </style>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script><script type="text/javascript" src="jquery.oauthpopup.js"></script><script type="text/javascript">
$(document).ready(function(){
    $('#connect').click(function(){
	   $.oauthpopup({
            path: 'index.php?redirect=true',
            callback: function(){
                  /* window.location.reload(); */
            },
        }); 
				
	});
}); 
// ]]></script>
  </head>
  <body>
    <div>
      <h2>Demo Post Tweet On Twitter With PHP.&nbsp;&nbsp;&nbsp;</h2>
<?php
require_once('oauth/twitteroauth.php');
require_once('config.php');
echo "<pre>"; print_r($_SESSION);
if(isset($_POST["status"]))
{   
    if(isset($_FILE["name"]))
    {
        $message = $_POST["status"];
        $image_path = $_FILE["name"]; 
    }
    else
    {
        $message = $_POST["status"];
       /*  $image_path = null; */ 
	    $image_path = "images/Tulips.jpg";
	   /* $image_path = "images/sample1.mp4"; */
    } 
    $status = $_POST["status"];
    $access_token = $_SESSION['access_token'];
    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
	 /* if(strlen($status)>=130)
    {
            $status = substr($status,0,130);
    } */
    $media_id = null;
    # https://dev.twitter.com/rest/reference/get/help/configuration
    $twitter_photo_size_limit = 3145728;
    if($image_path!==null)
    {
        if(file_exists($image_path))
        {
            if(filesize($image_path) < $twitter_photo_size_limit)
            { 
                # Backup base_url
                $original_base_url = "http://powersports3.e2logy.com/sharetwitter/index.php";
                # Need to change base_url for uploading media
                $api_base_url = "https://upload.twitter.com/1.1/";
                # Call Twitter API media/upload.json
                $parameters = array('media' => base64_encode(file_get_contents($image_path)) );
                $response  = $connection->post( 'https://upload.twitter.com/1.1/media/upload.json', $parameters ); 
				 /* echo "Twitter upload response : ";
				var_dump($response);  */
                # Restore base_url
                $api_base_url = $original_base_url;
                # Retrieve media_id from response
                if(isset($response->media_id))
                {
                    $media_id = $response->media_id;
					/* echo "Twitter media_id : ".$media_id; */
                }
            }
            else
            {
				echo "Twitter does not accept files larger than ".$twitter_photo_size_limit.". Check ".$image_path;
            }
        }
        else
        {
           echo "Can't send file ".$image_path." to Twitter cause does not exist ... ";
        }
    }
    if($media_id!==null)
    {
        $parameters = array( 'status' => $message, 'media_ids' => $media_id);
    }
    else
    {
        $parameters = array( 'status' => $message); 
    }
   /*  $response  = $connection->post( 'https://upload.twitter.com/1.1/statuses/update.json', $parameters ); */
    $connection->post('statuses/update', $parameters);
    // check the last HTTP status code returned
    if ( $connection->http_code != 200 ){
        throw new Exception( "Update user status failed! {$this->providerId} returned an error. " . $this->errorMessageByStatus( $connection->http_code ));
    }
    /* $connection->post('statuses/update', array('status' => "$status")); */
    $message = "Tweeted Sucessfully!!";
}
if(isset($_GET["redirect"]))
{  
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
    $request_token = $connection->getRequestToken(OAUTH_CALLBACK); 
	/* echo "<pre>"; print_r($request_token);exit; */
    $_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
    $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
    switch ($connection->http_code) {
      case 200:
       $url = $connection->getAuthorizeURL($token);
        header('Location: ' . $url);
        break;
      default:
         echo 'Could not connect to Twitter. Refresh the page or try again later.';
    }
    exit;
}
if (empty($_SESSION['access_token']) || empty($_SESSION['access_token']['oauth_token']) || empty($_SESSION['access_token']['oauth_token_secret'])) {
	echo '<input id="connect" type="checkbox" value="Connect with Twitter" /> &nbsp;&nbsp;Connect with Twitter';
}
else
{
    echo "<a href='destroysessions.php'>Logout</a><br>";
    echo '<br>'.$message.'<br>
    <form action="index.php" method="post">
        <input type="text" name="status" id="status" placeholder="Write a comment...."><input type="submit" value="Post On My Wall!" style="padding: 5px;">
    </form>';
}
?>
</body>
</html>