<?php

namespace GqAus\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserAddress
 */
class UserAddress
{

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $area;

    /**
     * @var string
     */
    private $city;

    /**
     * @var string
     */
    private $state;

    /**
     * @var integer
     */
    private $pincode;

    /**
     * @var string
     */
    private $id;

    /**
     * @var \GqAus\UserBundle\Entity\User
     */
    private $user;

    /**
     * Set address
     *
     * @param string $address
     * @return UserAddress
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set area
     *
     * @param string $area
     * @return UserAddress
     */
    public function setArea($area)
    {
        $this->area = $area;

        return $this;
    }

    /**
     * Get area
     *
     * @return string 
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * Set city
     *
     * @param string $city
     * @return UserAddress
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return UserAddress
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set pincode
     *
     * @param string $pincode
     * @return UserAddress
     */
    public function setPincode($pincode)
    {
        $this->pincode = $pincode;

        return $this;
    }

    /**
     * Get pincode
     *
     * @return string 
     */
    public function getPincode()
    {
        return $this->pincode;
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

    /**
     * @var string
     */
    private $suburb;

    /**
     * Set suburb
     *
     * @param string $suburb
     * @return UserAddress
     */
    public function setSuburb($suburb)
    {
        $this->suburb = $suburb;

        return $this;
    }

    /**
     * Get suburb
     *
     * @return string 
     */
    public function getSuburb()
    {
        return $this->suburb;
    }

    /**
     * @var string
     */
    private $country;

    /**
     * Set country
     *
     * @param string $country
     * @return UserAddress
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }
    /**
     * @var string
     */
    private $postal;

    /**
     * Set postal
     *
     * @param string $postal
     * @return string
     */
    public function setPostal($postal)
    {
        $this->postal = $postal;

        return $this;
    }

    /**
     * Get postal
     *
     * @return string 
     */
    public function getPostal()
    {
       return $this->postal;
    }

}
