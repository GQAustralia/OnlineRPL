<?php

namespace GqAus\UserBundle\Services;

use Aws\Sqs\SqsClient;

class SQSService
{

    /**
     * @var Object
     */
    private $container;


    private $sqsClient;
    
//    const INBOUND_URL = 'https://sqs.ap-southeast-2.amazonaws.com/187591088561/CRMInboundMessage';
    const INBOUND_URL = 'https://sqs.ap-southeast-2.amazonaws.com/187591088561/CRMOutboundQueue';
    
    
    /**
     * Constructor
     * @param object $em
     * @param object $container
     * @param object $mailer
     */
    public function __construct($container)
    {
        $this->container = $container;
      
        $this->sqsClient = SqsClient::factory(array(
                'credentials' => array(
                        'key'    => $this->container->getParameter('amazon_aws_key'),
                        'secret' => $this->container->getParameter('amazon_aws_secret_key'),
                        
                ),
                'region' => 'ap-southeast-2',
                'version' => '2012-11-05',
                'scheme' => 'http',
                'http' => [
                    'verify' => false
                ]
        ));

    }

    /**
     * 
     * @param type $msg
     */
    public function sendInBoundMessage($sqsMessage)
    {
        $portfolioUpdate = [];
        $portfolioUpdate["object"] = "Enrollment__c";
        $portfolioUpdate['fields'] = [
            'Name' => $sqsMessage['type'],
            'Provider_Code__c' => 'Enrollment__c',
            'CURRENT__c' => date('Y-m-d H:i:s'),
            'Description' => $sqsMessage['content'],
        ];     
        $arg = [
            'MessageBody' => json_encode($portfolioUpdate), // REQUIRED
            'QueueUrl' => self::INBOUND_URL, // REQUIRED
        ];
        $finalArray = ['status' => 'failed','message' => ''];
        try {
            $sqsResponse = $this->sqsClient->sendMessage($arg);
            if (!empty($sqsResponse->get('MessageId'))) {
                $finalArray = [
                    'status' => 'success',
                    'message' => $sqsResponse->get('MessageId')
                ];
            }else{
                $finalArray = [
                    'status' => 'failed',
                    'message' => $sqsResponse->get('Message')
                ];
            }
        } catch (Exception $e) {
            $finalArray = [
                    'status' => 'failed',
                    'message' => $e->getMessage()
                ];
        }
        return $finalArray;
    }
}
