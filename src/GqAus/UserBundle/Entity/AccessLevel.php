<?php

namespace GqAus\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AccessLevel
 */
class AccessLevel
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $privlage;

    /**
     * @var string
     */
    private $spCode;

    /**
     * @var string
     */
    private $passSetup;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set username
     *
     * @param string $username
     * @return AccessLevel
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set privlage
     *
     * @param string $privlage
     * @return AccessLevel
     */
    public function setPrivlage($privlage)
    {
        $this->privlage = $privlage;

        return $this;
    }

    /**
     * Get privlage
     *
     * @return string 
     */
    public function getPrivlage()
    {
        return $this->privlage;
    }

    /**
     * Set spCode
     *
     * @param string $spCode
     * @return AccessLevel
     */
    public function setSpCode($spCode)
    {
        $this->spCode = $spCode;

        return $this;
    }

    /**
     * Get spCode
     *
     * @return string 
     */
    public function getSpCode()
    {
        return $this->spCode;
    }

    /**
     * Set passSetup
     *
     * @param string $passSetup
     * @return AccessLevel
     */
    public function setPassSetup($passSetup)
    {
        $this->passSetup = $passSetup;

        return $this;
    }

    /**
     * Get passSetup
     *
     * @return string 
     */
    public function getPassSetup()
    {
        return $this->passSetup;
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
