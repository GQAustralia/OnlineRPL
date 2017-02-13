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
    private $buildingname;
    
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
     * Set buildingname
     *
     * @param string $buildingname
     * @return buildingname
     */
    public function setBuildingName($buildingname)
    {
        $this->buildingname = $buildingname;

        return $this;
    }

    /**
     * Get buildingname
     *
     * @return string 
     */
    public function getBuildingName()
    {
        return $this->buildingname;
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
    
    /**
    * @var string
    */
   public $pbuildingname;
    
    /**
     * Set pbuildingname
     *
     * @param string $pbuildingname
     * @return pbuildingname
     */
    public function setPostalBuildingName($pbuildingname)
    {
        $this->pbuildingname = $pbuildingname;

        return $this;
    }

    /**
     * Get pbuildingname
     *
     * @return string 
     */
    public function getPostalBuildingName()
    {
        return $this->pbuildingname;
    }
    
    /**
     * @var string
     */
    public $paddress;
    
    /**
     * Set paddress
     *
     * @param string $paddress
     * @return paddress
     */
    public function setPostalAddress($paddress)
    {
        $this->paddress = $paddress;

        return $this;
    }

    /**
     * Get paddress
     *
     * @return string 
     */
    public function getPostalAddress()
    {
        return $this->paddress;
    }
    
    /**
     * @var string
     */
    public $parea;
    
    /**
     * Set parea
     *
     * @param string $parea
     * @return parea
     */
    public function setPostalArea($parea)
    {
        $this->parea = $parea;

        return $this;
    }

    /**
     * Get parea
     *
     * @return string 
     */
    public function getPostalArea()
    {
        return $this->parea;
    }

    /**
     * @var string
     */
    public $pcity;
    
    /**
     * Set pcity
     *
     * @param string $pcity
     * @return pcity
     */
    public function setPostalCity($pcity)
    {
        $this->pcity = $pcity;

        return $this;
    }

    /**
     * Get pcity
     *
     * @return string 
     */
    public function getPostalCity()
    {
        return $this->pcity;
    }
    
    /**
     * @var string
     */
    public $pstate;
    
    /**
     * Set pstate
     *
     * @param string $pstate
     * @return pstate
     */
    public function setPostalState($pstate)
    {
        $this->pstate = $pstate;

        return $this;
    }

    /**
     * Get pstate
     *
     * @return string 
     */
    public function getPostalState()
    {
        return $this->pstate;
    }
    
    /**
     * @var string
     */
    public $ppincode;
    
    /**
     * Set ppincode
     *
     * @param string $ppincode
     * @return ppincode
     */
    public function setPostalPincode($ppincode)
    {
        $this->ppincode = $ppincode;

        return $this;
    }

    /**
     * Get ppincode
     *
     * @return string 
     */
    public function getPostalPincode()
    {
        return $this->ppincode;
    }
    
    
    /**
     * @var string
     */
    public $psuburb;
    
    /**
     * Set psuburb
     *
     * @param string $psuburb
     * @return psuburb
     */
    public function setPostalSuburb($psuburb)
    {
        $this->psuburb = $psuburb;

        return $this;
    }

    /**
     * Get psuburb
     *
     * @return string 
     */
    public function getPostalSuburb()
    {
        return $this->psuburb;
    }
    
    /**
     * @var string
     */
    public $pcountry;
    
    /**
     * Set pcountry
     *
     * @param string $pcountry
     * @return pcountry
     */
    public function setPostalCountry($pcountry)
    {
        $this->pcountry = $pcountry;
        return $this;
    }

    /**
     * Get pcountry
     *
     * @return string 
     */
    public function getPostalCountry()
    {
        return $this->pcountry;
    }
}
