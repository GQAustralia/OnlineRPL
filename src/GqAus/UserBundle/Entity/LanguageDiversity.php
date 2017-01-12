<?php

namespace GqAus\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LanguageDiversity
 */
class LanguageDiversity
{
    /**
     * @var string
     */
    private $borncountry;
    
    /**
     * @var string
     */
    private $speakotheng;

    /**
     * @var string
     */
    private $specotheng;

    /**
     * @var string
     */
    private $rateleveleng;

    /**
     * @var string
     */
    private $relatedorigin;

    /**
     * @var integer
     */
    private $disability;

    /**
     * @var string
     */
    private $id;

    /**
     * @var \GqAus\UserBundle\Entity\User
     */
    private $user;

    /**
     * Set borncountry
     *
     * @param string $borncountry
     * @return borncountry
     */
    public function setBornCountry($borncountry)
    {
        $this->borncountry = $borncountry;

        return $this;
    }

    /**
     * Get borncountry
     *
     * @return string 
     */
    public function getBornCountry()
    {
        return $this->borncountry;
    }
    
    /**
     * Set speakotheng
     *
     * @param string $speakotheng
     * @return speakotheng
     */
    public function setSpeakothEng($speakotheng)
    {
        $this->speakotheng = $speakotheng;

        return $this;
    }

    /**
     * Get speakotheng
     *
     * @return string 
     */
    public function getSpeakothEng()
    {
        return $this->speakotheng;
    }
    
    /**
     * Set specotheng
     *
     * @param string $specotheng
     * @return specotheng
     */
    public function setSpecothEng($specotheng)
    {
        $this->specotheng = $specotheng;

        return $this;
    }

    /**
     * Get specifyOtherThanEnglish
     *
     * @return string 
     */
    public function getSpecothEng()
    {
        return $this->specotheng;
    }

    /**
     * Set rateleveleng
     *
     * @param string $rateleveleng
     * @return rateleveleng
     */
    public function setRateLevelEng($rateleveleng)
    {
        $this->rateleveleng = $rateleveleng;

        return $this;
    }

    /**
     * Get rateleveleng
     *
     * @return string 
     */
    public function getRateLevelEng()
    {
        return $this->rateleveleng;
    }

    /**
     * Set relatedorigin
     *
     * @param string $relatedorigin
     * @return relatedorigin
     */
    public function setRelatedOrigin($relatedorigin)
    {
        $this->relatedorigin = $relatedorigin;

        return $this;
    }

    /**
     * Get relatedorigin
     *
     * @return string 
     */
    public function getRelatedOrigin()
    {
        return $this->relatedorigin;
    }

    /**
     * Set disability
     *
     * @param string $disability
     * @return disability
     */
    public function setDisability($disability)
    {
        $this->disability = $disability;

        return $this;
    }

    /**
     * Get disability
     *
     * @return string 
     */
    public function getDisability()
    {
        return $this->disability;
    }

    /**
     * Get id
     *
     * @return string 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user
     *
     * @param \GqAus\UserBundle\Entity\User $user
     * @return User
     */
    public function setUser(\GqAus\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \GqAus\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
