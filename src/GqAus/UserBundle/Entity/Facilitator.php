<?php

namespace GqAus\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Facilitator
 */
class Facilitator extends User
{ 
    /**
     * Role type for Facilitator
     * 
     * @var Integer
     */
    const ROLE = 2;
    
    /**
     * Get type
     *
     * @return integer 
     */
    public function getRole()
    {
        return self::ROLE;
    }

}
