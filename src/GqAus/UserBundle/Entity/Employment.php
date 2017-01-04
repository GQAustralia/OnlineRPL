<?php

namespace GqAus\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Employment
 */
class Employment
{

    /**
     * @var string
     */
    private $id;

    /**
     * @var \GqAus\UserBundle\Entity\User
     */
    private $user;
    
    /**
     * @var string
     */
    private $curEmpStatus;
    
    /**
     * @var string
     */
    private $studyReason;
    

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
     * @return UserAddress
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
     * Set curEmpStatus
     *
     * @param string $curEmpStatus
     * @return curEmpStatus
     */
    public function setCurEmpStatus($curEmpStatus)
    {
        $this->curEmpStatus = $curEmpStatus;

        return $this;
    }

    /**
     * Get curEmpStatus
     *
     * @return string 
     */
    public function getCurEmpStatus()
    {
        return $this->curEmpStatus;
    }
    
   /**
     * Set studyReason
     *
     * @param string $studyReason
     * @return studyReason
     */
    public function setStudyReason($studyReason)
    {
        $this->studyReason = $studyReason;

        return $this;
    }

    /**
     * Get studyReason
     *
     * @return string 
     */
    public function getStudyReason()
    {
        return $this->studyReason;
    }
}
