<?php
require('ElasticTranscoder.php');
$awsAccessKey = 'AKIAQ5OBNB3KR3OUGLMJ';
$awsSecretKey = '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';
$awsRegion = 'us-east-1';
$et = new AWS_ET($awsAccessKey, $awsSecretKey, $awsRegion);
/*$pipelineId = 'pipelineId';
$input = array('Key' => 'inputFile');
$output = array(
  'Key' => 'outputFile.mp4',
  'PresetId' => 'presetId'
 );*/
 
$pipelineId = '1437650086970-xy3cwo';
$input = array('Key' => 'TestVideo.mp4');
$output = array(
  'Key' => 'outputFile.mp4',
  'PresetId' => '1351620000001-000010'
 ); 

$result = AWS_ET::createJob($input, array($output), $pipelineId);

if (!$result) {
  echo AWS_ET::getErrorMsg();
} else {
  echo 'New job ID: ' . $result['Job']['Id'];
}
