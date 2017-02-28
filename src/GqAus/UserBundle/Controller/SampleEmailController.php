<?php

namespace GqAus\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SampleEmailController extends Controller
{
    public function sendEmailAction(Request $request)
    {
        $response = $this->get('HttpResponsesService');

        $email = $this->get('EmailService');

      // $result = $email->sendNotificationToApplicant(61);
        $email->sendWelcomeEmailToApplicant(61, 'Certificate IV in Beauty Therapy');

        //$email->sendNotificationEmailToSupervisors(61);
       //
       // $email->notifyApplicantForTheAssignedAccountManager(37, 'SHB40115');

        return $response->fractal()->respondSuccess();
    }
}
