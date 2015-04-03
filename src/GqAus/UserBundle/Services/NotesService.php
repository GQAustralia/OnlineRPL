<?php

namespace GqAus\UserBundle\Services;

use Doctrine\ORM\EntityManager;
use GqAus\UserBundle\Entity\Note;
use Symfony\Component\HttpFoundation\Response;
use DateTime;
class NotesService
{

    private $em;    
    /**
     * @var Object
     */
    private $container;

    /**
     * Constructor
     */
    public function __construct($em, $container)
    {
        $this->em = $em;
        $session = $container->get('session');
        $this->container = $container;
    }

    /**
     * Save Notes
     * Input : data
     * Output: boolean
     */
    public function saveNotes($data)
    {
        if (!empty($data['unit_notes'])) {
            $notesObj = new Note();
            $notesObj->setUnitID($data['note_unit_id']);
            $notesObj->setNote($data['unit_notes']);
            $notesObj->setType($data['unit_note_type']);
            $dateObj = new DateTime('now');
            $notesObj->setCreated($dateObj);
            $this->em->persist($notesObj);
            $this->em->flush();            
            return "success";
        } else
            return "error";
    }
    
    /**
    * Function to get notes
    * return array 
    */
    public function getUnitNotes($unitId, $userType)
    {
        $return = array();
        $notesObj = $this->em->getRepository('GqAusUserBundle:Note');
        $unitNotes = $notesObj->findBy(array(
            'unitID' => $unitId,
            'type' => $userType), array('id' => 'DESC'));        
        if ( $unitNotes ) {
           $return = $unitNotes;       
        }
        return $return;
    }

}
