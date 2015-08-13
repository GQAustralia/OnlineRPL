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
    private $zohoId;

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

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $reminder;

    /**
     * Add reminder
     *
     * @param \GqAus\UserBundle\Entity\Reminder $reminder
     * @return UserCourses
     */
    public function addReminder(\GqAus\UserBundle\Entity\Reminder $reminder)
    {
        $this->reminder[] = $reminder;

        return $this;
    }

    /**
     * Remove reminder
     *
     * @param \GqAus\UserBundle\Entity\Reminder $reminder
     */
    public function removeReminder(\GqAus\UserBundle\Entity\Reminder $reminder)
    {
        $this->reminder->removeElement($reminder);
    }

    /**
     * Get reminder
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReminder()
    {
        return $this->reminder;
    }

    private $remainingTime;

    public function getRemainingTime()
    {
        $strtDate = $this->createdOn;
        $endDate = $this->targetDate;
        /*
          $startDateWeekCnt = round(floor( date('d',strtotime($strtDate)) / 7)) ;
          $endDateWeekCnt = round(ceil( date('d',strtotime($endDate)) / 7)) ;
          $datediff = strtotime(date('Y-m',strtotime($endDate))."-01") - strtotime(date('Y-m',strtotime($strtDate))."-01");
          $totalnoOfWeek = round(floor($datediff/(60*60*24)) / 7) + $endDateWeekCnt - $startDateWeekCnt ;
          return $totalnoOfWeek.' week(s)'; */

        $date1 = date_create($strtDate);
        $date2 = date_create($endDate);
        $diff = date_diff($date1, $date2);
        $getdiff = $diff->format("%a");
        return round($getdiff / 7) . " weeks";
    }

    /**
     * @var string
     */
    private $targetDate;

    /**
     * Set targetDate
     *
     * @param string $targetDate
     * @return UserCourses
     */
    public function setTargetDate($targetDate)
    {
        $this->targetDate = $targetDate;

        return $this;
    }

    /**
     * Get targetDate
     *
     * @return string 
     */
    public function getTargetDate()
    {
        return $this->targetDate;
    }

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
     * Set facilitatorstatus
     *
     * @param integer $facilitatorstatus
     * @return UserCourses
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
     * @return UserCourses
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
     * @return UserCourses
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
     * @var \DateTime
     */
    private $facilitatorDate;

    /**
     * @var \DateTime
     */
    private $assessorDate;

    /**
     * @var \DateTime
     */
    private $rtoDate;

    /**
     * Set facilitatorDate
     *
     * @param \DateTime $facilitatorDate
     * @return UserCourses
     */
    public function setFacilitatorDate($facilitatorDate)
    {
        $this->facilitatorDate = $facilitatorDate;

        return $this;
    }

    /**
     * Get facilitatorDate
     *
     * @return \DateTime 
     */
    public function getFacilitatorDate()
    {
        return $this->facilitatorDate;
    }

    /**
     * Set assessorDate
     *
     * @param \DateTime $assessorDate
     * @return UserCourses
     */
    public function setAssessorDate($assessorDate)
    {
        $this->assessorDate = $assessorDate;

        return $this;
    }

    /**
     * Get assessorDate
     *
     * @return \DateTime 
     */
    public function getAssessorDate()
    {
        return $this->assessorDate;
    }

    /**
     * Set rtoDate
     *
     * @param \DateTime $rtoDate
     * @return UserCourses
     */
    public function setRtoDate($rtoDate)
    {
        $this->rtoDate = $rtoDate;

        return $this;
    }

    /**
     * Get rtoDate
     *
     * @return \DateTime 
     */
    public function getRtoDate()
    {
        return $this->rtoDate;
    }

    /**
     * Set zohoId
     *
     * @param string $zohoId
     * @return UserCourses
     */
    public function setZohoId($zohoId)
    {
        $this->zohoId = $zohoId;

        return $this;
    }

    /**
     * Get zohoId
     *
     * @return string 
     */
    public function getZohoId()
    {
        return $this->zohoId;
    }

}
