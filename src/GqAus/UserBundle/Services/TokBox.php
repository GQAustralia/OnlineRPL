<?php

namespace GqAus\UserBundle\Services;

use GqAus\UserBundle\Entity\Room;

class TokBox
{

    /**
     * @var Object
     */
    private $em;

    /**
     * Constructor
     * @param object $em
     */
    public function __construct($em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository('GqAusUserBundle:Room');
    }

    /**
     * Function to get room
     * @param int $roomId
     * return array
     */
    public function getRoom($roomId)
    {
        return $this->repository->find($roomId);
    }

    /**
     * Function to update room
     * @param int $id
     * @param int $userId
     * return array
     */
    public function updateRoom($id, $userId)
    {
        $room = $this->repository->find($id);
        $room->setApplicant($userId);
        $this->em->persist($room);
        $this->em->flush();
        return $room->getSession();
    }

    /**
     * Function to create a room for video communication.
     * @param int $sessionId
     * @param int $userId
     * @param int $applicantID
     *  return integer
     */
    public function createRoom($sessionId, $userId, $applicantID)
    {
        $room = new Room();
        $room->setAssessor($userId);
        $room->setSession($sessionId);
        $room->setApplicant($applicantID);
        $this->em->persist($room);
        $this->em->flush();
        return $room->getId();
    }

    /**
     * Function to check room exists
     * @param int $assessorId
     * @param int $applicantID
     * return array
     */
    public function isRoomExists($assessorId, $applicantID)
    {
        return $this->repository->findOneBy(array('assessor' => $assessorId, 'applicant' => $applicantID));
    }

}
