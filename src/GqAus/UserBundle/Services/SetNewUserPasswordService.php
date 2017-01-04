<?php

namespace GqAus\UserBundle\Services;

use Doctrine\ORM\EntityManager;
use GqAus\UserBundle\Entity\User;
use GqAus\UserBundle\Resolvers\PasswordHasher;

class SetNewUserPasswordService
{
    use PasswordHasher;

    const TOKEN_STATUS = 1;
    const APPLICATION_STATUS = 2;

    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    protected $repository;

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
     * @param string $loginToken
     * @param string $newPassword
     *
     * @return bool|User
     */
    public function validateUserTokenAndUpdatePassword($loginToken, $newPassword)
    {
        if (!$user = $this->findUserByLoginToken($loginToken)) {
            return false;
        }

        return $this->updatePassword($user, $newPassword);
    }

    /**
     * @param int $loginToken
     *
     * @return mixed
     */
    private function findUserByLoginToken($loginToken)
    {
        return $this->repository->findOneBy(['loginToken' => $loginToken]);
    }

    /**
     * @param User $user
     * @param string $newPassword
     *
     * @return User
     */
    private function updatePassword(User $user, $newPassword)
    {
        $hashedPassword =$this->hashPassword($newPassword);

        $user->setPassword($hashedPassword);
        $user->setPasswordToken($newPassword);
        $user->setTokenStatus(self::TOKEN_STATUS);
        $user->setApplicantStatus(self::APPLICATION_STATUS);

        $this->em->flush();

        return $user;
    }
}
