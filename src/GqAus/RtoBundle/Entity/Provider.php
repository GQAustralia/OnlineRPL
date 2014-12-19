<?php

namespace GqAus\RtoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Provider
 */
class Provider
{
    /**
     * @var integer
     */
    private $price;

    /**
     * @var string
     */
    private $international;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \GqAus\CourseBundle\Entity\Course
     */
    private $course;

    /**
     * @var \GqAus\RtoBundle\Entity\Rto
     */
    private $rto;


    /**
     * Set price
     *
     * @param integer $price
     * @return Provider
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set international
     *
     * @param string $international
     * @return Provider
     */
    public function setInternational($international)
    {
        $this->international = $international;

        return $this;
    }

    /**
     * Get international
     *
     * @return string 
     */
    public function getInternational()
    {
        return $this->international;
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
     * @return Provider
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
     * Set rto
     *
     * @param \GqAus\RtoBundle\Entity\Rto $rto
     * @return Provider
     */
    public function setRto(\GqAus\RtoBundle\Entity\Rto $rto = null)
    {
        $this->rto = $rto;

        return $this;
    }

    /**
     * Get rto
     *
     * @return \GqAus\RtoBundle\Entity\Rto 
     */
    public function getRto()
    {
        return $this->rto;
    }
}
