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
    private $name;

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
     * @var \Doctrine\Common\Collections\Collection
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
        $this->courses = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     * @return User
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
     * Add courses
     *
     * @param \GqAus\CourseBundle\Entity\Course $courses
     * @return User
     */
    public function addCourse(\GqAus\CourseBundle\Entity\Course $courses)
    {
        $this->courses[] = $courses;

        return $this;
    }

    /**
     * Remove courses
     *
     * @param \GqAus\CourseBundle\Entity\Course $courses
     */
    public function removeCourse(\GqAus\CourseBundle\Entity\Course $courses)
    {
        $this->courses->removeElement($courses);
    }

    /**
     * Get courses
     *
     * @return \Doctrine\Common\Collections\Collection 
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
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return $this->salt;
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
}
