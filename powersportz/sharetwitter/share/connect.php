<?php 
error_reporting(E_ALL);
ini_set("display_errors", 1);
require('../../common/config/common.php');

/*define('TWITTER_CONSUMER_KEY', 'PfDEG7poTqjYk8oo7alqFQmhz');
define('TWITTER_CONSUMER_SECRET', 'NABpOGsvtgsU4OaEpSFy6Kn36RiZz3NtIA4NUiyPtSZaVKv68w');
define('TWITTER_REQUEST_URL',       'https://api.twitter.com/oauth/request_token');
define('TWITTER_ACCESS_URL',        'https://api.twitter.com/oauth/access_token');
define('TWITTER_AUTHORIZE_URL',     'https://api.twitter.com/oauth/authorize');*/


/*echo phpinfo();die;*/


session_start();
require_once('oauth/twitteroauth.php');


if(!empty($_GET['tweet'])){
    tweet($_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
}else{
    setOAuth();
}

if (!isset($_SESSION['twitter'])) {

    $_SESSION['twitter'] = getUserInfo($_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
 }

function setOAuth()
{
   /* 
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
    */
    //  pecl_oauth
    $oauth = new OAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET, OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_FORM);
    $oauth->enableDebug();
   // print_r($oauth);die;
    try {
        if (isset($_GET['oauth_token'], $_SESSION['oauth_token_secret'])) {
            $oauth->setToken($_GET['oauth_token'], $_SESSION['oauth_token_secret']);
            $accessToken = $oauth->getAccessToken(TWITTER_ACCESS_URL);

            $_SESSION['oauth_token'] = $accessToken['oauth_token'];
            $_SESSION['oauth_token_secret'] = $accessToken['oauth_token_secret'];
            
            $response = $oauth->getLastResponse();
            parse_str($response, $get);
            if (!isset($get['user_id'])) {
                throw new Exception('Authentication failed.');
            }
        } else {
            $requestToken = $oauth->getRequestToken(TWITTER_REQUEST_URL);
            $_SESSION['oauth_token_secret'] = $requestToken['oauth_token_secret'];
            header('Location: ' . TWITTER_AUTHORIZE_URL . '?oauth_token=' . $requestToken['oauth_token']);
            die();
        }
    } catch (Exception $e) {
        echo "<pre>";
        print_r($oauth->debugInfo);
        //var_dump($oauth->debugInfo);
        die($e->getMessage());
    }
}
 
function getUserInfo($token, $secret)
{
    $oauth = new OAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET, OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_URI);
    $oauth->setToken($token, $secret);
    $oauth->fetch('https://api.twitter.com/1.1/account/verify_credentials.json');
    $buf = $oauth->getLastResponse();

    return json_decode($buf, true);
}

function tweet($token, $secret){
    $message = $_POST['message'];
    $image_path = $_POST['image_url'];
    $connection = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET, $token, $secret);
   
     # Backup base_url
    $original_base_url = "http://powersports3.e2logy.com/sharetwitter/index.php";
    # Need to change base_url for uploading media
    $api_base_url = "https://upload.twitter.com/1.1/";
    # Call Twitter API media/upload.json
    $parameters = array('media' => base64_encode(file_get_contents($image_path)) );
    $response  = $connection->post('https://upload.twitter.com/1.1/media/upload.json', $parameters ); 
  /*   echo "Twitter upload response : ";
    var_dump($response);  die;*/
    # Restore base_url
    $api_base_url = $original_base_url;
    # Retrieve media_id from response
    if(isset($response->media_id))
    {
        $media_id = $response->media_id;
        /* echo "Twitter media_id : ".$media_id; */
    }
    if($media_id!==null)
    {
        $parameters = array( 'status' => $message, 'media_ids' => $media_id);
    }
    else
    {
        $parameters = array( 'status' => $message); 
    }
   // $response  = $connection->post( 'https://upload.twitter.com/1.1/statuses/update', $parameters ); 
    /*  echo "Twitter upload response : ";
    var_dump($response);  die;*/
     $connection->post('statuses/update', $parameters);
    // check the last HTTP status code returned
    if ( $connection->http_code != 200 ){
       // echo $connection->http_code;
       throw new Exception( "Update user status failed! {$this->providerId} returned an error. " . $this->errorMessageByStatus( $connection->http_code ));
    }
    /* $connection->post('statuses/update', array('status' => "$status")); */
    $message = "Tweeted Sucessfully!!";
    echo   $message;
}
?>
<script type='text/javascript'>
            window.close();
        </script>
       