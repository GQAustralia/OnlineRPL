<?php

namespace GqAus\UserBundle\Services;

use Doctrine\ORM\EntityManager;
use GqAus\UserBundle\Entity\Evidence\File;

class EvidenceService
{
    private $userId;
    private $repository;
    private $currentUser;
    /**
     * @var Object
     */
    private $container;
    
    /**
     * Constructor
     */
    public function __construct($em, $container)
    {
        $this->em = $em;
        $session = $container->get('session');
        $this->userId = $session->get('user_id');
        $this->repository = $em->getRepository('GqAusUserBundle:User');
        $this->currentUser = $this->getCurrentUser();
        $this->container = $container;
    }

    public function getCurrentUser()
    {
        return $this->repository->findOneById($this->userId);
    }
    
    public function saveEvidence($evidences, $unit)
    {      
        foreach ($evidences as $evidence) {            
            $fileObj = new File();
            $fileObj->setPath($evidence['aws_file_name']);
            $fileObj->setName($evidence['orginal_name']);
            $fileObj->setUser($this->currentUser);
            $fileObj->setUnit($unit);        
            $this->em->persist($fileObj);
            $this->em->flush();
        }
    }
    
    
    
}