<?php

namespace GqAus\UserBundle\Controller;

use Swift_Image;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SampleEmailController extends Controller
{
    public function sendEmailAction(Request $request)
    {
        $response = $this->get('HttpResponsesService');

        $email = $this->get('EmailService');

        // $email->sendNotificationToApplicant(61);
        // $email->sendNotificationEmailToSupervisors(61);
        // $email->sendWelcomeEmailToApplicant(61, 'Certificate IV in Beauty Therapy');
        // $email->notifyApplicantForTheAssignedAccountManager(37, 'SHB40115');
        return $response->fractal()->respondSuccess();
    }
}
