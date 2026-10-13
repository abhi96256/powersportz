<?php
//cache header false - by manish
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0, s-maxage=0", false);
header("Pragma:no-cache", false);

include('../common/config/S3.php');
include('../common/config/common.php');
//////
//// CONFIGURATION
//////
//For Debugging.
$logToFile = true;
//Should you need to check that your messages are coming from the correct topicArn
$restrictByTopic = true;
$allowedTopic = "arn:aws:sns:ap-northeast-1:063219502805:Transcoding_video_callback";
//For security you can (should) validate the certificate, this does add an additional time demand on the system.
//NOTE: This also checks the origin of the certificate to ensure messages are signed by the AWS SNS SERVICE.
//Since the allowed topicArn is part of the validation data, this ensures that your request originated from
//the service, not somewhere else, and is from the topic you think it is, not something spoofed.
$verifyCertificate = true;
$sourceDomain = "sns:ap-northeast-1.amazonaws.com";
//////
//// OPERATION
//////
$signatureValid = false;
$safeToProcess = true; //Are Security Criteria Set Above Met? Changed programmatically to false on any security 

if($logToFile){
	////LOG TO FILE:
	$dateString = 'logs/' . date("Ymdhis");
	$dateString = $dateString."_r.txt";
	$myFile = $dateString;
	$fh = fopen($myFile, 'w') or die("Log File Cannot Be Opened.");
}

fwrite($fh, "\n\n===============\n\n");

//Get the raw post data from the request. This is the best-practice method as it does not rely on special php.ini 

//like $HTTP_RAW_POST_DATA. Amazon SNS sends a JSON object as part of the raw post body.
$json = json_decode(file_get_contents("php://input"));

if($logToFile){
	fwrite($fh, "Result:\n".$json->Message);
}

//Check for Restrict By Topic
if($restrictByTopic){
	if($allowedTopic != $json->TopicArn){
		$safeToProcess = false;
		if($logToFile){
			fwrite($fh, "ERROR: Allowed Topic ARN: ".$allowedTopic." DOES NOT MATCH Calling Topic ARN: 

". $json->TopicArn . "\n");
		}
	}
}
//Check for Verify Certificate
if($verifyCertificate){
	//Check For Certificate Source
	$domain = getDomainFromUrl($json->SigningCertURL);
	if($domain != $sourceDomain){
		$safeToProcess = false;
		if($logToFile){
			fwrite($fh, "Key domain: " . $domain . " is not equal to allowed source domain:" .

$sourceDomain. "\n");
		}
	}
	//Build Up The String That Was Originally Encoded With The AWS Key So You Can Validate It Against Its 

	if($json->Type == "SubscriptionConfirmation"){
		$validationString = "";
		$validationString .= "Message\n";
		$validationString .= $json->Message . "\n";
		$validationString .= "MessageId\n";
		$validationString .= $json->MessageId . "\n";
		$validationString .= "SubscribeURL\n";
		$validationString .= $json->SubscribeURL . "\n";
		$validationString .= "Timestamp\n";
		$validationString .= $json->Timestamp . "\n";
		$validationString .= "Token\n";
		$validationString .= $json->Token . "\n";
		$validationString .= "TopicArn\n";
		$validationString .= $json->TopicArn . "\n";
		$validationString .= "Type\n";
		$validationString .= $json->Type . "\n";
		if($logToFile){
			fwrite($fh, "Data Validated Against Certificate.\n");
		}
		
	} else if($json->Type == "Notification"){
		
		$jsonMessage = json_decode($json->Message);
		
		fwrite($fh, "\n\n In notification.\n");
	
		if($jsonMessage->state == "COMPLETED") {
			
			fwrite($fh, "\n Completed \n");
			
			$servername = "10.10.10.28"; //23.21.226.54
			$username = "powersport"; //suntec
			$password = "Dgt569khd"; //Google@123
			$dbname = "powersport"; //PowerSportz

			fwrite($fh, "\n Before connection \n");
			
			// Create connection
			$conn = new mysqli($servername, $username, $password,$dbname);
	
			// Check connection
			if ($conn->connect_error) {
				fwrite($fh, "\n DB Connection Error \n". $conn->connect_error);
				die("Connection failed: " . $conn->connect_error);
			} 
			
			fwrite($fh, "\n after connection \n");
			
			$fileName = $jsonMessage->input->key;
			$outpustStatusForMobile = $jsonMessage->outputs[0]->status;
			$outpustStatusForWeb = $jsonMessage->outputs[1]->status;
			$queryString = "";
			if($outpustStatusForMobile == 'Complete') {
				$mobileStreamUrl = str_replace('mp4_','',basename($jsonMessage->outputs[0]->key));
				$mobileThumbUrl = $jsonMessage->outputs[0]->thumbnailPattern;

				

				$replacedThumbUrl = str_replace('{count}','00001.png',$mobileThumbUrl);
                                $videoType = explode('/',$jsonMessage->outputs[0]->key);
                                if($videoType[0] == 'FullVideos') {
                                    $queryString.=",FullVideoStreamURL = '".$mobileStreamUrl."'";	
                                }
                                if($videoType[0] == 'Videos') {
                                    $queryString.=",VideoStreamURL = '".$mobileStreamUrl."'";	
                                }
								if($videoType[0] == 'adVideos') {
									$newurl = $mobileStreamUrl.'.m3u8';
                                    $queryString.=",URL = '".$newurl."'";	
                                }
			} else {
				if($logToFile){
					fwrite($fh, "Error in transcoding for mobile\n".$jsonMessage->outputs

[0]."\n");
				}
			}
			
			if($outpustStatusForWeb == 'Complete') {
				$webStreamUrl = $jsonMessage->outputs[1]->key;
				//$queryString.=",WebStreamUrl = '".$webStreamUrl."' ";	
			} else {
				if($logToFile){
					fwrite($fh, "Error in transcoding for web\n".$jsonMessage->outputs

[1]."\n");
				}
			}
			
			$queryString = substr($queryString,1);					
                        /*if($videoType[0] == 'FullVideos') {
                            $sql = "UPDATE video SET ".$queryString." WHERE FullVideoURL= '".$fileName."' ";
                        }*/    
                        if($videoType[0] == 'Videos') {
                            $sql = "UPDATE video SET ".$queryString." WHERE VideoURL= '".$fileName."' ";
                        }
                        if($videoType[0] == 'adVideos') {
                            $sql = "UPDATE customadvertisement SET ".$queryString." WHERE VideoURL= '".$fileName."' ";
                        }
                        if($videoType[0] == 'Videos') {
                            $videoData = explode('_',$videoType[2]);
                            $conn->query("DELETE FROM images WHERE VideoID = ".$videoData[2]." AND  ImageType = '1'");
                            
                            $s3 = new \S3(AWSACCESSKEY, AWSSECRETKEY);
							$bucket = S3BUCKETFORVIDEO;
							
							$imagesArr = $s3->getBucket($bucket,'Videos/Thumb/'.$videoData[2]);
							if(!empty($imagesArr)){
								
								$counter = 0;
								$valuestr = '';
								foreach ($imagesArr as $key => $value) {
									if(strpos($key, "/mainvideo/") === false){
										if($valuestr != ''){
											$valuestr .= ',';
											$valuestr .= "(".$videoData[2].",'".$key."','1','0')";
										}else{
											$valuestr .= "(".$videoData[2].",'".$key."','1','1')";
										}
									}
								}
	                            $shortVideoImageQuery = "INSERT INTO images (VideoID,ImageName,ImageType,IsThumb) VALUES $valuestr";
	                            $conn->query($shortVideoImageQuery);
								fwrite($fh, "\n Query: \n".$shortVideoImageQuery);
								//Get Default Images first images from images table.
								$getimageQuery = $conn->query("SELECT * FROM images WHERE VideoID = '".$videoData[2]."' && IsThumb = 1 && ImageType = 1  limit 1");
								$images_id = mysqli_fetch_assoc($getimageQuery);
								fwrite($fh, "\n Images = : \n".json_encode($images_id));
								$ThumbID = $images_id['ImageID'];
								$result = mysqli_fetch_assoc($conn->query("SELECT id FROM defaultthumbnail WHERE VideoID = '".$videoData[2]."'"));
								if(!empty($result)){
										$conn->query("update defaultthumbnail set ThumbID = '".$ThumbID."' WHERE VideoID = ".$videoData[2]." ");
										//fwrite($fh, "\n Query: \n"."update defaultthumbnail set ThumbID = '".$ThumbID."' WHERE VideoID = ".$videoData[2]." ");
								}else{

									$conn->query("INSERT defaultthumbnail (VideoID,ThumbID) VALUES('".$videoData[2]."','".$ThumbID."')");
									//fwrite($fh, "\n Query: \n"."INSERT defaultthumbnail (VideoID,ThumbID) VALUES('".$videoData[2]."','".$ThumbID."')");
								}
								$conn->query("INSERT video_thumbnail_images (video_id,images_id,type) VALUES('".$videoData[2]."','".$ThumbID."',0)");
							}
                            
                        }
			
			fwrite($fh, "\n Query: \n".$sql);

			if ($conn->query($sql) === false) {
				if($logToFile){
					fwrite($fh, "Error in update\n".mysqli_error($conn)."\n");
				}
			}
			$conn->close();
			
		} else {
			if($logToFile){
				fwrite($fh, "Error in transcoding\n".$json."\n");
			}
		}
	}
}

if($safeToProcess){
	//Handle A Subscription Request Programmatically
	if($json->Type == "SubscriptionConfirmation"){
		//RESPOND TO SUBSCRIPTION NOTIFICATION BY CALLING THE URL
		
		if($logToFile){
			fwrite($fh, "\n\n".$json->SubscribeURL);
		}
		
		$curl_handle=curl_init();
		curl_setopt($curl_handle,CURLOPT_URL,$json->SubscribeURL);
		curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
		curl_exec($curl_handle);
		curl_close($curl_handle);	
	}
}
//Clean Up For Debugging.
if($logToFile){
	ob_start();
	fwrite($fh, "\n\n");
	print_r( $json );
	$output = ob_get_clean();
	fwrite($fh, "\n\n".$output);
	fclose($fh);
}
//A Function that takes the key file, signature, and signed data and tells us if it all matches.
function validateCertificate($keyFileURL, $signatureString, $data){
	$signature = base64_decode($signatureString);
	// fetch certificate from file and ready it
	$fp = fopen($keyFileURL, "r");
	$cert = fread($fp, 8192);
	fclose($fp);
	$pubkeyid = openssl_get_publickey($cert);
	$ok = openssl_verify($data, $signature, $pubkeyid, OPENSSL_ALGO_SHA1);
	if ($ok == 1) {
	    return true;
	} elseif ($ok == 0) {
	    return false;
	    
	} else {
	    return false;
	}	
}
//A Function that takes a URL String and returns the domain portion only
function getDomainFromUrl($urlString){
	$domain = "";
	$urlArray = parse_url($urlString);
	if($urlArray == false){
		$domain = "ERROR";
	}else{
		$domain = $urlArray['host'];
	}
	return $domain;
}

?>
