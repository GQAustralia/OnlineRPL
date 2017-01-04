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
    private $bornCountry;
    
    /**
     * @var string
     */
    private $speakOtherThanEnglish;

    /**
     * @var string
     */
    private $specifyOtherThanEnglish;

    /**
     * @var string
     */
    private $rateLevelEng;

    /**
     * @var string
     */
    private $relatedOrigin;

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
     * Set bornCountry
     *
     * @param string $bornCountry
     * @return UserAddress
     */
    public function setBornCountry($bornCountry)
    {
        $this->bornCountry = $bornCountry;

        return $this;
    }

    /**
     * Get borncountry
     *
     * @return string 
     */
    public function getBornCountry()
    {
        return $this->bornCountry;
    }
    
    /**
     * Set speakOtherThanEnglish
     *
     * @param string $speakOtherThanEnglish
     * @return speakOtherThanEnglish
     */
    public function setSpeakOtherThanEng($speakOtherThanEnglish)
    {
        $this->speakOtherThanEnglish = $speakOtherThanEnglish;

        return $this;
    }

    /**
     * Get speakotherthaneng
     *
     * @return string 
     */
    public function getSpeakOtherThanEng()
    {
        return $this->speakOtherThanEnglish;
    }
    
    /**
     * Set specifyOtherThanEnglish
     *
     * @param string $specifyOtherThanEnglish
     * @return specifyOtherThanEnglish
     */
    public function setSpecifyOtherThanEng($specifyOtherThanEnglish)
    {
        $this->specifyOtherThanEnglish = $specifyOtherThanEnglish;

        return $this;
    }

    /**
     * Get specifyOtherThanEnglish
     *
     * @return string 
     */
    public function getSpecifyOtherThanEng()
    {
        return $this->specifyOtherThanEnglish;
    }

    /**
     * Set rateLevelEng
     *
     * @param string $rateLevelEng
     * @return rateLevelEng
     */
    public function setRateLevelEng($rateLevelEng)
    {
        $this->rateLevelEng = $rateLevelEng;

        return $this;
    }

    /**
     * Get rateleveleng
     *
     * @return string 
     */
    public function getRateLevelEng()
    {
        return $this->rateLevelEng;
    }

    /**
     * Set relatedorigin
     *
     * @param string $relatedorigin
     * @return relatedorigin
     */
    public function setRelatedOrigin($relatedOrigin)
    {
        $this->relatedOrigin = $relatedOrigin;

        return $this;
    }

    /**
     * Get relatedorigin
     *
     * @return string 
     */
    public function getRelatedOrigin()
    {
        return $this->relatedOrigin;
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
     * @return UserAddress
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
