<?php

namespace GqAus\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * QualCrmId
 */
class QualCrmId
{
    /**
     * @var string
     */
    private $qualPlatId;

    /**
     * @var string
     */
    private $rto;

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
     * @var string
     */
    private $active;

    /**
     * @var integer
     */
    private $id;


    /**
     * Set qualPlatId
     *
     * @param string $qualPlatId
     * @return QualCrmId
     */
    public function setQualPlatId($qualPlatId)
    {
        $this->qualPlatId = $qualPlatId;

        return $this;
    }

    /**
     * Get qualPlatId
     *
     * @return string 
     */
    public function getQualPlatId()
    {
        return $this->qualPlatId;
    }

    /**
     * Set rto
     *
     * @param string $rto
     * @return QualCrmId
     */
    public function setRto($rto)
    {
        $this->rto = $rto;

        return $this;
    }

    /**
     * Get rto
     *
     * @return string 
     */
    public function getRto()
    {
        return $this->rto;
    }

    /**
     * Set crmId
     *
     * @param string $crmId
     * @return QualCrmId
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
     * @return QualCrmId
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
     * @return QualCrmId
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
     * Set active
     *
     * @param string $active
     * @return QualCrmId
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return string 
     */
    public function getActive()
    {
        return $this->active;
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
