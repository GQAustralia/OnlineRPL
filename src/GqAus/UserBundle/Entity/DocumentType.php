<?php

namespace GqAus\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DocumentType
 */
class DocumentType
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $points;

    /**
     * @var integer
     */
    private $id;

    /**
     * Set name
     *
     * @param string $name
     * @return DocumentType
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
     * Set points
     *
     * @param integer $points
     * @return DocumentType
     */
    public function setPoints($points)
    {
        $this->points = $points;

        return $this;
    }

    /**
     * Get points
     *
     * @return integer 
     */
    public function getPoints()
    {
        return $this->points;
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
    private $type;

    /**
     * Set type
     *
     * @param string $type
     * @return DocumentType
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
     * @var string
     */
    private $typeWithPoints;
    
    /**
     * Get type with points
     *
     * @return string 
     */
    public function getTypeWithPoints()
    {
        return $typeWithPoints = $this->type.' ('.$this->points.')';
    }

}
