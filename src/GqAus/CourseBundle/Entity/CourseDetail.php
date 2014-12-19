<?php

namespace GqAus\CourseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CourseDetail
 */
class CourseDetail
{
    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $pathway;

    /**
     * @var string
     */
    private $liceincing;

    /**
     * @var string
     */
    private $entry;

    /**
     * @var string
     */
    private $employability;

    /**
     * @var string
     */
    private $packaging;

    /**
     * @var string
     */
    private $awardedBy;

    /**
     * @var string
     */
    private $updated;

    /**
     * @var string
     */
    private $linked;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \GqAus\CourseBundle\Entity\Course
     */
    private $course;


    /**
     * Set description
     *
     * @param string $description
     * @return CourseDetail
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set pathway
     *
     * @param string $pathway
     * @return CourseDetail
     */
    public function setPathway($pathway)
    {
        $this->pathway = $pathway;

        return $this;
    }

    /**
     * Get pathway
     *
     * @return string 
     */
    public function getPathway()
    {
        return $this->pathway;
    }

    /**
     * Set liceincing
     *
     * @param string $liceincing
     * @return CourseDetail
     */
    public function setLiceincing($liceincing)
    {
        $this->liceincing = $liceincing;

        return $this;
    }

    /**
     * Get liceincing
     *
     * @return string 
     */
    public function getLiceincing()
    {
        return $this->liceincing;
    }

    /**
     * Set entry
     *
     * @param string $entry
     * @return CourseDetail
     */
    public function setEntry($entry)
    {
        $this->entry = $entry;

        return $this;
    }

    /**
     * Get entry
     *
     * @return string 
     */
    public function getEntry()
    {
        return $this->entry;
    }

    /**
     * Set employability
     *
     * @param string $employability
     * @return CourseDetail
     */
    public function setEmployability($employability)
    {
        $this->employability = $employability;

        return $this;
    }

    /**
     * Get employability
     *
     * @return string 
     */
    public function getEmployability()
    {
        return $this->employability;
    }

    /**
     * Set packaging
     *
     * @param string $packaging
     * @return CourseDetail
     */
    public function setPackaging($packaging)
    {
        $this->packaging = $packaging;

        return $this;
    }

    /**
     * Get packaging
     *
     * @return string 
     */
    public function getPackaging()
    {
        return $this->packaging;
    }

    /**
     * Set awardedBy
     *
     * @param string $awardedBy
     * @return CourseDetail
     */
    public function setAwardedBy($awardedBy)
    {
        $this->awardedBy = $awardedBy;

        return $this;
    }

    /**
     * Get awardedBy
     *
     * @return string 
     */
    public function getAwardedBy()
    {
        return $this->awardedBy;
    }

    /**
     * Set updated
     *
     * @param string $updated
     * @return CourseDetail
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return string 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set linked
     *
     * @param string $linked
     * @return CourseDetail
     */
    public function setLinked($linked)
    {
        $this->linked = $linked;

        return $this;
    }

    /**
     * Get linked
     *
     * @return string 
     */
    public function getLinked()
    {
        return $this->linked;
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
     * @return CourseDetail
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
