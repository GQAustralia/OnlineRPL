<?php

namespace GqAus\UserBundle\Services\Email;

use Doctrine\ORM\EntityManager;
use GqAus\UserBundle\Services\CustomRepositoryService;
use Swift_Image;
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

        list($message, $imageUrl) = $this->buildEmailImages(Swift_Message::newInstance());

        $emailContent = $this->templating->render(
            'GqAusUserBundle:Email:email-notifications.html.twig',
            ['user' => $user, 'imageUrl' => $imageUrl]
        );

         $email = $this->emailFactory(
             $message,
             'Notification',
             'jeremuelraymundo@gmail.com',
             'jeremuelraymundo@gmail.com',
             $emailContent
         );

        return $this->mailer->send($message);
    }

    public function sendWelcomeEmailToApplicant($userId, $courseName)
    {
        $user = $this->userRepository->findOneBy(['id' => $userId]);

        if (!$user) {
            return null;
        }

        list($message, $imageUrl) = $this->buildEmailImages(Swift_Message::newInstance());


        $emailContent = $this->templating->render(
            'GqAusUserBundle:Email:welcome.html.twig',
            ['user' => $user, 'courseName' => $courseName, 'imageUrl' => $imageUrl]
        );

        $email = $this->emailFactory(
            $message,
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
    private function emailFactory($message, $subject, $from, $to, $emailContent)
    {
        $message->setSubject($subject);
        $message->setFrom('jeremuelraymundo@gmail.com');
        $message->setTo($to);
        $message->setBody($emailContent, 'text/html');

        return $message;
    }

    private function buildEmailImages(Swift_Message $message)
    {
        $emailImages = [];
        $emailImages['youtube'] = $message->embed(Swift_Image::fromPath(__DIR__ . '/../../../../../web/public/ui/img/email-template/social_media/youtube.png'));
        $emailImages['facebook'] = $message->embed(Swift_Image::fromPath(__DIR__ . '/../../../../../web/public/ui/img/email-template/social_media/facebook.png'));
        $emailImages['twitter'] = $message->embed(Swift_Image::fromPath(__DIR__ . '/../../../../../web/public/ui/img/email-template/social_media/twitter.png'));
        $emailImages['linkedin'] = $message->embed(Swift_Image::fromPath(__DIR__ . '/../../../../../web/public/ui/img/email-template/social_media/linkedin.png'));
        $emailImages['google'] = $message->embed(Swift_Image::fromPath(__DIR__ . '/../../../../../web/public/ui/img/email-template/social_media/google.png'));
        $emailImages['instagram'] = $message->embed(Swift_Image::fromPath(__DIR__ . '/../../../../../web/public/ui/img/email-template/social_media/instagram.png'));
        $emailImages['allAwards'] = $message->embed(Swift_Image::fromPath(__DIR__ . '/../../../../../web/public/ui/img/awards/all-awards.png'));
        $emailImages['aboutGqa'] = $message->embed(Swift_Image::fromPath(__DIR__ . '/../../../../../web/public/ui/img/about-gqa.png'));
        $emailImages['communication'] = $message->embed(Swift_Image::fromPath(__DIR__ . '/../../../../../web/public/ui/img/email-template/communication.png '));
        $emailImages['emailFooterBg'] = $message->embed(Swift_Image::fromPath(__DIR__ . '/../../../../../web/public/ui/img/email-footer-bg.jpg'));

        $emailImages['takeMeThere'] = $message->embed(Swift_Image::fromPath(__DIR__ . '/../../../../../web/public/ui/img/btn_take-me-there.png'));
        $emailImages['iconEnvelope'] = $message->embed(Swift_Image::fromPath(__DIR__ . '/../../../../../web/public/ui/img/icon-envelope.png'));
        $emailImages['gqaOnlineRplSvg'] = $message->embed(Swift_Image::fromPath(__DIR__ . '/../../../../../web/public/ui/img/gqa-online-rpl.svg'));


        return [$message, $emailImages];
    }
}
