<?php

namespace GqAus\RtoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RtoCrmId
 */
class RtoCrmId
{
    /**
     * @var string
     */
    private $crmId;

    /**
     * @var string
     */
    private $upToDate;

    /**
     * @var string
     */
    private $markDelete;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var \GqAus\RtoBundle\Entity\Rto
     */
    private $rtoPlat;


    /**
     * Set crmId
     *
     * @param string $crmId
     * @return RtoCrmId
     */
    public function setCrmId($crmId)
    {
        $this->crmId = $crmId;

        return $this;
    }

    /**
     * Get crmId
     *
     * @return string 
     */
    public function getCrmId()
    {
        return $this->crmId;
    }

    /**
     * Set upToDate
     *
     * @param string $upToDate
     * @return RtoCrmId
     */
    public function setUpToDate($upToDate)
    {
        $this->upToDate = $upToDate;

        return $this;
    }

    /**
     * Get upToDate
     *
     * @return string 
     */
    public function getUpToDate()
    {
        return $this->upToDate;
    }

    /**
     * Set markDelete
     *
     * @param string $markDelete
     * @return RtoCrmId
     */
    public function setMarkDelete($markDelete)
    {
        $this->markDelete = $markDelete;

        return $this;
    }

    /**
     * Get markDelete
     *
     * @return string 
     */
    public function getMarkDelete()
    {
        return $this->markDelete;
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
     * Set rtoPlat
     *
     * @param \GqAus\RtoBundle\Entity\Rto $rtoPlat
     * @return RtoCrmId
     */
    public function setRtoPlat(\GqAus\RtoBundle\Entity\Rto $rtoPlat = null)
    {
        $this->rtoPlat = $rtoPlat;

        return $this;
    }

    /**
     * Get rtoPlat
     *
     * @return \GqAus\RtoBundle\Entity\Rto 
     */
    public function getRtoPlat()
    {
        return $this->rtoPlat;
    }
}
