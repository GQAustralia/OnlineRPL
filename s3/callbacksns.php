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
try {
       $message = Message::fromRawPostData();
	$validator = new MessageValidator();
        $validator->validate($message);
	
    } catch (\Exception $e) {
        // Pretend we're not here if the message is invalid
        //$pdoObject->insertTest(addslashes($e->getMessage()));
   }
if (isset($message) && $message->get('Type') === 'SubscriptionConfirmation') {
		// Send a request to the SubscribeURL to complete subscription
		(new Client)->get($message->get('SubscribeURL'))->send();
	}
	
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die;
}

$s3 = S3Client::factory(array(
    'key' => AWS_KEY,
    'secret' => AWS_SECRET
));
$postBody = file_get_contents('php://input');
$message = json_decode(trim($postBody), true);

if (!empty($message) ){
    // Do something with the data
    $an = $message['Message'];
	$an = json_decode($an,true);
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
