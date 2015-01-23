<?php

namespace GqAus\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserCourseUnits
 */
class UserCourseUnits
{
    /**
     * @var string
     */
    private $unitId;

    /**
     * @var string
     */
    private $courseCode;

    /**
     * @var string
     */
    private $createdOn;

    /**
     * @var integer
     */
    private $status;

    /**
     * @var string
     */
    private $id;

    /**
     * @var \GqAus\UserBundle\Entity\User
     */
    private $user;


    /**
     * Set unitId
     *
     * @param string $unitId
     * @return UserCourseUnits
     */
    public function setUnitId($unitId)
    {
        $this->unitId = $unitId;

        return $this;
    }

    /**
     * Get unitId
     *
     * @return string 
     */
    public function getUnitId()
    {
        return $this->unitId;
    }

    /**
     * Set courseCode
     *
     * @param string $courseCode
     * @return UserCourseUnits
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
     * Set createdOn
     *
     * @param string $createdOn
     * @return UserCourseUnits
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
     * Set status
     *
     * @param integer $status
     * @return UserCourseUnits
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
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
     * @return UserCourseUnits
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
     * @var integer
     */
    private $type;

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
     * Set type
     *
     * @param integer $type
     * @return UserCourseUnits
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set facilitatorstatus
     *
     * @param integer $facilitatorstatus
     * @return UserCourseUnits
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
     * @return UserCourseUnits
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
     * @return UserCourseUnits
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
}
