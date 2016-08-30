<?php

require 'vendor/autoload.php';
require 'config.php';

use Aws\Common\Enum\DateFormat;
use Aws\S3\Model\MultipartUpload\UploadId;
use Aws\ElasticTranscoder\ElasticTranscoderClient;
use Aws\S3\S3Client;


$elasticTranscoder = ElasticTranscoderClient::factory(array(
    'key' => AWS_KEY,
    'secret' => AWS_SECRET,
    'region' => 'ap-southeast-2'
));
//$elasticTranscoder = ElasticTranscoderClient::factory(array(
//    'credentials' => array(
//        'key' => 'AKIAJXKS7MGMDP6Y3MAA',
//        'secret' => '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',
//    ),
//    'region' => 'ap-southeast-2', // dont forget to set the region
//));

$job = $elasticTranscoder->createJob(array(

    'PipelineId' => '1471961651715-nv956m',

    'OutputKeyPrefix' => 'Samir/',

    'Input' => array(
        'Key' => 'Samir/Wildlife.wmv',
        'FrameRate' => 'auto',
        'Resolution' => 'auto',
        'AspectRatio' => 'auto',
        'Interlaced' => 'auto',
        'Container' => 'auto',
    ),

    'Outputs' => array(
        array(
            'Key' => 'Wildlife.mp4',
            'Rotate' => 'auto',
            'PresetId' => '1351620000001-000061',
        ),
    ),
));

// get the job data as array
$jobData = $job->get('Job');

// you can save the job ID somewhere, so you can check
// the status from time to time.
echo $jobId = $jobData['Id'];