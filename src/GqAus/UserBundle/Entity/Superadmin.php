<?php

namespace GqAus\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Superadmin
 */
class Superadmin extends User
{

    /**
     * Role type for Superadmin
     * 
     * @var Integer
     */
    const ROLE = 6;

    /**
     * @var string
     */
    const ROLE_NAME = 'ROLE_SUPERADMIN';

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
