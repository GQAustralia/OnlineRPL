<?php

namespace GqAus\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Room
 */
class Room
{

    /**
     * @var string
     */
    private $session;

    /**
     * @var integer
     */
    private $assessor;

    /**
     * @var integer
     */
    private $applicant;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var integer
     */
    private $id;

    /**
     * Set session
     *
     * @param string $session
     * @return Room
     */
    public function setSession($session)
    {
        $this->session = $session;

        return $this;
    }

    /**
     * Get session
     *
     * @return string 
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Set assessor
     *
     * @param integer $assessor
     * @return Room
     */
    public function setAssessor($assessor)
    {
        $this->assessor = $assessor;

        return $this;
    }

    /**
     * Get assessor
     *
     * @return integer 
     */
    public function getAssessor()
    {
        return $this->assessor;
    }

    /**
     * Set applicant
     *
     * @param integer $applicant
     * @return Room
     */
    public function setApplicant($applicant)
    {
        $this->applicant = $applicant;

        return $this;
    }

    /**
     * Get applicant
     *
     * @return integer 
     */
    public function getApplicant()
    {
        return $this->applicant;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Room
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
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
     * @var string
     */
    private $token;

    /**
     * Set token
     *
     * @param string $token
     * @return Room
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string 
     */
    public function getToken()
    {
        return $this->token;
    }

}
