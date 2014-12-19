<?php

namespace GqAus\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evidence
 */
abstract class Evidence
{

    /**
     * @var integer
     */
    private $id;

     /**
     * Returns type of evidence.
     *
     * @return string
     */
    abstract public function getType();
}
