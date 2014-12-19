<?php

namespace GqAus\CourseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PackagingRule
 */
class PackagingRule
{
    /**
     * @var integer
     */
    private $coreNeeded;

    /**
     * @var integer
     */
    private $electiveNeeded;

    /**
     * @var integer
     */
    private $totalNeeded;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \GqAus\CourseBundle\Entity\Course
     */
    private $course;


    /**
     * Set coreNeeded
     *
     * @param integer $coreNeeded
     * @return PackagingRule
     */
    public function setCoreNeeded($coreNeeded)
    {
        $this->coreNeeded = $coreNeeded;

        return $this;
    }

    /**
     * Get coreNeeded
     *
     * @return integer 
     */
    public function getCoreNeeded()
    {
        return $this->coreNeeded;
    }

    /**
     * Set electiveNeeded
     *
     * @param integer $electiveNeeded
     * @return PackagingRule
     */
    public function setElectiveNeeded($electiveNeeded)
    {
        $this->electiveNeeded = $electiveNeeded;

        return $this;
    }

    /**
     * Get electiveNeeded
     *
     * @return integer 
     */
    public function getElectiveNeeded()
    {
        return $this->electiveNeeded;
    }

    /**
     * Set totalNeeded
     *
     * @param integer $totalNeeded
     * @return PackagingRule
     */
    public function setTotalNeeded($totalNeeded)
    {
        $this->totalNeeded = $totalNeeded;

        return $this;
    }

    /**
     * Get totalNeeded
     *
     * @return integer 
     */
    public function getTotalNeeded()
    {
        return $this->totalNeeded;
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

    /**
     * Set course
     *
     * @param \GqAus\CourseBundle\Entity\Course $course
     * @return PackagingRule
     */
    public function setCourse(\GqAus\CourseBundle\Entity\Course $course = null)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * Get course
     *
     * @return \GqAus\CourseBundle\Entity\Course 
     */
    public function getCourse()
    {
        return $this->course;
    }
}
