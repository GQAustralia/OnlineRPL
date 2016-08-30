<?php

require 'vendor/autoload.php';
require 'config.php';
require 'database.php';

use Aws\Common\Enum\DateFormat;
use Aws\S3\Model\MultipartUpload\UploadId;
use Aws\Sqs\SqsClient;
use Aws\S3\S3Client;

$s3 = S3Client::factory(array(
    'key' => AWS_KEY,
    'secret' => AWS_SECRET
));
$client = SqsClient::factory(array(
    'key' => AWS_KEY,
    'secret' => AWS_SECRET,
    'region' => REGION
));
$queueUrl = QUEUEURL;
$queueComplete = false;
$ans = $reciptHandles = array();
$messageIds = array();
$i = 0;
while(!$queueComplete) {
    $result = $client->receiveMessage(array(
        'MaxNumberOfMessages'=>10,
        'QueueUrl' => $queueUrl,
        'WaitTimeSeconds' => 10,
    ));

    $messages = $result->get('Messages');
    if(count($messages) > 0) {
        foreach ($messages as $message) {
            // Do something with the message
            $body = $message['Body'];
            $mid = $messageIds[] = $message['MessageId'];
            $temp = json_decode($body,true);
            //$temp1 = json_decode($temp['Message'],true);
            $an = $ans[$message['MessageId']]=$temp;
            $reciptHandles[$message['MessageId']] = $message['ReceiptHandle'];
            if($pdoObject->isPending($an['jobId'])) {
                $result = $s3->deleteObject(array(
                    'Bucket' => BUCKET_NAME2,
                    'Key'    => $an['input']["key"]
                ));
                if(empty($result->get('DeleteMarker'))) {
                    $pdoObject->setJobStatus($an['jobId']);
                    $result = $client->deleteMessage(array(
                        // QueueUrl is required
                        'QueueUrl' => $queueUrl,
                        // ReceiptHandle is required
                        'ReceiptHandle' => $reciptHandles[$mid],
                    ));
                    $pdoObject->updateRPL($an['jobId']);
                }

            }else {
                $result = $client->deleteMessage(array(
                    // QueueUrl is required
                    'QueueUrl' => $queueUrl,
                    // ReceiptHandle is required
                    'ReceiptHandle' => $reciptHandles[$mid],
                ));
            }
            $i++;

        }
       // if($i > 20) $queueComplete = true;
    }else {
        $queueComplete = true;
    }
   
}

foreach ($ans as $mid=>$an) {
    if($pdoObject->isPending($an['jobId'])) {
        /* $result = $s3->deleteObject(array(
            'Bucket' => BUCKET_NAME2,
            'Key'    => $an['input']["key"]
        )); */
       // if(empty($result->get('DeleteMarker'))) {
            $pdoObject->setJobStatus($an['jobId']);
            $result = $client->deleteMessage(array(
                // QueueUrl is required
                'QueueUrl' => $queueUrl,
                // ReceiptHandle is required
                'ReceiptHandle' => $reciptHandles[$mid],
            ));
       // }

    }else {
        $result = $client->deleteMessage(array(
            // QueueUrl is required
            'QueueUrl' => $queueUrl,
            // ReceiptHandle is required
            'ReceiptHandle' => $reciptHandles[$mid],
        ));
    }
}
//echo json_encode($ans);
//echo json_encode($messageIds);