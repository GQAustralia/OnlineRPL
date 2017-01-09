<?php

namespace GqAus\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserDisability
 */
class UserDisability
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
     * @var \GqAus\UserBundle\Entity\DisabilityElement
     */
    private $disability;

    

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
     * Set disability
     *
     * @param \GqAus\UserBundle\Entity\DisabilityElement $disability
     * @return DisabilityElement
     */
    public function setDisability(\GqAus\UserBundle\Entity\DisabilityElement $disability = null)
    {
        $this->disability = $disability;

        return $this;
    }

    /**
     * Get disability
     *
     * @return \GqAus\UserBundle\Entity\DisabilityElement 
     */
    public function getDisability()
    {
        return $this->disability;
    }
}
