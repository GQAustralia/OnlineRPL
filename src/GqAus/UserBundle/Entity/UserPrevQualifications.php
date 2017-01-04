<?php

namespace GqAus\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserPrevQualifications
 */
class UserPrevQualifications
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
     * @var \GqAus\UserBundle\Entity\PreviousQualifications
     */
    private $prevquals;

    

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
     * Set prevqualifications
     *
     * @param \GqAus\UserBundle\Entity\PreviousQualifications $prevquals
     * @return PreviousQualifications
     */
    public function setPrevQuals(\GqAus\UserBundle\Entity\PreviousQualifications $prevquals = null)
    {
        $this->prevquals = $prevquals;

        return $this;
    }

    /**
     * Get prevqualifications
     *
     * @return \GqAus\UserBundle\Entity\PreviousQualifications 
     */
    public function getPrevQuals()
    {
        return $this->prevquals;
    }
}
