<?php
/*define('S3BUCKET','testvideoin');
define('S3BUCKETFORVIDEO','testvideoout');*/
define('S3BUCKET','powersportvideoin');
define('S3BUCKET_VIDEO','powersportsubscribervideoin');
define('S3BUCKETFORVIDEO','powersportvideoout');

define('STICKER_IMAGES','stickerimages');
define('BOOM','boom-');
define('ARTIST_IMAGES','artistimages');
define('PROFILE_IMAGES','profileimages');
define('POST_IMAGES','postimages');
define('POST_VIDEOS','postvideos');
define('SIMILAR_APP','similarapp');

define('AWSACCESSKEY','AKIAINZPQ35KFEZFHQJQ');
define('AWSSECRETKEY','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');
define('AWSREGION','ap-northeast-1');

define('PIPELINEID','1441703597680-8etfe9');
define('WEBMP4PRESET','1351620000001-000020');
//define('WEBMPPRESETCUSTOM','1351620000001-000010');


//AWS access info
if (!defined('awsAccessKey')) define('awsAccessKey', AWSACCESSKEY);
if (!defined('awsSecretKey')) define('awsSecretKey', AWSSECRETKEY);
			
//instantiate the class
$s3 = new S3(AWSACCESSKEY, AWSSECRETKEY);


$s3->putBucket(S3BUCKET, S3::ACL_PUBLIC_READ);




/*define('S3BUCKET','boomvideo-in');
define('S3BUCKETFORVIDEO','boomvideo-out');
define('STICKER_IMAGES','stickerimages');
define('BOOM','boom-');
define('ARTIST_IMAGES','artistimages');
define('PROFILE_IMAGES','profileimages');
define('POST_IMAGES','postimages');
define('POST_VIDEOS','postvideos');
define('SIMILAR_APP','similarapp');

define('AWSACCESSKEY','AKIAJBFOB42S5BTVJWBQ');
define('AWSSECRETKEY','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');
define('AWSREGION','ap-northeast-1');

define('PIPELINEID','1444383927485-ux18r5');
define('WEBMP4PRESET','1351620000001-000020');
//define('WEBMPPRESETCUSTOM','1351620000001-000010');


//AWS access info
if (!defined('awsAccessKey')) define('awsAccessKey', 'AKIAJBFOB42S5BTVJWBQ');
if (!defined('awsSecretKey')) define('awsSecretKey', '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');
			
//instantiate the class
$s3 = new S3(awsAccessKey, awsSecretKey);
$s3->putBucket(S3BUCKET, S3::ACL_PUBLIC_READ);*/
