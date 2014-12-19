<?php

namespace GqAus\RtoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rto
 */
class Rto
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $signed;

    /**
     * @var string
     */
    private $userComments;

    /**
     * @var integer
     */
    private $scorePrice;

    /**
     * @var integer
     */
    private $scoreTime;

    /**
     * @var integer
     */
    private $scoreEff;

    /**
     * @var integer
     */
    private $scoreAdmin;

    /**
     * @var integer
     */
    private $displayPrio;

    /**
     * @var string
     */
    private $hidden;

    /**
     * @var string
     */
    private $code;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $providers;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->providers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Rto
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set signed
     *
     * @param string $signed
     * @return Rto
     */
    public function setSigned($signed)
    {
        $this->signed = $signed;

        return $this;
    }

    /**
     * Get signed
     *
     * @return string 
     */
    public function getSigned()
    {
        return $this->signed;
    }

    /**
     * Set userComments
     *
     * @param string $userComments
     * @return Rto
     */
    public function setUserComments($userComments)
    {
        $this->userComments = $userComments;

        return $this;
    }

    /**
     * Get userComments
     *
     * @return string 
     */
    public function getUserComments()
    {
        return $this->userComments;
    }

    /**
     * Set scorePrice
     *
     * @param integer $scorePrice
     * @return Rto
     */
    public function setScorePrice($scorePrice)
    {
        $this->scorePrice = $scorePrice;

        return $this;
    }

    /**
     * Get scorePrice
     *
     * @return integer 
     */
    public function getScorePrice()
    {
        return $this->scorePrice;
    }

    /**
     * Set scoreTime
     *
     * @param integer $scoreTime
     * @return Rto
     */
    public function setScoreTime($scoreTime)
    {
        $this->scoreTime = $scoreTime;

        return $this;
    }

    /**
     * Get scoreTime
     *
     * @return integer 
     */
    public function getScoreTime()
    {
        return $this->scoreTime;
    }

    /**
     * Set scoreEff
     *
     * @param integer $scoreEff
     * @return Rto
     */
    public function setScoreEff($scoreEff)
    {
        $this->scoreEff = $scoreEff;

        return $this;
    }

    /**
     * Get scoreEff
     *
     * @return integer 
     */
    public function getScoreEff()
    {
        return $this->scoreEff;
    }

    /**
     * Set scoreAdmin
     *
     * @param integer $scoreAdmin
     * @return Rto
     */
    public function setScoreAdmin($scoreAdmin)
    {
        $this->scoreAdmin = $scoreAdmin;

        return $this;
    }

    /**
     * Get scoreAdmin
     *
     * @return integer 
     */
    public function getScoreAdmin()
    {
        return $this->scoreAdmin;
    }

    /**
     * Set displayPrio
     *
     * @param integer $displayPrio
     * @return Rto
     */
    public function setDisplayPrio($displayPrio)
    {
        $this->displayPrio = $displayPrio;

        return $this;
    }

    /**
     * Get displayPrio
     *
     * @return integer 
     */
    public function getDisplayPrio()
    {
        return $this->displayPrio;
    }

    /**
     * Set hidden
     *
     * @param string $hidden
     * @return Rto
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;

        return $this;
    }

    /**
     * Get hidden
     *
     * @return string 
     */
    public function getHidden()
    {
        return $this->hidden;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Add providers
     *
     * @param \GqAus\RtoBundle\Entity\Provider $providers
     * @return Rto
     */
    public function addProvider(\GqAus\RtoBundle\Entity\Provider $providers)
    {
        $this->providers[] = $providers;

        return $this;
    }

    /**
     * Remove providers
     *
     * @param \GqAus\RtoBundle\Entity\Provider $providers
     */
    public function removeProvider(\GqAus\RtoBundle\Entity\Provider $providers)
    {
        $this->providers->removeElement($providers);
    }

    /**
     * Get providers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProviders()
    {
        return $this->providers;
    }
}
