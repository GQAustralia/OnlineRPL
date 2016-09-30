<?php

namespace GqAus\UserBundle\Entity\UserCourse;
use Doctrine\ORM\Mapping as ORM;
/**
 * File
 */
class File 
{


    private $id;
    
    private $type;
    
    /**
     *
     * @var \GqAus\UserBundle\Entity\UserCourses
     */
    private $course;
    
    /**
     * @var string
     */
    private $path;

    /**
     * Returns type of evidence.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set path
     *
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }
    /**
     * Set type
     *
     * @param \GqAus\UserBundle\Entity\UserCourses $course
     * @return UserCourses
     */
    public function setCourse(\GqAus\UserBundle\Entity\UserCourses $course = null)
    {
        $this->course = $course;

        return $this;
    }
    /**
     * 
     * @return \GqAus\UserBundle\Entity\UserCourses
     */
    public function getCourse()
    {
        return $this->course;
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
     * Set type
     *
     * @param string $name
     * @return File
     */
    public function setType($type)
    {
        if ($type == 'EnrollmentForm' || $type == 'SignOffSheet') {
            $this->type = $type;
        } else {
            throw new \Exception ('Invalid File Type');
        }
    }

   

}
