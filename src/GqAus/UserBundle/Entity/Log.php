<?php
namespace GqAus\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Applicant
 */
class Log 
{
     /**
     * @var string
     */
    private $id;
//    
//    /**
//     * @var logUserId
//     */
//    private $logUserId;
    
    /**
     * @var logAction
     */
    private $logAction;
    
    /**
     * @var logpagename
     */
    private $logpagename;
    
    /**
     * @var logDateTime
     */
    private $logDateTime;
    
    /**
     * @var logMessage
     */
    private $logMessage;
    
    /**
     * @var logRole
     */
    private $logRole;  
    
    /**
     * @var \GqAus\UserBundle\Entity\User
     */
    private $user;
    
    
    
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
     * Set user
     *
     * @param \GqAus\UserBundle\Entity\User $user
     * @return UserCourses
     */
    public function setUser(\GqAus\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \GqAus\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
    
    
      /**
     * Set phone
     *
     * @param string logAction
     * @return logAction
     */
    public function setlogAction($logAction)
    {
        $this->logAction = $logAction;
        return $this;
    }

    /**
     * Get logAction
     *
     * @return string 
     */
    public function getlogAction()
    {
        return $this->logAction;
    }
    
    
    
    
      /**
     * Set phone
     *
     * @param string logpagename
     * @return logpagename
     */
    public function setlogpagename($logpagename)
    {
        $this->logpagename = $logpagename;
        return $this;
    }

    /**
     * Get logpagename
     *
     * @return string 
     */
    public function getlogpagename()
    {
        return $this->logpagename;
    }
    
    
      /**
     * Set logDateTime
     *
     * @param string logDateTime
     * @return logDateTime
     */
    public function setlogDateTime($logDateTime)
    {
        $this->logDateTime = $logDateTime;
        return $this;
    }

    /**
     * Get logDateTime
     *
     * @return string 
     */
    public function getlogDateTime()
    {
        return $this->logDateTime;
    }
    
    
      /**
     * Set logMessage
     *
     * @param string logMessage
     * @return logMessage
     */
    public function setlogMessage($logMessage)
    {
        $this->logMessage = $logMessage;
        return $this;
    }

    /**
     * Get logMessage
     *
     * @return string 
     */
    public function getlogMessage()
    {
        return $this->logMessage;
    }
    
     /**
     * Set logMessage
     *
     * @param string logRole
     * @return logMessage
     */
    public function setlogRole($logRole)
    {
        $this->logRole = $logRole;
        return $this;
    }

    /**
     * Get logMessage
     *
     * @return string 
     */
    public function getlogRole()
    {
        return $this->logRole;
    }
    
//    /**
//     * Set logUserId
//     *
//     * @param string logUserId
//     * @return logUserId
//     */
//    public function setlogUserId($logUserId)
//    {
//        $this->logUserId = $logUserId;
//        return $this;
//    }
//
//    /**
//     * Get logUserId
//     *
//     * @return string 
//     */
//    public function getlogUserId()
//    {
//        return $this->logUserId;
//    }

}