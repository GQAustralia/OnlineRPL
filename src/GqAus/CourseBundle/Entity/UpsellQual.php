<?php

namespace GqAus\CourseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UpsellQual
 */
class UpsellQual
{
    /**
     * @var boolean
     */
    private $prio;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \GqAus\CourseBundle\Entity\Courses
     */
    private $qual;

    /**
     * @var \GqAus\CourseBundle\Entity\Course
     */
    private $related;


    /**
     * Set prio
     *
     * @param boolean $prio
     * @return UpsellQual
     */
    public function setPrio($prio)
    {
        $this->prio = $prio;

        return $this;
    }

    /**
     * Get prio
     *
     * @return boolean 
     */
    public function getPrio()
    {
        return $this->prio;
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
     * Set qual
     *
     * @param \GqAus\CourseBundle\Entity\Courses $qual
     * @return UpsellQual
     */
    public function setQual(\GqAus\CourseBundle\Entity\Courses $qual = null)
    {
        $this->qual = $qual;

        return $this;
    }

    /**
     * Get qual
     *
     * @return \GqAus\CourseBundle\Entity\Courses 
     */
    public function getQual()
    {
        return $this->qual;
    }

    /**
     * Set related
     *
     * @param \GqAus\CourseBundle\Entity\Course $related
     * @return UpsellQual
     */
    public function setRelated(\GqAus\CourseBundle\Entity\Course $related = null)
    {
        $this->related = $related;

        return $this;
    }

    /**
     * Get related
     *
     * @return \GqAus\CourseBundle\Entity\Course 
     */
    public function getRelated()
    {
        return $this->related;
    }
}
