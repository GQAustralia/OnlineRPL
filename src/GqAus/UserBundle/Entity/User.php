<?php

namespace GqAus\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 */
abstract class User implements UserInterface, \Serializable
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
     * @var string
     */
    private $ceoname;
    
    
    /**
     * @var string
     */
    private $ceoemail;
    
    
    /**
     * @var string
     */
    private $ceophone;
    
    /**
     * @var string
    */
    private $createdby;

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
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $evidences;


    /**
     * Add evidences
     *
     * @param \GqAus\UserBundle\Entity\Evidence $evidences
     * @return User
     */
    public function addEvidence(\GqAus\UserBundle\Entity\Evidence $evidences)
    {
        $this->evidences[] = $evidences;

        return $this;
    }

    /**
     * Remove evidences
     *
     * @param \GqAus\UserBundle\Entity\Evidence $evidences
     */
    public function removeEvidence(\GqAus\UserBundle\Entity\Evidence $evidences)
    {
        $this->evidences->removeElement($evidences);
    }

    /**
     * Get evidences
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEvidences()
    {
        return $this->evidences;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $reminders;


    /**
     * Add reminders
     *
     * @param \GqAus\UserBundle\Entity\Reminder $reminders
     * @return User
     */
    public function addReminder(\GqAus\UserBundle\Entity\Reminder $reminders)
    {
        $this->reminders[] = $reminders;

        return $this;
    }

    /**
     * Remove reminders
     *
     * @param \GqAus\UserBundle\Entity\Reminder $reminders
     */
    public function removeReminder(\GqAus\UserBundle\Entity\Reminder $reminders)
    {
        $this->reminders->removeElement($reminders);
    }

    /**
     * Get reminders
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReminders()
    {
        return $this->reminders;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $otherfiles;


    /**
     * Add otherfiles
     *
     * @param \GqAus\UserBundle\Entity\OtherFiles $otherfiles
     * @return User
     */
    public function addOtherfile(\GqAus\UserBundle\Entity\OtherFiles $otherfiles)
    {
        $this->otherfiles[] = $otherfiles;

        return $this;
    }

    /**
     * Remove otherfiles
     *
     * @param \GqAus\UserBundle\Entity\OtherFiles $otherfiles
     */
    public function removeOtherfile(\GqAus\UserBundle\Entity\OtherFiles $otherfiles)
    {
        $this->otherfiles->removeElement($otherfiles);
    }

    /**
     * Get otherfiles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOtherfiles()
    {
        return $this->otherfiles;
    }
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $inboxMessages;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $sentMessages;


    /**
     * Add inboxMessages
     *
     * @param \GqAus\UserBundle\Entity\Message $inboxMessages
     * @return User
     */
    public function addInboxMessage(\GqAus\UserBundle\Entity\Message $inboxMessages)
    {
        $this->inboxMessages[] = $inboxMessages;

        return $this;
    }

    /**
     * Remove inboxMessages
     *
     * @param \GqAus\UserBundle\Entity\Message $inboxMessages
     */
    public function removeInboxMessage(\GqAus\UserBundle\Entity\Message $inboxMessages)
    {
        $this->inboxMessages->removeElement($inboxMessages);
    }

    /**
     * Get inboxMessages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInboxMessages()
    {
        return $this->inboxMessages;
    }

    /**
     * Add sentMessages
     *
     * @param \GqAus\UserBundle\Entity\Message $sentMessages
     * @return User
     */
    public function addSentMessage(\GqAus\UserBundle\Entity\Message $sentMessages)
    {
        $this->sentMessages[] = $sentMessages;

        return $this;
    }

    /**
     * Remove sentMessages
     *
     * @param \GqAus\UserBundle\Entity\Message $sentMessages
     */
    public function removeSentMessage(\GqAus\UserBundle\Entity\Message $sentMessages)
    {
        $this->sentMessages->removeElement($sentMessages);
    }

    /**
     * Get sentMessages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSentMessages()
    {
        return $this->sentMessages;
    }
    /**
     * @var string
     */
    private $contactName;

    /**
     * @var string
     */
    private $contactEmail;

    /**
     * @var string
     */
    private $contactPhone;


    /**
     * Set contactName
     *
     * @param string $contactName
     * @return User
     */
    public function setContactName($contactName)
    {
        $this->contactName = $contactName;

        return $this;
    }

    /**
     * Get contactName
     *
     * @return string 
     */
    public function getContactName()
    {
        return $this->contactName;
    }

    /**
     * Set contactEmail
     *
     * @param string $contactEmail
     * @return User
     */
    public function setContactEmail($contactEmail)
    {
        $this->contactEmail = $contactEmail;

        return $this;
    }

    /**
     * Get contactEmail
     *
     * @return string 
     */
    public function getContactEmail()
    {
        return $this->contactEmail;
    }

    /**
     * Set contactPhone
     *
     * @param string $contactPhone
     * @return User
     */
    public function setContactPhone($contactPhone)
    {
        $this->contactPhone = $contactPhone;

        return $this;
    }

    /**
     * Get contactPhone
     *
     * @return string 
     */
    public function getContactPhone()
    {
        return $this->contactPhone;
    }
    
    /**
     * Set ceoname
     *
     * @param string $ceoname
     * @return User
     */
    public function setCeoname($ceoname)
    {
        $this->ceoname = $ceoname;

        return $this;
    }
    
    /**
     * Set ceoemail
     *
     * @param string $ceoemail
     * @return User
     */
    public function setCeoemail($ceoemail)
    {
        $this->ceoemail = $ceoemail;

        return $this;
    }
    
    /**
     * Set ceophone
     *
     * @param string $ceophone
     * @return User
     */
    public function setCeophone($ceophone)
    {
        $this->ceophone = $ceophone;

        return $this;
    }

    /**
     * Get ceoname
     *
     * @return string 
     */
    public function getCeoname()
    {
        return $this->ceoname;
    }
    
    /**
     * Get ceoemail
     *
     * @return string 
     */
    public function getCeoemail()
    {
        return $this->ceoemail;
    }
    
    
    /**
     * Get ceophone
     *
     * @return string 
     */
    public function getCeophone()
    {
        return $this->ceophone;
    }
    
    /**
     * Set createdby
     *
     * @param string $createdby
     * @return User
     */
    public function setCreatedby($createdby)
    {
        $this->createdby = $createdby;

        return $this;
    }

    /**
     * Get createdby
     *
     * @return string 
     */
    public function getCreatedby()
    {
        return $this->createdby;
    }
}
