<?php

namespace GqAus\UserBundle\Entity\Evidence;

use Doctrine\ORM\Mapping as ORM;

/**
 * Video
 */
class Video extends \GqAus\UserBundle\Entity\Evidence
{

    const TYPE = 'video';

    /**
     * @var string
     */
    private $path;

    /**
     * Returns type of evidence.
     *
     * @return string
     */
    public function getType()
    {
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
     * @return Video
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
}
