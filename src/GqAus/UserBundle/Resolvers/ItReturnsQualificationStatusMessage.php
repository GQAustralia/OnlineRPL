<?php

namespace GqAus\UserBundle\Resolvers;

trait    ItReturnsQualificationStatusMessage
{
    /**
     * @param $status
     * @return mixed
     */
    public function getQualificationStatus($status)
    {
        $statusList =[
            '0' => 'RPL Completed',
            '1' => 'Welcome Call Completed Docs Sent',
            '2' => 'Portfoilo Sent To Remote Assessor',
            '3' => 'Assessment Results Received C',
            '4' => 'Welcome Call VM Docs Sent',
            '5' => 'Partial Evidence Received',
            '6' => 'Evidence Being Reviewed',
            '7' => 'Evidence Feedback Provided',
            '8' => 'Needs Follow Up With Candidate',
            '9' => 'All Evidence Received',
            '10' => 'Competency Conversation Needed',
            '11' => 'Competency Conversation Booked',
            '12' => 'Competency Conversation Completed',
            '13' => 'Gap Training Required',
            '14' => 'Assessment Feedback Required NYC',
            '15' => 'Portfolio Submitted To RTO',
            '16' => 'Certificate Received By GQ',
            '17' => 'On Hold'
        ];

        return $statusList[$status];
    }
}
