<?php

namespace GqAus\UserBundle\Services;

use Doctrine\ORM\EntityManager;

class CustomRepositoryService
{
    protected $connection;
    protected $em;

    /**
     * RepositoryService constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->connection = $this->em->getConnection();
    }

    /**
     * @param string $query
     *
     * @return array
     */
    public function all($query)
    {
        $result = $this->connection->prepare($query);

        $result->execute();

        return $result->fetchAll();
    }
}