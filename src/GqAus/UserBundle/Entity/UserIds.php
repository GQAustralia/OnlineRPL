<?php

namespace GqAus\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserIds
 */
class UserIds
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
     * @var integer
     */
    private $id;

    /**
     * @var \GqAus\UserBundle\Entity\User
     */
    private $user;

    /**
     * @var \GqAus\UserBundle\Entity\DocumentType
     */
    private $type;

    /**
     * @var datetime
     */
    private $created;
    /**
     * @var size
     */
    private $size;
      /**
     * @var status
     */
    private $status;

    /**
     * Set name
     *
     * @param string $name
     * @return UserIds
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
     * @return UserIds
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user
     *
     * @param \GqAus\UserBundle\Entity\User $user
     * @return UserIds
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
     * Set type
     *
     * @param \GqAus\UserBundle\Entity\DocumentType $type
     * @return UserIds
     */
    public function setType(\GqAus\UserBundle\Entity\DocumentType $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \GqAus\UserBundle\Entity\DocumentType 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get date
     *
     * @return string
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set created
     *
     * @param string $created
     * @return UserIds
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }
    /**
     * Set size
     *
     * @param string $path
     * @return size
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
     * Set status
     *
     * @param int $status
     * @return int
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return int 
     */
    public function getStatus()
    {
        return $this->status;
    }

}
