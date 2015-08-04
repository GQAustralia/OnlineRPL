<?php

namespace GqAus\UserBundle\Entity\Evidence;

use Doctrine\ORM\Mapping as ORM;

/**
 * Text
 */
class Text extends \GqAus\UserBundle\Entity\Evidence
{

    const TYPE = 'text';
    
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
    private $content;


    /**
     * Set content
     *
     * @param string $content
     * @return Text
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }
}
