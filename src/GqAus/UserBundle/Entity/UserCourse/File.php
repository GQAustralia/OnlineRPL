<?php

namespace GqAus\UserBundle\Entity\UserCourse;

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
     * 
     * @return \GqAus\UserBundle\Entity\UserCourses
     */
    public function getCourse()
    {
        return $this->course;
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
