<?php

namespace GqAus\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Schooling
 */
class Schooling
{
    /**
     * @var string
     */
    private $highcompschlevel;
    
    /**
     * @var string
     */
    private $whichyear;

    /**
     * @var string
     */
    private $secschlevel;

    /**
     * @var string
     */
    private $id;

    /**
     * @var \GqAus\UserBundle\Entity\User
     */
    private $user;

    /**
     * Set highcompschlevel
     *
     * @param string $highcompschlevel
     * @return highcompschlevel
     */
    public function setHighCompSchLevel($highcompschlevel)
    {
        $this->highcompschlevel = $highcompschlevel;

        return $this;
    }

    /**
     * Get highcompschlevel
     *
     * @return string 
     */
    public function getHighCompSchLevel()
    {
        return $this->highcompschlevel;
    }
    
    /**
     * Set whichyear
     *
     * @param string $whichyear
     * @return whichyear
     */
    public function setWhichYear($whichyear)
    {
        $this->whichyear = $whichyear;

        return $this;
    }

    /**
     * Get whichYear
     *
     * @return string 
     */
    public function getWhichYear()
    {
        return $this->whichYear;
    }
    
    /**
     * Set secschlevel
     *
     * @param string $secschlevel
     * @return secschlevel
     */
    public function setSecSchoolLevel($secschlevel)
    {
        $this->secschlevel = $secschlevel;

        return $this;
    }

    /**
     * Get secschlevel
     *
     * @return string 
     */
    public function getSecSchoolLevel()
    {
        return $this->secschlevel;
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
     * Set user
     *
     * @param \GqAus\UserBundle\Entity\User $user
     * @return User
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
}
