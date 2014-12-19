<?php

namespace GqAus\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tp
 */
class Tp
{
    /**
     * @var string
     */
    private $tpName;

    /**
     * @var string
     */
    private $tpDesc;

    /**
     * @var string
     */
    private $banner;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set tpName
     *
     * @param string $tpName
     * @return Tp
     */
    public function setTpName($tpName)
    {
        $this->tpName = $tpName;

        return $this;
    }

    /**
     * Get tpName
     *
     * @return string 
     */
    public function getTpName()
    {
        return $this->tpName;
    }

    /**
     * Set tpDesc
     *
     * @param string $tpDesc
     * @return Tp
     */
    public function setTpDesc($tpDesc)
    {
        $this->tpDesc = $tpDesc;

        return $this;
    }

    /**
     * Get tpDesc
     *
     * @return string 
     */
    public function getTpDesc()
    {
        return $this->tpDesc;
    }

    /**
     * Set banner
     *
     * @param string $banner
     * @return Tp
     */
    public function setBanner($banner)
    {
        $this->banner = $banner;

        return $this;
    }

    /**
     * Get banner
     *
     * @return string 
     */
    public function getBanner()
    {
        return $this->banner;
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
}
