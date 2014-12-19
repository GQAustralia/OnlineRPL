<?php

namespace GqAus\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Role
 */
class Role
{
    /**
     * Constant for facilitator
     */
    Const FACILITATOR = 'facilitator';
    
    /**
     * Constant for applicant
     */
    Const APPLICANT = 'applicant';
    
    /**
     * Constant for assessor
     */
    Const ASSESSOR = 'assessor';

    /**
     * @var string
     */
    private $type;

    /**
     * @var integer
     */

    /**
     * Set type
     *
     * @param string $type
     * @return Role
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
