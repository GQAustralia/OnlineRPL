<?php

namespace GqAus\UserBundle\Services\Email;

use Doctrine\ORM\EntityManager;
use GqAus\UserBundle\Services\CustomRepositoryService;
use Swift_Image;
use Swift_Message;

class EmailService extends CustomRepositoryService
{
    CONST SUPERVISOR_ROLE_ID = 5;

    /**
     * @var
     */
    private $templating;
    /**
     * @var
     */
    private $container;

    /**
     * SetNewUserPasswordService constructor.
     *
     * @param EntityManager $em
     * @param $templating
     * @param $mailer
     * @param $container
     */
    public function __construct(EntityManager $em, $mailer, $container)
    {
        parent::__construct($em);

        $this->em = $em;
        $this->mailer = $mailer;
        $this->container = $container;
       // $this->templating =  $this->container->get('templating');
        
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
        if (!$user = $this->userRepository->findOneBy(['id' => $userId])) {
            return null;
        }

        list($message, $imageUrl) = $this->embedImagesToSendNotificationToApplicant(Swift_Message::newInstance());

        $emailContent = $this->container->get('templating')->render(
            'GqAusUserBundle:Email:email-notifications.html.twig',
            ['user' => $user, 'imageUrl' => $imageUrl, 'appUrl' => $this->container->getParameter('applicationUrl')]
        );

       /*  $message = $this->buildEmailStructure(
            $message,
            'Notification',
            $this->container->getParameter('fromEmailAddress'),
            $user->getEmail(),
            $emailContent
        ); */

        return $emailContent;
    }

    /**
     * @param $userId
     * @param $courseName
     *
     * @return null
     */
    public function sendWelcomeEmailToApplicant($userId, $courseName)
    {
        if (!$user = $this->userRepository->findOneBy(['id' => $userId])) {
            return null;
        }

        list($message, $imageUrl) = $this->embedImagesToWelcomeEmailToApplicant(Swift_Message::newInstance());

        $emailContent = $this->container->get('templating')->render(
            'GqAusUserBundle:Email:welcome.html.twig',
            ['user' => $user, 'courseName' => $courseName, 'imageUrl' => $imageUrl, 'appUrl' => $this->container->getParameter('applicationUrl')]
        );
       /* $email = $this->buildEmailStructure(
            $message,
            'Welcome to Online RPL',
            $this->container->getParameter('fromEmailAddress'),
            $user->getEmail(),
            $emailContent
        );  */

        return $emailContent;
    }

    /**
     * @param $userId
     * @param $courseCode
     *
     * @return null
     */
    public function notifyApplicantForTheAssignedAccountManager($userId, $courseCode)
    {
        if (!$userCourse = $this->userCourseRepository->findOneBy(['user' => $userId, 'courseCode' => $courseCode])) {
            return null;
        }

        $manager = $this->userRepository->findOneBy(['id' => $userCourse->getManager()]);

        list($message, $imageUrl) = $this->embedImagesOnNotificationOfAssignedAccountManager(Swift_Message::newInstance());

        $imageUrl['avatarDefault'] = $manager->getUserImage();

        $emailContent = $this->container->get('templating')->render(
            'GqAusUserBundle:Email:newly-assigned-account-manager.html.twig',
            ['userCourse' => $userCourse, 'manager' => $manager, 'imageUrl' => $imageUrl, 'appUrl' => $this->container->getParameter('applicationUrl')]
        );

       /*  $message = $this->buildEmailStructure(
            $message,
            'Account Manager',
            $this->container->getParameter('fromEmailAddress'),
            $userCourse->getUser()->getEmail(),
            $emailContent
        ); */

        return $emailContent;
    }

    /**
     * @param $userId
     *
     * @return null
     */
    public function sendNotificationEmailToSupervisors($userId)
    {
        if (!$user = $this->userRepository->findOneBy(['id' => $userId])) {
            return null;
        }

        $supervisors = $this->all('
            SELECT first_name, last_name, email
            FROM user
            WHERE role_type = ' . self::SUPERVISOR_ROLE_ID . '
        ');

        list($message, $imageUrl) = $this->embedImagesOnNotifyingSupervisor(Swift_Message::newInstance());

        foreach ($supervisors as $supervisor) {
            $emailContent = $this->container->get('templating')->render(
                'GqAusUserBundle:Email:supervisor-portfolio.html.twig',
                ['supervisor' => $supervisor, 'user' => $user, 'imageUrl' => $imageUrl, 'appUrl' => $this->container->getParameter('applicationUrl')]
            );

            $message = $this->buildEmailStructure(
                $message,
                'Supervisor Portfolio',
                $this->container->getParameter('fromEmailAddress'),
                $supervisor['email'],
                $emailContent
            );

            $this->mailer->send($message);
        }
    }

    /**
     * @param Swift_Message $message
     * @param $subject
     * @param $from
     * @param $to
     * @param $emailContent
     *
     * @return Swift_Message
     */
    private function buildEmailStructure(Swift_Message $message, $subject, $from, $to, $emailContent)
    {
        $message->setSubject($subject);
        $message->setFrom($from);
        $message->setTo($to);
        $message->setBody($emailContent, 'text/html');

        return $message;
    }

    /**
     * @param Swift_Message $message
     *
     * @return array
     */
    private function embedDefaultEmailImages(Swift_Message $message)
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

        return [$message, $emailImages];
    }

    /**
     * @param Swift_Message $message
     *
     * @return array
     */
    private function embedImagesToSendNotificationToApplicant(Swift_Message $message)
    {
        list($message, $emailImages) = $this->embedDefaultEmailImages($message);

        $emailImages['takeMeThere'] = $message->embed(Swift_Image::fromPath(__DIR__ . '/../../../../../web/public/ui/img/btn_take-me-there.png'));
        $emailImages['iconEnvelope'] = $message->embed(Swift_Image::fromPath(__DIR__ . '/../../../../../web/public/ui/img/icon-envelope.png'));
        $emailImages['gqaOnlineRplSvg'] = $message->embed(Swift_Image::fromPath(__DIR__ . '/../../../../../web/public/ui/img/gqa-online-rpl.svg'));

        return [$message, $emailImages];
    }

    /**
     * @param Swift_Message $message
     *
     * @return array
     */
    private function embedImagesToWelcomeEmailToApplicant(Swift_Message $message)
    {
        list($message, $emailImages) = $this->embedDefaultEmailImages($message);

        $emailImages['gqaOnlineRplSvg'] = $message->embed(Swift_Image::fromPath(__DIR__ . '/../../../../../web/public/ui/img/gqa-online-rpl.svg'));
        $emailImages['welcomeBanner'] = $message->embed(Swift_Image::fromPath(__DIR__ . '/../../../../../web/public/ui/img/email-welcome-banner.jpg'));

        return [$message, $emailImages];
    }

    /**
     * @param Swift_Message $message
     *
     * @return array
     */
    private function embedImagesOnNotificationOfAssignedAccountManager(Swift_Message $message)
    {
        list($message, $emailImages) = $this->embedDefaultEmailImages($message);

        $emailImages['takeMeThere'] = $message->embed(Swift_Image::fromPath(__DIR__ . '/../../../../../web/public/ui/img/btn_take-me-there.png'));
        $emailImages['welcomeBanner'] = $message->embed(Swift_Image::fromPath(__DIR__ . '/../../../../../web/public/ui/img/email-welcome-banner.jpg'));
        $emailImages['gqaOnlineRplSvg'] = $message->embed(Swift_Image::fromPath(__DIR__ . '/../../../../../web/public/ui/img/gqa-online-rpl.svg'));

        return [$message, $emailImages];
    }

    /**
     * @param Swift_Message $message
     *
     * @return array
     */
    private function embedImagesOnNotifyingSupervisor(Swift_Message $message)
    {
        list($message, $emailImages) = $this->embedDefaultEmailImages($message);

        $emailImages['takeMeThere'] = $message->embed(Swift_Image::fromPath(__DIR__ . '/../../../../../web/public/ui/img/btn_take-me-there.png'));
        $emailImages['iconUser'] = $message->embed(Swift_Image::fromPath(__DIR__ . '/../../../../../web/public/ui/img/icon-user.png'));
        $emailImages['gqaOnlineRplSvg'] = $message->embed(Swift_Image::fromPath(__DIR__ . '/../../../../../web/public/ui/img/gqa-online-rpl.svg'));

        return [$message, $emailImages];
    }
}
