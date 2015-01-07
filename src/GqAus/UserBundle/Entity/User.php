<?php

namespace GqAus\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 */
class User implements UserInterface, \Serializable
{
   /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $id;

    /**
     * @var \GqAus\UserBundle\Entity\UserAddress
     */
    private $address;

    /**
     * @var \GqAus\UserBundle\Entity\UserCourses
     */
    private $courses;
    
    /**
     * @var string
     */
    private $password;
    

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->salt = md5(uniqid(null, true));
    }

    
    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

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
     * Set address
     *
     * @param \GqAus\UserBundle\Entity\UserAddress $address
     * @return User
     */
    public function setAddress(\GqAus\UserBundle\Entity\UserAddress $address = null)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return \GqAus\UserBundle\Entity\UserAddress 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set courses
     *
     * @param \GqAus\UserBundle\Entity\UserCourses $courses
     * @return User
     */
    public function setCourses(\GqAus\UserBundle\Entity\UserCourses $courses = null)
    {
        $this->courses = $courses;

        return $this;
    }

    /**
     * Get courses
     *
     * @return \GqAus\UserBundle\Entity\UserAddress 
     */
    public function getCourses()
    {
        return $this->courses;
    }
    
    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;
    
     /**
     * @var string
     */
    private $passwordToken;
    
     /**
     * @var datetime
     */
    private $tokenExpiry;
    
     /**
     * @var string
     */
    private $tokenStatus;
    
    /**
     * @var string
     */
    private $userImage;


    /**
     * Set firstName
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }
    
    
    /**
     * Set userImage
     *
     * @param string $userImage
     * @return User
     */
    public function setUserImage($userImage)
    {
        $this->userImage = $userImage;

        return $this;
    }

    /**
     * Get userImage
     *
     * @return string 
     */
    public function getUserImage()
    {
        return $this->userImage;
    }
    
    /**
     * Set passwordToken
     *
     * @param string $passwordToken
     * @return User
     */
    public function setPasswordToken($passwordToken)
    {
        $this->passwordToken = $passwordToken;

        return $this;
    }

    /**
     * Get passwordToken
     *
     * @return string 
     */
    public function getPasswordToken()
    {
        return $this->passwordToken;
    }
    
    
    /**
     * Set tokenExpiry
     *
     * @param datetime $tokenExpiry
     * @return User
     */
    public function setTokenExpiry($tokenExpiry)
    {
        $this->tokenExpiry = $tokenExpiry;

        return $this;
    }

    /**
     * Get tokenExpiry
     *
     * @return datetime 
     */
    public function getTokenExpiry()
    {
        return $this->tokenExpiry;
    }
    
    /**
     * Set tokenStatus
     *
     * @param string $tokenStatus
     * @return User
     */
    public function setTokenStatus($tokenStatus)
    {
        $this->tokenStatus = $tokenStatus;

        return $this;
    }

    /**
     * Get tokenStatus
     *
     * @return string 
     */
    public function getTokenStatus()
    {
        return $this->tokenStatus;
    }

    /**
     * Add address
     *
     * @param \GqAus\UserBundle\Entity\UserAddress $address
     * @return User
     */
    public function addAddress(\GqAus\UserBundle\Entity\UserAddress $address)
    {
        $this->address[] = $address;

        return $this;
    }

    /**
     * Remove address
     *
     * @param \GqAus\UserBundle\Entity\UserAddress $address
     */
    public function removeAddress(\GqAus\UserBundle\Entity\UserAddress $address)
    {
        $this->address->removeElement($address);
    }
    
    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }
    
    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }
    
    /**
     * @var string
     */
    private $salt;
    
    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->firstName.' '.$this->lastName;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        //return $this->salt;
         return null;
    }

   
    /**
     * @inheritDoc
     */
    public function getRoles()
    {
       return array($this->getRoleName());
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
        ) = unserialize($serialized);
    }

    /**
     * Add courses
     *
     * @param \GqAus\UserBundle\Entity\UserCourses $courses
     * @return User
     */
    public function addCourse(\GqAus\UserBundle\Entity\UserCourses $courses)
    {
        $this->courses[] = $courses;

        return $this;
    }

    /**
     * Remove courses
     *
     * @param \GqAus\UserBundle\Entity\UserCourses $courses
     */
    public function removeCourse(\GqAus\UserBundle\Entity\UserCourses $courses)
    {
        $this->courses->removeElement($courses);
    }
    /**
     * @var integer
     */
    private $courseConditionStatus;


    /**
     * Set courseConditionStatus
     *
     * @param integer $courseConditionStatus
     * @return User
     */
    public function setCourseConditionStatus($courseConditionStatus)
    {
        $this->courseConditionStatus = $courseConditionStatus;

        return $this;
    }

    /**
     * Get courseConditionStatus
     *
     * @return integer 
     */
    public function getCourseConditionStatus()
    {
        return $this->courseConditionStatus;
    }
    /**
     * @var string
     */
    private $dateOfBirth;

    /**
     * @var string
     */
    private $gender;

    /**
     * @var string
     */
    private $universalStudentIdentifier;


    /**
     * Set dateOfBirth
     *
     * @param string $dateOfBirth
     * @return User
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    /**
     * Get dateOfBirth
     *
     * @return string 
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string 
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set universalStudentIdentifier
     *
     * @param string $universalStudentIdentifier
     * @return User
     */
    public function setUniversalStudentIdentifier($universalStudentIdentifier)
    {
        $this->universalStudentIdentifier = $universalStudentIdentifier;

        return $this;
    }

    /**
     * Get universalStudentIdentifier
     *
     * @return string 
     */
    public function getUniversalStudentIdentifier()
    {
        return $this->universalStudentIdentifier;
    }
    /**
     * @var \GqAus\UserBundle\Entity\UserIds
     */
    private $idfiles;


    /**
     * Set idfiles
     *
     * @param \GqAus\UserBundle\Entity\UserIds $idfiles
     * @return User
     */
    public function setIdfiles(\GqAus\UserBundle\Entity\UserIds $idfiles = null)
    {
        $this->idfiles = $idfiles;

        return $this;
    }

    /**
     * Get idfiles
     *
     * @return \GqAus\UserBundle\Entity\UserIds 
     */
    public function getIdfiles()
    {
        return $this->idfiles;
    }

    /**
     * Add idfiles
     *
     * @param \GqAus\UserBundle\Entity\UserIds $idfiles
     * @return User
     */
    public function addIdfile(\GqAus\UserBundle\Entity\UserIds $idfiles)
    {
        $this->idfiles[] = $idfiles;

        return $this;
    }

    /**
     * Remove idfiles
     *
     * @param \GqAus\UserBundle\Entity\UserIds $idfiles
     */
    public function removeIdfile(\GqAus\UserBundle\Entity\UserIds $idfiles)
    {
        $this->idfiles->removeElement($idfiles);
    }
}
