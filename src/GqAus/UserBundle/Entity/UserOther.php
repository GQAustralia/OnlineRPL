<?php

namespace GqAus\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserAddress
 */
class UserOther
{
    /**
     * @var integer
     */
    private $curinAustralia;
    
    /**
     * @var integer
     */
    private $interStudentvet;

    /**
     * @var integer
     */
    private $exemStudidentreg;

    /**
     * @var integer
     */
    private $applyForyourusi;
    
    /**
     * @var string
     */
    private $id;

    /**
     * @var \GqAus\UserBundle\Entity\User
     */
    private $user;

    

    /**
     * Get id
     *
     * @return string 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user
     *
     * @param \GqAus\UserBundle\Entity\User $user
     * @return User
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
     * Set CurinAustralia
     *
     * @return string
     */
    public function setCurinAustralia($curinAustralia)
    {
        $this->curinAustralia = $curinAustralia;

        return $this;
    }

    /**
     * Get CurinAustralia
     *
     * @return string 
     */
    public function getCurinAustralia()
    {
        return $this->curinAustralia;
    }
    /**
     * Set InterStudentVET
     *
     * @param string $interStudentVET
     * @return integer
     */
    public function setInterStudentVET($interStudentvet)
    {
        $this->interStudentvet = $interStudentvet;

        return $this;
    }

    /**
     * Get InterStudentVET
     *
     * @return integer 
     */
    public function getInterStudentVET()
    {
        return $this->interStudentvet;
    }
    
    /**
     * Set ExemptionSir
     *
     * @param string $exemptionSir
     * @return integer
     */
    public function setExemptionSir($exemStudidentreg)
    {
        $this->exemStudidentreg = $exemStudidentreg;

        return $this;
    }

    /**
     * Get ExemptionSir
     *
     * @return integer 
     */
    public function getExemptionSir()
    {
        return $this->exemStudidentreg;
    }

    /**
     * Set LikeApplyUSI
     *
     * @param string $likeApplyUSI
     * @return integer
     */
    public function setLikeApplyUSI($applyForyourusi)
    {
        $this->applyForyourusi = $applyForyourusi;

        return $this;
    }

    /**
     * Get LikeApplyUSI
     *
     * @return integer 
     */
    public function getLikeApplyUSI()
    {
        return $this->applyForyourusi;
    }
}
