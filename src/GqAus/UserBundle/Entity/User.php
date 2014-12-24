<?php

namespace GqAus\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 */
class User
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
     * Constructor
     */
    public function __construct()
    {
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
}
