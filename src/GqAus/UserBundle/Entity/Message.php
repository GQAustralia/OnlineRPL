<?php

namespace GqAus\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 */
class Message
{
    
    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $message;

    /**
     * @var string
     */
    private $created;

    /**
     * @var string
     */
    private $read;

    /**
     * @var string
     */
    private $toStatus;

    /**
     * @var string
     */
    private $fromStatus;

    /**
     * @var string
     */
    private $reply;

    /**
     * @var string
     */
    private $id;

    /**
     * @var \GqAus\UserBundle\Entity\User
     */
    private $inbox;

    /**
     * @var \GqAus\UserBundle\Entity\User
     */
    private $sent;

    /**
     * @var string
     */
    private $unitID;
    /**
     * @var string
     */
    private $replymid;
    
    /**
     * @var string
     */
    private $msgbody;
    
    /**
     * Set subject
     *
     * @param string $subject
     * @return Message
     */
   
            
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string 
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return Message
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set created
     *
     * @param string $created
     * @return Message
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return string 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set read
     *
     * @param string $read
     * @return Message
     */
    public function setRead($read)
    {
        $this->read = $read;

        return $this;
    }

    /**
     * Get read
     *
     * @return string 
     */
    public function getRead()
    {
        return $this->read;
    }

    /**
     * Set toStatus
     *
     * @param string $toStatus
     * @return Message
     */
    public function setToStatus($toStatus)
    {
        $this->toStatus = $toStatus;

        return $this;
    }

    /**
     * Get toStatus
     *
     * @return string 
     */
    public function getToStatus()
    {
        return $this->toStatus;
    }

    /**
     * Set fromStatus
     *
     * @param string $fromStatus
     * @return Message
     */
    public function setFromStatus($fromStatus)
    {
        $this->fromStatus = $fromStatus;

        return $this;
    }

    /**
     * Get fromStatus
     *
     * @return string 
     */
    public function getFromStatus()
    {
        return $this->fromStatus;
    }

    /**
     * Set reply
     *
     * @param string $reply
     * @return Message
     */
    public function setReply($reply)
    {
        $this->reply = $reply;

        return $this;
    }

    /**
     * Get reply
     *
     * @return string 
     */
    public function getReply()
    {
        return $this->reply;
    }

    /**
     * Get id
     *
     * @return string 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set inbox
     *
     * @param \GqAus\UserBundle\Entity\User $inbox
     * @return Message
     */
    public function setInbox(\GqAus\UserBundle\Entity\User $inbox = null)
    {
        $this->inbox = $inbox;

        return $this;
    }

    /**
     * Get inbox
     *
     * @return \GqAus\UserBundle\Entity\User 
     */
    public function getInbox()
    {
        return $this->inbox;
    }

    /**
     * Set sent
     *
     * @param \GqAus\UserBundle\Entity\User $sent
     * @return Message
     */
    public function setSent(\GqAus\UserBundle\Entity\User $sent = null)
    {
        $this->sent = $sent;

        return $this;
    }

    /**
     * Get sent
     *
     * @return \GqAus\UserBundle\Entity\User 
     */
    public function getSent()
    {
        return $this->sent;
    }

    /**
     * Get unitID
     *
     * @return integer 
     */
    public function getunitID()
    {
        return $this->unitID;
    }

    /**
     * Set unitId
     *
     * @param integer $unitID
     * @return Message
     */
    public function setunitID($unitID)
    {
        $this->unitID = $unitID;

        return $this;
    }
/**
     * Get ReplyMid
     *
     * @return integer 
     */
    public function getreplymid()
    {
        return $this->replymid;
    }

    /**
     * Set unitId
     *
     * @param integer $replymid
     * @return Message
     */
    public function setreplymid($replymid)
    {
        $this->replymid = $replymid;

        return $this;
    }

}
