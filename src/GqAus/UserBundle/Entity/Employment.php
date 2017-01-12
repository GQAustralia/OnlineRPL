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
    private $curempstatus;
    
    /**
     * @var string
     */
    private $studyreason;
    

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
     * Set curempstatus
     *
     * @param string $curempstatus
     * @return $curempstatus
     */
    public function setCurEmpStatus($curempstatus)
    {
        $this->$curempstatus = $curempstatus;

        return $this;
    }

    /**
     * Get curempstatus
     *
     * @return string 
     */
    public function getCurEmpStatus()
    {
        return $this->curempstatus;
    }
    
   /**
     * Set studyreason
     *
     * @param string $studyreason
     * @return string
     */
    public function setStudyReason($studyreason)
    {
        $this->studyreason = $studyreason;

        return $this;
    }

    /**
     * Get studyreason
     *
     * @return string 
     */
    public function getStudyReason()
    {
        return $this->studyreason;
    }
}
