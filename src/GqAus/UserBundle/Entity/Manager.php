<?php

namespace GqAus\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Manager
 */
class Manager extends User
{   
    /**
     * Role type for Manager
     * 
     * @var Integer
     */
    const ROLE = 5;
    
    /**
     * @var string
     */
    const ROLE_NAME = 'ROLE_MANAGER';
    
    /**
     * Get type
     *
     * @return integer 
     */
    public function getRole()
    {
        return self::ROLE;
    }
    
    public function getRoleName()
    {
        return self::ROLE_NAME;
    }
    
}
