<?php

namespace GqAus\UserBundle\Entity\Evidence;

use Doctrine\ORM\Mapping as ORM;

/**
 * Audio
 */
class Audio extends \GqAus\UserBundle\Entity\Evidence
{

    const TYPE = 'audio';
    
/**
     * @var string
     */
    private $path;

     /**
     * Returns type of evidence.
     *
     * @return string
     */
    public function getType(){
        return self::TYPE;
    }
    
    /**
     * Set path
     *
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
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
     * @var string
     */
    private $name;


    /**
     * Set name
     *
     * @param string $name
     * @return Audio
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
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
       $pos = strpos($this->name, '.');
       return substr($this->name, 0, $pos);
    }
}
