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
                'version' => '2012-11-05'
        ));

    }

    /**
     * 
     * @param type $msg
     */
    public function sendInBoundMessage($sqsMessage)
    {
        try {
            $this->sqsClient->sendMessage(array('QueueUrl' => self::INBOUND_URL, 'MessageBody' => $sqsMessage->content));
        }
        catch (Exception $e) {
           die('Error sending message to queue ' . $e->getMessage());
        } 
    }
}
