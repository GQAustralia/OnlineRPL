<?php

namespace GqAus\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Assessor
 */
class Assessor extends User
{ 
    /**
     * Role type for Assessor
     * 
     * @var Integer
     */
    const ROLE = 3;
    
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
