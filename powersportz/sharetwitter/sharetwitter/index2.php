<?php
session_start();
// Script to test if the CURL extension is installed on this server
/* function _is_curl_installed() {
    if  (in_array  ('curl', get_loaded_extensions())) {
        return true;
    }
    else {
        return false;
    }
}

// Ouput text to user based on test
if (_is_curl_installed()) {
  echo "cURL is <span style=\"color:blue\">installed</span> on this server";
} else {
  echo "cURL is NOT <span style=\"color:red\">installed</span> on this server";
} exit; */
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
  </head>
  <body>
    <div>
      <h2>Demo Post Tweet On Twitter With PHP.&nbsp;&nbsp;&nbsp;</h2>
<?php
require_once('oauth/twitteroauth.php');
require_once('config.php');
if(isset($_POST["status"]))
{
    $status = $_POST["status"];
    if(strlen($status)>=130)
    {
            $status = substr($status,0,130);
    }
    $access_token = $_SESSION['access_token'];
    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

    $connection->post('statuses/update', array('status' => "$status"));
    $message = "Tweeted Sucessfully!!";
}
if(isset($_GET["redirect"]))
{  /* echo CONSUMER_KEY."<br>".CONSUMER_SECRET."<br>".OAUTH_CALLBACK; */
   
    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);

    $request_token = $connection->getRequestToken(OAUTH_CALLBACK);
     
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
    echo '<a href="index.php?redirect=true"><img src="./images/lighter.png" alt="Sign in with Twitter"/></a>';
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