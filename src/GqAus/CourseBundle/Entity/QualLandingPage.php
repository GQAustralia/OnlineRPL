<?php

namespace GqAus\CourseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * QualLandingPage
 */
class QualLandingPage
{
    /**
     * @var string
     */
    private $headline;

    /**
     * @var string
     */
    private $tagline;

    /**
     * @var string
     */
    private $video;

    /**
     * @var string
     */
    private $imageSrc;

    /**
     * @var string
     */
    private $imageAlt;

    /**
     * @var string
     */
    private $btnClass;

    /**
     * @var string
     */
    private $pageTitle;

    /**
     * @var string
     */
    private $whiteLogo;

    /**
     * @var string
     */
    private $headlineClass;

    /**
     * @var string
     */
    private $taglineClass;

    /**
     * @var \GqAus\CourseBundle\Entity\Course
     */
    private $course;


    /**
     * Set headline
     *
     * @param string $headline
     * @return QualLandingPage
     */
    public function setHeadline($headline)
    {
        $this->headline = $headline;

        return $this;
    }

    /**
     * Get headline
     *
     * @return string 
     */
    public function getHeadline()
    {
        return $this->headline;
    }

    /**
     * Set tagline
     *
     * @param string $tagline
     * @return QualLandingPage
     */
    public function setTagline($tagline)
    {
        $this->tagline = $tagline;

        return $this;
    }

    /**
     * Get tagline
     *
     * @return string 
     */
    public function getTagline()
    {
        return $this->tagline;
    }

    /**
     * Set video
     *
     * @param string $video
     * @return QualLandingPage
     */
    public function setVideo($video)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Get video
     *
     * @return string 
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * Set imageSrc
     *
     * @param string $imageSrc
     * @return QualLandingPage
     */
    public function setImageSrc($imageSrc)
    {
        $this->imageSrc = $imageSrc;

        return $this;
    }

    /**
     * Get imageSrc
     *
     * @return string 
     */
    public function getImageSrc()
    {
        return $this->imageSrc;
    }

    /**
     * Set imageAlt
     *
     * @param string $imageAlt
     * @return QualLandingPage
     */
    public function setImageAlt($imageAlt)
    {
        $this->imageAlt = $imageAlt;

        return $this;
    }

    /**
     * Get imageAlt
     *
     * @return string 
     */
    public function getImageAlt()
    {
        return $this->imageAlt;
    }

    /**
     * Set btnClass
     *
     * @param string $btnClass
     * @return QualLandingPage
     */
    public function setBtnClass($btnClass)
    {
        $this->btnClass = $btnClass;

        return $this;
    }

    /**
     * Get btnClass
     *
     * @return string 
     */
    public function getBtnClass()
    {
        return $this->btnClass;
    }

    /**
     * Set pageTitle
     *
     * @param string $pageTitle
     * @return QualLandingPage
     */
    public function setPageTitle($pageTitle)
    {
        $this->pageTitle = $pageTitle;

        return $this;
    }

    /**
     * Get pageTitle
     *
     * @return string 
     */
    public function getPageTitle()
    {
        return $this->pageTitle;
    }

    /**
     * Set whiteLogo
     *
     * @param string $whiteLogo
     * @return QualLandingPage
     */
    public function setWhiteLogo($whiteLogo)
    {
        $this->whiteLogo = $whiteLogo;

        return $this;
    }

    /**
     * Get whiteLogo
     *
     * @return string 
     */
    public function getWhiteLogo()
    {
        return $this->whiteLogo;
    }

    /**
     * Set headlineClass
     *
     * @param string $headlineClass
     * @return QualLandingPage
     */
    public function setHeadlineClass($headlineClass)
    {
        $this->headlineClass = $headlineClass;

        return $this;
    }

    /**
     * Get headlineClass
     *
     * @return string 
     */
    public function getHeadlineClass()
    {
        return $this->headlineClass;
    }

    /**
     * Set taglineClass
     *
     * @param string $taglineClass
     * @return QualLandingPage
     */
    public function setTaglineClass($taglineClass)
    {
        $this->taglineClass = $taglineClass;

        return $this;
    }

    /**
     * Get taglineClass
     *
     * @return string 
     */
    public function getTaglineClass()
    {
        return $this->taglineClass;
    }

    /**
     * Set course
     *
     * @param \GqAus\CourseBundle\Entity\Course $course
     * @return QualLandingPage
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
