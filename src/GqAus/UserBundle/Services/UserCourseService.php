<?php

namespace GqAus\UserBundle\Services;

use Doctrine\ORM\EntityManager;

class UserCourseService extends CustomRepositoryService
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * SetNewUserPasswordService constructor.
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository('GqAusUserBundle:UserCourses');
    }

    /**
     * @param $id
     *
     * @return null|object
     */
    public function findOneById($id)
    {
        return $this->repository->find($id);
    }
}
