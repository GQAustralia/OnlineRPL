<?php

namespace GqAus\UserBundle\Services;

use Doctrine\ORM\EntityManager;

class UserService
{
    private $userId;
    private $repository;
    private $currentUser;
    /**
     * Constructor
     */
    public function __construct($em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository('GqAusUserBundle:User');
        $this->userId = 1;
        $this->currentUser = $this->getCurrentUser();
    }

    public function getCurrentUser()
    {
        return $this->repository->findOneById($this->userId);
    }
    
    public function saveProfile() 
    {
        $this->em->persist($this->currentUser);
        $this->em->flush();
    }

}