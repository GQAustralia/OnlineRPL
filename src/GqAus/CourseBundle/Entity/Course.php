<?php

namespace GqAus\CourseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Course
 */
class Course
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $trainingPackage;

    /**
     * @var integer
     */
    private $sellingPrice;

    /**
     * @var integer
     */
    private $intPrice;

    /**
     * @var integer
     */
    private $bestMarketPrice;

    /**
     * @var string
     */
    private $userComments;

    /**
     * @var string
     */
    private $targetMarket;

    /**
     * @var integer
     */
    private $timesCompleted;

    /**
     * @var string
     */
    private $active;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $online;

    /**
     * @var string
     */
    private $trades;

    /**
     * @var string
     */
    private $code;

    /**
     * @var \GqAus\CourseBundle\Entity\CourseDetail
     */
    private $details;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $providers;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $units;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $assessors;

    /**
     * @var \GqAus\CourseBundle\Entity\CourseLevelPriority
     */
    private $level;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->providers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->units = new \Doctrine\Common\Collections\ArrayCollection();
        $this->assessors = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Course
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
     * Set trainingPackage
     *
     * @param string $trainingPackage
     * @return Course
     */
    public function setTrainingPackage($trainingPackage)
    {
        $this->trainingPackage = $trainingPackage;

        return $this;
    }

    /**
     * Get trainingPackage
     *
     * @return string 
     */
    public function getTrainingPackage()
    {
        return $this->trainingPackage;
    }

    /**
     * Set sellingPrice
     *
     * @param integer $sellingPrice
     * @return Course
     */
    public function setSellingPrice($sellingPrice)
    {
        $this->sellingPrice = $sellingPrice;

        return $this;
    }

    /**
     * Get sellingPrice
     *
     * @return integer 
     */
    public function getSellingPrice()
    {
        return $this->sellingPrice;
    }

    /**
     * Set intPrice
     *
     * @param integer $intPrice
     * @return Course
     */
    public function setIntPrice($intPrice)
    {
        $this->intPrice = $intPrice;

        return $this;
    }

    /**
     * Get intPrice
     *
     * @return integer 
     */
    public function getIntPrice()
    {
        return $this->intPrice;
    }

    /**
     * Set bestMarketPrice
     *
     * @param integer $bestMarketPrice
     * @return Course
     */
    public function setBestMarketPrice($bestMarketPrice)
    {
        $this->bestMarketPrice = $bestMarketPrice;

        return $this;
    }

    /**
     * Get bestMarketPrice
     *
     * @return integer 
     */
    public function getBestMarketPrice()
    {
        return $this->bestMarketPrice;
    }

    /**
     * Set userComments
     *
     * @param string $userComments
     * @return Course
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
     * Set targetMarket
     *
     * @param string $targetMarket
     * @return Course
     */
    public function setTargetMarket($targetMarket)
    {
        $this->targetMarket = $targetMarket;

        return $this;
    }

    /**
     * Get targetMarket
     *
     * @return string 
     */
    public function getTargetMarket()
    {
        return $this->targetMarket;
    }

    /**
     * Set timesCompleted
     *
     * @param integer $timesCompleted
     * @return Course
     */
    public function setTimesCompleted($timesCompleted)
    {
        $this->timesCompleted = $timesCompleted;

        return $this;
    }

    /**
     * Get timesCompleted
     *
     * @return integer 
     */
    public function getTimesCompleted()
    {
        return $this->timesCompleted;
    }

    /**
     * Set active
     *
     * @param string $active
     * @return Course
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return string 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Course
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set online
     *
     * @param string $online
     * @return Course
     */
    public function setOnline($online)
    {
        $this->online = $online;

        return $this;
    }

    /**
     * Get online
     *
     * @return string 
     */
    public function getOnline()
    {
        return $this->online;
    }

    /**
     * Set trades
     *
     * @param string $trades
     * @return Course
     */
    public function setTrades($trades)
    {
        $this->trades = $trades;

        return $this;
    }

    /**
     * Get trades
     *
     * @return string 
     */
    public function getTrades()
    {
        return $this->trades;
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
     * Set details
     *
     * @param \GqAus\CourseBundle\Entity\CourseDetail $details
     * @return Course
     */
    public function setDetails(\GqAus\CourseBundle\Entity\CourseDetail $details = null)
    {
        $this->details = $details;

        return $this;
    }

    /**
     * Get details
     *
     * @return \GqAus\CourseBundle\Entity\CourseDetail 
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Add providers
     *
     * @param \GqAus\RtoBundle\Entity\Provider $providers
     * @return Course
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

    /**
     * Add units
     *
     * @param \GqAus\CourseBundle\Entity\Uoc $units
     * @return Course
     */
    public function addUnit(\GqAus\CourseBundle\Entity\Uoc $units)
    {
        $this->units[] = $units;

        return $this;
    }

    /**
     * Remove units
     *
     * @param \GqAus\CourseBundle\Entity\Uoc $units
     */
    public function removeUnit(\GqAus\CourseBundle\Entity\Uoc $units)
    {
        $this->units->removeElement($units);
    }

    /**
     * Get units
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUnits()
    {
        return $this->units;
    }

    /**
     * Add assessors
     *
     * @param \GqAus\UserBundle\Entity\AssessorCourse $assessors
     * @return Course
     */
    public function addAssessor(\GqAus\UserBundle\Entity\AssessorCourse $assessors)
    {
        $this->assessors[] = $assessors;

        return $this;
    }

    /**
     * Remove assessors
     *
     * @param \GqAus\UserBundle\Entity\AssessorCourse $assessors
     */
    public function removeAssessor(\GqAus\UserBundle\Entity\AssessorCourse $assessors)
    {
        $this->assessors->removeElement($assessors);
    }

    /**
     * Get assessors
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAssessors()
    {
        return $this->assessors;
    }

    /**
     * Set level
     *
     * @param \GqAus\CourseBundle\Entity\CourseLevelPriority $level
     * @return Course
     */
    public function setLevel(\GqAus\CourseBundle\Entity\CourseLevelPriority $level = null)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return \GqAus\CourseBundle\Entity\CourseLevelPriority 
     */
    public function getLevel()
    {
        return $this->level;
    }
}
