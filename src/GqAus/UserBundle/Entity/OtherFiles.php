<?php

namespace GqAus\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OtherFiles
 */
class OtherFiles
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $type;

    /**
     * @var \DateTime
     */
    private $created;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \GqAus\UserBundle\Entity\User
     */
    private $assessor;
     /**
     * @var size
     */
    private $size;
	 /**
     * @var size
     */
    private $isdeleted;
    /**
     * Set name
     *
     * @param string $name
     * @return OtherFiles
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return OtherFiles
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
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
     * @param string $type
     * @return OtherFiles
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return OtherFiles
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
     * Set assessor
     *
     * @param \GqAus\UserBundle\Entity\User $assessor
     * @return OtherFiles
     */
    public function setAssessor(\GqAus\UserBundle\Entity\User $assessor = null)
    {
        $this->assessor = $assessor;

        return $this;
    }

    /**
     * Get assessor
     *
     * @return \GqAus\UserBundle\Entity\User 
     */
    public function getAssessor()
    {
        return $this->assessor;
    }
    /**
     * Set size
     *
     * @param string $size
     * @return int
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return int 
     */
    public function getSize()
    {
        return $this->size;
    }
	/**
     * Set isdeleted
     *
     * @param string $isdeleted
     * @return int
     */
    public function setIsdeleted($isdeleted)
    {
        $this->isdeleted = $isdeleted;

        return $this;
    }

    /**
     * Get isdeleted
     *
     * @return int 
     */
    public function getIsdeleted()
    {
        return $this->isdeleted;
    }

}
