<?php

namespace GqAus\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CourseStatus
 */
class CourseStatus
{

    /**
     * @var string
     */
    private $unitCode;

    /**
     * @var string
     */
    private $createdOn;

    /**
     * @var integer
     */
    private $facilitatorstatus;

    /**
     * @var integer
     */
    private $assessorstatus;

    /**
     * @var integer
     */
    private $rtostatus;

    /**
     * @var string
     */
    private $id;

    /**
     * @var \GqAus\UserBundle\Entity\UserCourses
     */
    private $course;

    /**
     * Set unitCode
     *
     * @param string $unitCode
     * @return CourseStatus
     */
    public function setUnitCode($unitCode)
    {
        $this->unitCode = $unitCode;

        return $this;
    }

    /**
     * Get unitCode
     *
     * @return string 
     */
    public function getUnitCode()
    {
        return $this->unitCode;
    }

    /**
     * Set createdOn
     *
     * @param string $createdOn
     * @return CourseStatus
     */
    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;

        return $this;
    }

    /**
     * Get createdOn
     *
     * @return string 
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * Set facilitatorstatus
     *
     * @param integer $facilitatorstatus
     * @return CourseStatus
     */
    public function setFacilitatorstatus($facilitatorstatus)
    {
        $this->facilitatorstatus = $facilitatorstatus;

        return $this;
    }

    /**
     * Get facilitatorstatus
     *
     * @return integer 
     */
    public function getFacilitatorstatus()
    {
        return $this->facilitatorstatus;
    }

    /**
     * Set assessorstatus
     *
     * @param integer $assessorstatus
     * @return CourseStatus
     */
    public function setAssessorstatus($assessorstatus)
    {
        $this->assessorstatus = $assessorstatus;

        return $this;
    }

    /**
     * Get assessorstatus
     *
     * @return integer 
     */
    public function getAssessorstatus()
    {
        return $this->assessorstatus;
    }

    /**
     * Set rtostatus
     *
     * @param integer $rtostatus
     * @return CourseStatus
     */
    public function setRtostatus($rtostatus)
    {
        $this->rtostatus = $rtostatus;

        return $this;
    }

    /**
     * Get rtostatus
     *
     * @return integer 
     */
    public function getRtostatus()
    {
        return $this->rtostatus;
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
     * Set course
     *
     * @param \GqAus\UserBundle\Entity\UserCourses $course
     * @return CourseStatus
     */
    public function setCourse(\GqAus\UserBundle\Entity\UserCourses $course = null)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * Get course
     *
     * @return \GqAus\UserBundle\Entity\UserCourses 
     */
    public function getCourse()
    {
        return $this->course;
    }

}
