<?php

namespace GqAus\CourseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CourseMeta
 */
class CourseMeta
{
    /**
     * @var string
     */
    private $metaValue;

    /**
     * @var string
     */
    private $opening;

    /**
     * @var string
     */
    private $qbanner;

    /**
     * @var string
     */
    private $alt;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \GqAus\CourseBundle\Entity\Course
     */
    private $course;


    /**
     * Set metaValue
     *
     * @param string $metaValue
     * @return CourseMeta
     */
    public function setMetaValue($metaValue)
    {
        $this->metaValue = $metaValue;

        return $this;
    }

    /**
     * Get metaValue
     *
     * @return string 
     */
    public function getMetaValue()
    {
        return $this->metaValue;
    }

    /**
     * Set opening
     *
     * @param string $opening
     * @return CourseMeta
     */
    public function setOpening($opening)
    {
        $this->opening = $opening;

        return $this;
    }

    /**
     * Get opening
     *
     * @return string 
     */
    public function getOpening()
    {
        return $this->opening;
    }

    /**
     * Set qbanner
     *
     * @param string $qbanner
     * @return CourseMeta
     */
    public function setQbanner($qbanner)
    {
        $this->qbanner = $qbanner;

        return $this;
    }

    /**
     * Get qbanner
     *
     * @return string 
     */
    public function getQbanner()
    {
        return $this->qbanner;
    }

    /**
     * Set alt
     *
     * @param string $alt
     * @return CourseMeta
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string 
     */
    public function getAlt()
    {
        return $this->alt;
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
     * Set course
     *
     * @param \GqAus\CourseBundle\Entity\Course $course
     * @return CourseMeta
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
}
