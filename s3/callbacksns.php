<?php

require 'vendor/autoload.php';
require 'config.php';
require 'database.php';

use Aws\Common\Enum\DateFormat;
use Aws\S3\Model\MultipartUpload\UploadId;
use Aws\Sqs\SqsClient;
use Aws\S3\S3Client;
use Aws\Sns\MessageValidator\Message;
use Aws\Sns\MessageValidator\MessageValidator;
use Guzzle\Http\Client;
$postBody = file_get_contents('php://input');
$message = Message::fromRawPostData();
if ($message->get('Type') === 'SubscriptionConfirmation') {
	// Send a request to the SubscribeURL to complete subscription
	(new Client)->get($message->get('SubscribeURL'))->send();
}
// JSON decode the body to an array of message data
//$pdoObject->insertTest($postBody);
//$message = json_decode($postBody, true);
//
//if ($message) {
//    // Do something with the data
//    
//    echo $message['Message'];
//}
// Make sure the request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die;
}

//try {
//    // Create a message from the post data and validate its signature
//    $message = Message::fromRawPostData();
//    $pdoObject->insertTest($message);
//    $validator = new MessageValidator();
//    $validator->validate($message);
//} catch (Exception $e) {
//    // Pretend we're not here if the message is invalid
//    $pdoObject->insertTest($e->getMessage());
//    http_response_code(404);
//    die;
//}
$s3 = S3Client::factory(array(
    'key' => AWS_KEY,
    'secret' => AWS_SECRET
));
//$pdoObject->insertTest($s3);
$message = json_decode($postBody, true);
if (!empty($message) ){
    // Do something with the data
    $an = $message;
    if(!empty($an['jobId'])) {
        if($pdoObject->isPending($an['jobId'])) {
            /* $result = $s3->deleteObject(array(
                'Bucket' => BUCKET_NAME2,
                'Key'    => $an['input']["key"]
            )); */
            //if(empty($result->get('DeleteMarker'))) {
                $pdoObject->setJobStatus($an['jobId']);
                $pdoObject->updateRPL($an['jobId']);
           // }

        }
    }
}

//if ($message->get('Type') === 'SubscriptionConfirmation') {
//    // Send a request to the SubscribeURL to complete subscription
//    (new Client)->get($message->get('SubscribeURL'))->send();
//} elseif ($message->get('Type') === 'Notification') {
    // Do something with the notification
    //$an = $message->get('Message');
    
//}

//echo json_encode($ans);
//echo json_encode($messageIds);