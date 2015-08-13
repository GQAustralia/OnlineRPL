<?php

namespace GqAus\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rto
 */
class Rto extends User
{

    /**
     * Role type for Rto
     * 
     * @var Integer
     */
    const ROLE = 4;

    /**
     * @var string
     */
    const ROLE_NAME = 'ROLE_RTO';

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
