<?php
/*define('S3BUCKET','testvideoin');
define('S3BUCKET_VIDEO','powersportzin');
define('S3BUCKETFORVIDEO','testvideoout');
*/
define('S3BUCKET','powersportz-uploaded-video-prod');
define('S3BUCKET_VIDEO','subscribervideo');
define('S3BUCKETFORVIDEO','powersportz-transcoding-video-prod');
define('S3BUCKET_AD','powersportz-uploaded-video-prod');

define('ADVERISEMENT','Advertisement');
define('PREFIX_ADVERISEMENT','advertisement_');
define('GAMERULES','GameRules');
define('PREFIX_GAMERULES','gamerules_');
define('CONTENT','Content');
define('PREFIX_CONTENT','content_');
define('PLAYLIST','Playlist');
define('PREFIX_PLAYLIST','playlist_');
define('TOPICS','Topics');
define('PREFIX_TOPICS','topics_');
define('IMAGES','Images');
define('VIDEOS','Videos');
define('ADVIDEOS','adVideos');

define('THUMBNAILS','Thumbnails');
define('THUMBNAILS_THUMB','Thumb');
define('THUMBNAILS_MEDIUM','Medium');
define('FULLVIDEOS','FullVideos');

define('SIZE_MEDIUM', '640x360');
define('SIZE_THUMB', '320x180');

define('AWSACCESSKEY','AKIAQ5OBNB3KR3OUGLMJ');
define('AWSSECRETKEY','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');
define('AWSREGION','ap-northeast-1');

define('Thumbheight',100);
define('Mediumheight',200);


define('PIPELINEID','1441703597680-8etfe9');
define('WEBMP4PRESET','1351620000001-000020');
//define('WEBMPPRESETCUSTOM','1351620000001-000010');

define('GooglePlusClientID','10412981768-7q9q88kkdmm1b529mg9aktk7gb1nhe22.apps.googleusercontent.com');
define('GooglePlusApiKey','AIzaSyBgMwxzKI70CM5wb2772vtxW6TKC0N_pNg');
define('GooglePlusScope','https://www.googleapis.com/auth/plus.me');


define('twitterApiKey' , 'KIUabfdDEhNdg3SrbBFk6PKBM ');
define('twitterApiSecret' , 'pD656xHx6AQlX1yYBi4bOdrSFWu6LFOH5gKOA49jHF0Jh8dvos');
define('twitterAccessToken' , '	4417738454-xrS1tIg6u8CxhyqiP7QnRHBigPIHbSrLAMbErtN');
define('twitterAccessTokenSecret' , '6qQ9N5VjhX6DDWW7y0nSPXOc3f8tBaDcfjKGiZxDD2h3E');

define("CONSUMER_KEY", '2rXkYiWnZde5Q1J0i4vE1b9Q0');
define("CONSUMER_SECRET", '9tpcD0NgQX9nq7sPemWRltqdetUAkTpXQ3fz4NNwYywgYrAEkD');
define("OAUTH_CALLBACK", 'http://powersports3.e2logy.com/sharetwitter/callback.php');


define('TWITTER_CONSUMER_KEY', 'PfDEG7poTqjYk8oo7alqFQmhz');
define('TWITTER_CONSUMER_SECRET', 'NABpOGsvtgsU4OaEpSFy6Kn36RiZz3NtIA4NUiyPtSZaVKv68w');
define('TWITTER_REQUEST_URL',       'https://api.twitter.com/oauth/request_token');
define('TWITTER_ACCESS_URL',        'https://api.twitter.com/oauth/access_token');
define('TWITTER_AUTHORIZE_URL',     'https://api.twitter.com/oauth/authorize');

define('AESKEY','powersportz');

define('S3_BUCKETABSOLUTE_PATH','http://'.S3BUCKET.'.s3.amazonaws.com');
//define('S3_VIDEO_BUCKETABSOLUTE_PATH','http://'.S3BUCKETFORVIDEO.'.s3.amazonaws.com/');
define('S3_SUBSCRIBER_VIDEO_BUCKETABSOLUTE_PATH','http://'.S3BUCKET_VIDEO.'.s3.amazonaws.com/');
//define('S3_VIDEO_BUCKETABSOLUTE_PATH','http://d1gi3s9hp6mq2s.cloudfront.net/');
//define('S3_VIDEO_BUCKETABSOLUTE_PATH_AUTO','http://d1gi3s9hp6mq2s.cloudfront.net/');
//define('S3_VIDEO_BUCKETABSOLUTE_PATH','http://s3-ap-northeast-1.amazonaws.com/transcodingvideo/');
//define('S3_VIDEO_BUCKETABSOLUTE_PATH_AUTO','http://s3-ap-northeast-1.amazonaws.com/transcodingvideo/');
define('S3_VIDEO_BUCKETABSOLUTE_PATH','http://djw8d0z9052y7.cloudfront.net/');
define('S3_VIDEO_BUCKETABSOLUTE_PATH_AUTO','http://djw8d0z9052y7.cloudfront.net/');

define('S3_THUMB_CLOUDFRONT','http://drwqnsbdhm8v.cloudfront.net');

//define('CDN_VIDEO_URL','http://d39sam12cwl30k.cloudfront.net/');
define('CDN_VIDEO_URL','http://djw8d0z9052y7.cloudfront.net/');


//AWS access info
if (!defined('awsAccessKey')) define('awsAccessKey', AWSACCESSKEY);
if (!defined('awsSecretKey')) define('awsSecretKey', AWSSECRETKEY);
		
//instantiate the class
if(class_exists('S3')){
	$s3 = new S3(AWSACCESSKEY, AWSSECRETKEY);
	$s3->putBucket(S3BUCKET, S3::ACL_PUBLIC_READ);
}
