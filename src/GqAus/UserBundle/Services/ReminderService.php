<?php

namespace GqAus\UserBundle\Services;

use Doctrine\ORM\EntityManager;
use GqAus\UserBundle\Entity\Reminder;
use GqAus\UserBundle\Entity\User;
use GqAus\UserBundle\Entity\UserCourses;

class ReminderService extends CustomRepositoryService
{
    const INCOMPLETE = 0;
    const DEFAULT_REMINDER_VIEW_STATUS = 0;

    protected $em;

    /**
     * SetNewUserPasswordService constructor.
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository('GqAusUserBundle:Reminder');
    }

    /**
     * @param UserCourses $userCourse
     * @param User $user
     * @param $date
     * @param $reminderType
     * @param User $createdBy
     * @param $message
     *
     * @return Reminder
     */
    public function factory($userCourse, User $user, $date, $reminderType, User $createdBy, $message)
    {
        $reminder = new Reminder();

        $reminder->setCourse($userCourse);
        $reminder->setUser($user);
        $reminder->setDate($date);
        $reminder->setReminderType($reminderType);
        $reminder->setCreatedby($createdBy);
        $reminder->setMessage($message);
        $reminder->setCompleted(self::INCOMPLETE);
        $reminder->setReminderViewStatus(self::DEFAULT_REMINDER_VIEW_STATUS);

        return $reminder;
    }
}
