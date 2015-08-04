<?php

namespace GqAus\UserBundle\Services;
use GqAus\UserBundle\Entity\Room;

class TokBox {

    /**
     * @var Object
     */
    private $em;

    /**
     * Constructor
     */
    public function __construct($em) {
        $this->em = $em;
        $this->repository = $em->getRepository('GqAusUserBundle:Room');
    }

    public function getRoom($roomId) {
        return $this->repository->find($roomId);
    }

    public function updateRoom($id, $user_id) {
        $room = $this->repository->find($id);
        $room->setApplicant($user_id);
        $this->em->persist($room);
        $this->em->flush();
        return $room->getSession();
    }

    /**
     *  function to create a room for video communication.
     *  @return int
     */
    public function createRoom($sessionId, $user_id, $applicantID) {
        $room = new Room();
        $room->setAssessor($user_id);
        $room->setSession($sessionId);
        $room->setApplicant($applicantID);
        $this->em->persist($room);
        $this->em->flush();
        return $room->getId();
    }

    public function isRoomExists($assessorId, $applicantID) {
        return $this->repository->findOneBy(array('assessor' => $assessorId, 'applicant' => $applicantID));
    }

}
