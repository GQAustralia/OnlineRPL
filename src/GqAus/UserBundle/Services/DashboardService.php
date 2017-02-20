<?php

namespace GqAus\UserBundle\Services;

use Doctrine\ORM\EntityManager;

class DashboardService
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
        $this->repository = $em->getRepository('GqAusUserBundle:User');
    }

    /**
     * @param int $recipientUserId
     * @return array
     */
    public function countUserReceivedMessages($recipientUserId)
    {
        $roleNameAndTotal = [
            1 => ['total' => 0, 'name' => 'applicant'],
            2 => ['total' => 0, 'name' => 'facilitator'],
            3 => ['total' => 0, 'name' => 'assessor'],
            4 => ['total' => 0, 'name' => 'rto'],
            5 => ['total' => 0, 'name' => 'manager'],
            6 => ['total' => 0, 'name' => 'superadmin']
        ];
        $connection = $this->em->getConnection();

        $statement = $connection->prepare('
            SELECT u.role_type, COUNT(*) AS total
            FROM message m 
            LEFT JOIN USER u
            ON m.from_user = u.id
            WHERE m.to_user = ' . $recipientUserId . '
            AND m.read_status = 0
            GROUP BY u.role_type
        ');

        $statement->execute();

        foreach ($statement->fetchAll() as $message) {
            $roleNameAndTotal[$message['role_type']]['total'] = $message['total'];
        }

        return $roleNameAndTotal;
    }
}
