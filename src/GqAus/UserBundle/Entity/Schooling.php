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
    private $highCompSchoolLevel;
    
    /**
     * @var string
     */
    private $whichYear;

    /**
     * @var string
     */
    private $secSchoolLevel;

    /**
     * @var string
     */
    private $id;

    /**
     * @var \GqAus\UserBundle\Entity\User
     */
    private $user;

    /**
     * Set highCompSchoolLevel
     *
     * @param string $highCompSchoolLevel
     * @return highCompSchoolLevel
     */
    public function setHighCompSchoolLevel($highCompSchoolLevel)
    {
        $this->highCompSchoolLevel = $highCompSchoolLevel;

        return $this;
    }

    /**
     * Get highCompSchoolLevel
     *
     * @return string 
     */
    public function getHighCompSchoolLevel()
    {
        return $this->highCompSchoolLevel;
    }
    
    /**
     * Set whichYear
     *
     * @param string $whichYear
     * @return whichYear
     */
    public function setWhichYear($whichYear)
    {
        $this->whichYear = $whichYear;

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
     * Set secSchoolLevel
     *
     * @param string $secSchoolLevel
     * @return secSchoolLevel
     */
    public function setSecSchoolLevel($secSchoolLevel)
    {
        $this->secSchoolLevel = $secSchoolLevel;

        return $this;
    }

    /**
     * Get secSchoolLevel
     *
     * @return string 
     */
    public function getSecSchoolLevel()
    {
        return $this->secSchoolLevel;
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
}
