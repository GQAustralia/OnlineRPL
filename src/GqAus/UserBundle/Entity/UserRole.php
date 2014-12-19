<?php

namespace GqAus\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserRole
 */
class UserRole
{

    /**
     * @var \GqAus\CourseBundle\Entity\User
     */
    private $user;

    /**
     * @var \GqAus\UserBundle\Entity\Role
     */
    private $role;

    /**
     * Set user
     *
     * @param \GqAus\CourseBundle\Entity\User $user
     * @return UserRole
     */
    public function setUser(\GqAus\CourseBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \GqAus\CourseBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set role
     *
     * @param \GqAus\UserBundle\Entity\Role $role
     * @return UserRole
     */
    public function setRole(\GqAus\UserBundle\Entity\Role $role = null)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return \GqAus\UserBundle\Entity\Role 
     */
    public function getRole()
    {
        return $this->role;
    }
}
