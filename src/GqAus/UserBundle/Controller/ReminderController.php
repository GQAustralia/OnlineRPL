<?php

namespace GqAus\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use \DateTime;

class ReminderController extends Controller
{

    /**
     * Function to view reminders
     * return $result array
     */
    public function viewAction(Request $request)
    {
        $userService = $this->get('UserService');
        $userId = $userService->getCurrentUser()->getId();
        $reminders['todoReminders'] = $userService->getTodoReminders($userId);
        $reminders['completedReminders'] = $userService->getCompletedReminders($userId);
        $now = new DateTime('now');
        return $this->render(
                'GqAusUserBundle:Reminder:view.html.twig', array('reminders' => $reminders, 'today' => $now->format('Y-m-d H:i:s'))
        );
    }

    /**
     * Function to update reminders
     * return $result string
     */
    public function updateAction(Request $request)
    {
        $id = $this->getRequest()->get('rmid');
        $flag = $this->getRequest()->get('flag');
        $this->get('UserService')->updateReminderStatus($id, $flag);
        echo 'success';
        exit;
    }

}
