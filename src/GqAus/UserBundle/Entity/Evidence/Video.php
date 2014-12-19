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

}
