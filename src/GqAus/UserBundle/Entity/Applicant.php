<?php

namespace GqAus\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Applicant
 */
class Applicant extends User
{

    /**
     * Role type for Applicant
     * 
     * @var Integer
     */
    const ROLE = 1;

    /**
     * @var string
     */
    const ROLE_NAME = 'ROLE_APPLICANT';

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
