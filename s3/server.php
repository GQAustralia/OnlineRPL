<?php
header('Access-Control-Allow-Origin: *');
function sendJson($arr)
{
    header('Content-Type: application/json');
    die(json_encode($arr));
}

$command = isset($_GET['command']) ? strtolower($_GET['command']) : '';

require 'vendor/autoload.php';
require 'config.php';
require 'database.php';

use Aws\Common\Enum\DateFormat;
use Aws\S3\Model\MultipartUpload\UploadId;
use Aws\S3\S3Client;
use Aws\ElasticTranscoder\ElasticTranscoderClient;

$client = S3Client::factory(array(
        'key' => AWS_KEY,
        'secret' => AWS_SECRET
    ));

function isAllowed()
{
//wow, what a validator :P
//WARNING: this is just a demonstration, convert it to your own need
    return ($_REQUEST['otherInfo']['user'] == 'user' && $_REQUEST['otherInfo']['pass'] == 'pass');
}
$otherInfo = isset($_REQUEST['otherInfo'])?$_REQUEST['otherInfo']:$_REQUEST['sendBackData']['otherInfo'];
$bucket = ($otherInfo["isTranscodeActive"] == 'true')?BUCKET_NAME2:BUCKET_NAME;
$transcode_bucket = BUCKET_NAME;
switch ($command) {
    case 'createmultipartupload': {
            if (!isAllowed()) {
                header(' ', true, 403);
                die('You are not authorized');
            }
			$folder = !empty($_REQUEST['otherInfo']['userDirectory'])?$_REQUEST['otherInfo']['userDirectory'].'/':'';
            $filename = sprintf('%s-%s-%s-%s', date('Y'), date('m'), date('d'), uniqid()).$_REQUEST['fileInfo']['name'];
            /* @var $multipartUploadModel UploadId */
            $model = $client->createMultipartUpload(array(
                'Bucket' => $bucket,
                'Key' => $folder.$filename,
                'ContentType' => $_REQUEST['fileInfo']['type'],
                'Metadata' => $_REQUEST['fileInfo']
            ));

            sendJson(array(
                'uploadId' => $model->get('UploadId'),
                'key' => $model->get('Key'),
                'fileName' => $filename,
                'filePath' => $folder,
                'otherInfo' => $_REQUEST['otherInfo']
            ));
            break;
        }
    case 'signuploadpart': {
            $command = $client->getCommand('UploadPart',
                array(
                    'Bucket' => $bucket,
                'Key' => $_REQUEST['sendBackData']['key'],
                'UploadId' => $_REQUEST['sendBackData']['uploadId'],
                'PartNumber' => $_REQUEST['partNumber'],
                'ContentLength' => $_REQUEST['contentLength']
            ));

            $request = $command->prepare();
            // This dispatch commands wasted a lot of my times :'(
            $client->dispatch('command.before_send', array('command' => $command));
            $request->removeHeader('User-Agent');
            $request->setHeader('x-amz-date', gmdate(DateFormat::RFC2822));
            // This dispatch commands wasted a lot of my times :'(
            $client->dispatch('request.before_send', array('request' => $request));

            sendJson(array(
                'url' => $request->getUrl(),
                'authHeader' => (string) $request->getHeader('Authorization'),
                'dateHeader' => (string) $request->getHeader('x-amz-date'),
            ));
            break;
        }
    case 'completemultipartupload': {
            $partsModel = $client->listParts(array(
                'Bucket' => $bucket,
                'Key' => $_REQUEST['sendBackData']['key'],
                'UploadId' => $_REQUEST['sendBackData']['uploadId'],
            ));

            $model = $client->completeMultipartUpload(array(
                'Bucket' => $bucket,
                'Key' => $_REQUEST['sendBackData']['key'],
                'UploadId' => $_REQUEST['sendBackData']['uploadId'],
                'Parts' => $partsModel['Parts'],
            ));
            $result = $client->putObjectAcl(array(
                'ACL' => ACL,
                'Bucket' => $bucket,
                'Key' => $_REQUEST['sendBackData']['key'],
            ));
            $outputFile = $_REQUEST['sendBackData']['fileName'];
            $jobId = "";
            if(!empty($_REQUEST['sendBackData']['otherInfo'])) {
                $otherInfo = $_REQUEST['sendBackData']['otherInfo'];
                if(isset($otherInfo["isTranscodeActive"]) && $otherInfo["isTranscodeActive"] == 'true') {
                    $preset = VIDEOPRESET;
                    $ext = 'mp4';
                    if($otherInfo["presetType"] == 'audio'){
                        $preset = AUDIOPRESET;
                        $ext = 'mp3';
                    }
                    $fext = pathinfo($_REQUEST['sendBackData']['fileName'], PATHINFO_EXTENSION);

                    $fileName = basename($_REQUEST['sendBackData']['fileName'], ".".$fext);
                    $outputFile = $fileName.".".$ext;
                    $elasticTranscoder = ElasticTranscoderClient::factory(array(
                        'key' => AWS_KEY,
                        'secret' => AWS_SECRET,
                        'region' => REGION
                    ));
                    $job = $elasticTranscoder->createJob(array(

                        'PipelineId' => PIPELINE_ID,

                        'OutputKeyPrefix' => $_REQUEST['sendBackData']['filePath'].'transcode-',

                        'Input' => array(
                            'Key' => $_REQUEST['sendBackData']['filePath'].$_REQUEST['sendBackData']['fileName'],
                            'FrameRate' => 'auto',
                            'Resolution' => 'auto',
                            'AspectRatio' => 'auto',
                            'Interlaced' => 'auto',
                            'Container' => 'auto',
                        ),

                        'Outputs' => array(
                            array(
                                'Key' => $outputFile,
                                'Rotate' => 'auto',
                                'PresetId' => $preset,
                            ),
                        ),
                    ));

// get the job data as array
                    $jobData = $job->get('Job');

// you can save the job ID somewhere, so you can check
// the status from time to time.
                    $jobId = $jobData['Id'];
                    $outputFile = 'transcode-'.$outputFile;
                    $pdoObject->createJob($jobId);
                }
            }
            sendJson(array(
                'success' => true,
                'jobId'  => $jobId,
                'fileName' => $outputFile
            ));
            break;
        }
    case 'abortmultipartupload': {
            $model = $client->abortMultipartUpload(array(
                'Bucket' => $bucket,
                'Key' => $_REQUEST['sendBackData']['key'],
                'UploadId' => $_REQUEST['sendBackData']['uploadId']
            ));

            sendJson(array(
                'success' => true
            ));
            break;
        }
    default: {
            header(' ', true, 404);
            die('Command not understood');
            break;
        }
}