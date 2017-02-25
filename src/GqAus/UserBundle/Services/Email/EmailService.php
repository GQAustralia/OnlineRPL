<?php

namespace GqAus\UserBundle\Services\Email;

use Doctrine\ORM\EntityManager;
use GqAus\UserBundle\Services\CustomRepositoryService;
use Swift_Message;

class EmailService extends CustomRepositoryService
{
    CONST SUPERVISOR_ROLE_ID = 22;

    /**
     * @var
     */
    private $templating;

    /**
     * SetNewUserPasswordService constructor.
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em, $templating, $mailer)
    {
        parent::__construct($em);

        $this->templating = $templating;
        $this->mailer = $mailer;
        $this->userRepository = $em->getRepository('GqAusUserBundle:User');
        $this->userCourseRepository = $em->getRepository('GqAusUserBundle:UserCourses');
    }

    /**
     * @param $userId
     *
     * @return mixed
     */
    public function sendNotificationToApplicant($userId)
    {
        $user = $this->userRepository->findOneBy(['id' => $userId]);

        $emailContent = $this->templating->render(
            'GqAusUserBundle:Email:email-notifications.html.twig',
            ['user' => $user]
        );

        $email = $this->emailFactory(
            'Notification',
            'jeremuelraymundo@gmail.com',
            'jeremuelraymundo@gmail.com',
            $emailContent
        );

        return $this->mailer->send($email);
    }

    public function sendWelcomeEmailToApplicant($userId, $courseName)
    {
        $user = $this->userRepository->findOneBy(['id' => $userId]);

        if (!$user) {
            return null;
        }

        $emailContent = $this->templating->render(
            'GqAusUserBundle:Email:welcome.html.twig',
            ['user' => $user, 'courseName' => $courseName]
        );

        $email = $this->emailFactory(
            'Welcome to Online RPL',
            'jeremuelraymundo@gmail.com',
            'jeremuelraymundo@gmail.com',
            $emailContent
        );

        return $this->mailer->send($email);
    }

    /**
     * @param $userId
     *
     * @return null
     */
    public function notifyApplicantForTheAssignedAccountManager($userId, $courseCode)
    {
        $userCourse = $this->userCourseRepository->findOneBy(['user' => $userId, 'courseCode' => $courseCode]);
        $manager = $this->userRepository->findOneBy(['id' => $userCourse->getManager()]);

        if (!$userCourse) {
            return null;
        }

        $emailContent = $this->templating->render(
            'GqAusUserBundle:Email:newly-assigned-account-manager.html.twig',
            ['userCourse' => $userCourse, 'manager' => $manager]
        );

        $email = $this->emailFactory(
            'Account Manager',
            'jeremuelraymundo@gmail.com',
            'jeremuelraymundo@gmail.com',
            $emailContent
        );

        return $this->mailer->send($email);
    }

    /**
     * @param $userId
     *
     * @return null
     */
    public function sendNotificationEmailToSupervisors($userId)
    {
        $user = $this->userRepository->findOneBy(['id' => $userId]);

        if (!$user) {
            return null;
        }

        $supervisors = $this->all('
            SELECT first_name, last_name, email
            FROM user
            WHERE role_type = ' . self::SUPERVISOR_ROLE_ID . '
        ');

        foreach ($supervisors as $supervisor) {
            $emailContent = $this->templating->render(
                'GqAusUserBundle:Email:supervisor-portfolio.html.twig',
                ['supervisor' => $supervisor, 'user' => $user]
            );

            $email = $this->emailFactory(
                'Supervisor Portfolio',
                'jeremuelraymundo@gmail.com',
                $supervisor['email'],
                $emailContent
            );

            $this->mailer->send($email);
        }
    }

    /**
     * @param $subject
     * @param $from
     * @param $to
     * @param $body
     *
     * @return Swift_Message
     */
    private function emailFactory($subject, $from, $to, $body)
    {
        $message = Swift_Message::newInstance();

        $message->setSubject($subject);
        $message->setFrom('jeremuelraymundo@gmail.com', 'Jem');
        $message->setTo($to);
        $message->setBody($body, 'text/html');

        return $message;
    }
}
