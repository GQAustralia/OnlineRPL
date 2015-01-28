<?php

namespace GqAus\UserBundle\Services;

use Doctrine\ORM\EntityManager;

class MailService
{
    private $em;
    /**
     * @var Object
     */
    private $container;
    /**
     * @var Object
     */
    private $mailer;
    
    /**
     * Constructor
     */
    public function __construct($em, $container, $mailer)
    {
        $this->em = $em;
        $this->mailer = $mailer;
        $this->container = $container;
    }
    
    /**
     * function to send external email .
     *  @return string
     */
    public function sendExternalEmail($mailerInfo)
    {
        $from = $this->container->getParameter('fromEmailAddress');
        if (!empty($mailerInfo)) {
            $emailContent = \Swift_Message::newInstance()
                ->setSubject($mailerInfo['subject'])
                ->setFrom($from)
                ->setTo($mailerInfo['to'])
                ->setBody($mailerInfo['body'])
                ->setContentType("text/html");                
            $status = $this->mailer->send($emailContent);
        } 
        return $status;
    }
}