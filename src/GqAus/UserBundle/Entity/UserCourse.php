<?php

namespace GqAus\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserCourse
 */
class UserCourse
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \GqAus\CourseBundle\Entity\Course
     */
    private $course;

    /**
     * @var \GqAus\UserBundle\Entity\User
     */
    private $user;


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
     * @return UserCourse
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

    /**
     * Set user
     *
     * @param \GqAus\UserBundle\Entity\User $user
     * @return UserCourse
     */
    public function setUser(\GqAus\UserBundle\Entity\user $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \GqAus\UserBundle\EntityUser 
     */
    public function getUser()
    {
        return $this->user;
    }
}
