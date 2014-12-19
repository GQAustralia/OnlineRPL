<?php

namespace GqAus\CourseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CourseLevelPriority
 */
class CourseLevelPriority
{
    /**
     * @var integer
     */
    private $priority;

    /**
     * @var string
     */
    private $courseLevel;


    /**
     * Set priority
     *
     * @param integer $priority
     * @return CourseLevelPriority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get priority
     *
     * @return integer 
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Get courseLevel
     *
     * @return string 
     */
    public function getCourseLevel()
    {
        return $this->courseLevel;
    }
}
