<?php

namespace GqAus\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evidence
 */
abstract class Evidence
{

    /**
     * @var integer
     */
    private $id;

     /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function setId($id)
    {
    					$this->id = $id;
    					return $this;
    }
    
     /**
     * Returns type of evidence.
     *
     * @return string
     */
    abstract public function getType();

    /**
     * @var string
     */
    private $unit;

    /**
     * @var \GqAus\UserBundle\Entity\User
     */
    private $user;

    /**
     * Set unit
     *
     * @param string $unit
     * @return Evidence
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get unit
     *
     * @return string 
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Set user
     *
     * @param \GqAus\UserBundle\Entity\User $user
     * @return Evidence
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
    private $created;

    /**
     * Set created
     *
     * @param string $created
     * @return Evidence
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return string 
     */
    public function getCreated()
    {
        return $this->created;
    }

    private $size;

    /**
     * Set size
     *
     * @param string $size
     * @return Evidence
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return string 
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @var string
     */
    private $course;

    /**
     * Set course
     *
     * @param string $course
     * @return Evidence
     */
    public function setCourse($course)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * Get course
     *
     * @return string 
     */
    public function getCourse()
    {
        return $this->course;
    }
    
    /**
     * @var string
     */
    private $jobId;

    /**
     * Set jobId
     *
     * @return string 
     */
    public function setJobId($jobId) {
        $this->jobId = $jobId;
		return $this;
    }

    /**
     * Get jobId
     *
     * @return string 
     */
    public function getJobId() {
        return $this->jobId;
    }

    /**
     * @var string
     */
    private $facilitatorViewStatus;

    /**
     * Set $facilitatorViewStatus
     *
     * @param string $facilitatorViewStatus
     * @return string
     */
    public function setFacilitatorViewStatus($facilitatorViewStatus) {
        $this->facilitatorViewStatus = $facilitatorViewStatus;
        return $this;
    }

    /**
     * Get $facilitatorViewStatus
     *
     * @return string
     */
    public function getFacilitatorViewStatus() {
        return $this->facilitatorViewStatus;
    } 
    
    /**
     * Get category
     *
     * @return string 
     */
    private $category;
    
    /**
     * 
     * @return type
     */
    function getCategory()
    {
        return $this->category;
    }

    /**
     * 
     * @param type $category
     */
    function setCategory($category)
    {
        $this->category = $category;
    }


}