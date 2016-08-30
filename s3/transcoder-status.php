<?php

require 'vendor/autoload.php';
require 'config.php';

use Aws\Common\Enum\DateFormat;
use Aws\S3\Model\MultipartUpload\UploadId;
use Aws\ElasticTranscoder\ElasticTranscoderClient;
use Aws\S3\S3Client;

$jobId= $_GET['jobId'];

$elasticTranscoder = ElasticTranscoderClient::factory(array(
    'key' => AWS_KEY,
    'secret' => AWS_SECRET,
    'region' => 'ap-southeast-2'
));

//$result = $elasticTranscoder->createPipeline(array(
//    // Name is required
//    'Name' => date('Y-m-d'),
//    // InputBucket is required
//    'InputBucket' => 'testingcdn',
//    'OutputBucket' => 'testingcdn',
//    // Role is required
//    'Role' => 'arn:aws:iam::187591088561:role/Elastic_Transcoder_Default_Role',
//    'Notifications' => array(
//        'Progressing' => '',
//        'Completed' => 'arn:aws:sns:ap-southeast-2:187591088561:PipelineNotification',
//        'Warning' => '',
//        'Error' => '',
//    )
//));

$result = $elasticTranscoder->deletePipeline(array(
    // Id is required
    'Id' => '1471961651715-nv956m',
));
//$result = $elasticTranscoder->listJobsByStatus(array(
//    // Status is required
//    'Status' => 'Complete'
//));
echo '<pre>';
var_dump($result);
//$resposne = $elasticTranscoder->listJobsByStatus(array('status'=>'Complete'));
//var_dump($resposne);

//$jobData = $resposne->get('Job');

//echo $jobData['Status'];
//if ($jobData['Status'] !== 'progressing'
//    && $jobData['Status'] !== 'submitted')
//{
//    echo $jobData['Status'];
//}