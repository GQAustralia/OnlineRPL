<?php

namespace GqAus\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserCourses
 */
class UserCourses
{
    /**
     * @var string
     */
    private $courseCode;

    /**
     * @var string
     */
    private $courseName;

    /**
     * @var integer
     */
    private $courseStatus;

    /**
     * @var string
     */
    private $id;

    /**
     * @var \GqAus\UserBundle\Entity\User
     */
    private $user;


    /**
     * Set courseCode
     *
     * @param string $courseCode
     * @return UserCourses
     */
    public function setCourseCode($courseCode)
    {
        $this->courseCode = $courseCode;

        return $this;
    }

    /**
     * Get courseCode
     *
     * @return string 
     */
    public function getCourseCode()
    {
        return $this->courseCode;
    }

    /**
     * Set courseName
     *
     * @param string $courseName
     * @return UserCourses
     */
    public function setCourseName($courseName)
    {
        $this->courseName = $courseName;

        return $this;
    }

    /**
     * Get courseName
     *
     * @return string 
     */
    public function getCourseName()
    {
        return $this->courseName;
    }

    /**
     * Set courseStatus
     *
     * @param integer $courseStatus
     * @return UserCourses
     */
    public function setCourseStatus($courseStatus)
    {
        $this->courseStatus = $courseStatus;

        return $this;
    }

    /**
     * Get courseStatus
     *
     * @return integer 
     */
    public function getCourseStatus()
    {
        return $this->courseStatus;
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
     * @return UserCourses
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
    private $createdOn;


    /**
     * Set createdOn
     *
     * @param string $createdOn
     * @return UserCourses
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
     * @var integer
     */
    private $facilitator;

    /**
     * @var integer
     */
    private $assessor;

    /**
     * @var integer
     */
    private $rto;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $status;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->status = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set facilitator
     *
     * @param integer $facilitator
     * @return UserCourses
     */
    public function setFacilitator($facilitator)
    {
        $this->facilitator = $facilitator;

        return $this;
    }

    /**
     * Get facilitator
     *
     * @return integer 
     */
    public function getFacilitator()
    {
        return $this->facilitator;
    }

    /**
     * Set assessor
     *
     * @param integer $assessor
     * @return UserCourses
     */
    public function setAssessor($assessor)
    {
        $this->assessor = $assessor;

        return $this;
    }

    /**
     * Get assessor
     *
     * @return integer 
     */
    public function getAssessor()
    {
        return $this->assessor;
    }

    /**
     * Set rto
     *
     * @param integer $rto
     * @return UserCourses
     */
    public function setRto($rto)
    {
        $this->rto = $rto;

        return $this;
    }

    /**
     * Get rto
     *
     * @return integer 
     */
    public function getRto()
    {
        return $this->rto;
    }

    /**
     * Add status
     *
     * @param \GqAus\UserBundle\Entity\CourseStatus $status
     * @return UserCourses
     */
    public function addStatus(\GqAus\UserBundle\Entity\CourseStatus $status)
    {
        $this->status[] = $status;

        return $this;
    }

    /**
     * Remove status
     *
     * @param \GqAus\UserBundle\Entity\CourseStatus $status
     */
    public function removeStatus(\GqAus\UserBundle\Entity\CourseStatus $status)
    {
        $this->status->removeElement($status);
    }

    /**
     * Get status
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStatus()
    {
        return $this->status;
    }
}
