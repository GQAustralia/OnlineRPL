<?php

namespace GqAus\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reminder
 */
class Reminder
{

    /**
     * @var string
     */
    private $reminderType;
	
    /**
     * @var integer
     */
    private $reminderTypeId;
	
    /**
     * @var string
     */
    private $date;

    /**
     * @var string
     */
    private $message;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var integer
     */
    private $completed;

    /**
     * @var string
     */
    private $id;

    /**
     * @var \GqAus\UserBundle\Entity\User
     */
    private $user;

    /**
     * @var \GqAus\UserBundle\Entity\User
     */
    private $createdby;

    /**
     * @var \GqAus\UserBundle\Entity\UserCourses
     */
    private $course;

    /**
     * Set date
     *
     * @param string $date
     * @return Reminder
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return string 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return Reminder
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Reminder
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set completed
     *
     * @param integer $completed
     * @return Reminder
     */
    public function setCompleted($completed)
    {
        $this->completed = $completed;

        return $this;
    }

    /**
     * Get completed
     *
     * @return integer 
     */
    public function getCompleted()
    {
        return $this->completed;
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
     * @return Reminder
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
     * Set course
     *
     * @param \GqAus\UserBundle\Entity\UserCourses $course
     * @return Reminder
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

    /**
     * @var string
     */
    private $completedDate;

    /**
     * Set completedDate
     *
     * @param string $completedDate
     * @return Reminder
     */
    public function setCompletedDate($completedDate)
    {
        $this->completedDate = $completedDate;

        return $this;
    }

    /**
     * Get completedDate
     *
     * @return string 
     */
    public function getCompletedDate()
    {
        return $this->completedDate;
    }

    /**
     * Set createdby
     *
     * @param \GqAus\UserBundle\Entity\User $createdby
     * @return Reminder
     */
    public function setCreatedby(\GqAus\UserBundle\Entity\User $createdby = null)
    {
        $this->createdby = $createdby;

        return $this;
    }

    /**
     * Get createdby
     *
     * @return \GqAus\UserBundle\Entity\User 
     */
    public function getCreatedby()
    {
        return $this->createdby;
    }

    /**
     * Set reminderType
     *
     * @param $reminderType
     * @return Reminder
     */
    public function setReminderType($reminderType)
    {
        $this->reminderType = $reminderType;

        return $this;
    }

    /**
     * Get reminderType
     *
     * @return Reminder 
     */
    public function getReminderType()
    {
        return $this->reminderType;
    }
    /**
     * Set reminderTypeId
     *
     * @param $reminderTypeId
     * @return Reminder
     */
    public function setReminderTypeId($reminderTypeId)
    {
        $this->reminderTypeId = $reminderTypeId;

        return $this;
    }

    /**
     * Get reminderTypeId
     *
     * @return Reminder 
     */
    public function getReminderTypeId()
    {
        return $this->reminderTypeId;
	}
    	
}
