<?php

namespace GqAus\UserBundle\Entity\Evidence;

use Doctrine\ORM\Mapping as ORM;

/**
 * Image
 */
class Image extends \GqAus\UserBundle\Entity\Evidence
{

    const TYPE = 'image';
    
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
}
