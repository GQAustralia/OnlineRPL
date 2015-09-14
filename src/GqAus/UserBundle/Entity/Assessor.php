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
     * @var string
     */
    const ROLE_NAME = 'ROLE_ASSESSOR';

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
