<?php

namespace GqAus\UserBundle\Services;

use Doctrine\ORM\EntityManager;
use GqAus\UserBundle\Entity\Evidence\File;
use GqAus\UserBundle\Entity\Evidence\Image;
use GqAus\UserBundle\Entity\Evidence\Audio;
use GqAus\UserBundle\Entity\Evidence\Video;
use GqAus\UserBundle\Entity\Evidence\Text;

class EvidenceService
{
    private $userId;
    private $repository;
    private $currentUser;
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
        $this->userId = $session->get('user_id');
        $this->repository = $em->getRepository('GqAusUserBundle:User');
        $this->currentUser = $this->getCurrentUser();
        $this->container = $container;
    }

    public function getCurrentUser()
    {
        return $this->repository->findOneById($this->userId);
    }
    
    public function saveEvidence($evidences, $data)
    {
		$i = 0;
        foreach ($evidences as $evidence) {
			$mimeType = $data['file'][$i]->getClientMimeType();
			$size = $data['file'][$i]-> getClientSize();
			$size = $this->fileSize($size);
			$pos = strpos($mimeType, '/');
			$type = substr($mimeType,0,$pos);
			switch ($type) {
				case 'image':
					$fileObj = new Image();
					break;
				case 'audio':
					$fileObj = new Audio();
					break;
				case 'video':
					$fileObj = new Video();
					break;
				case 'text':
					$fileObj = new File();
					break;
				case 'application':
					$fileObj = new File();
					break;
				default :
					$fileObj = new File();
					break;
			}
            $fileObj->setPath($evidence['aws_file_name']);
            $fileObj->setName($evidence['orginal_name']);
            $fileObj->setUser($this->currentUser);
			$fileObj->setSize($size);
            $fileObj->setUnit($data['hid_unit']);        
            $this->em->persist($fileObj);
            $this->em->flush();
			$i++;
        }
		
		if (!empty($data['self_assessment'])) {
			$textObj = new Text();
			$textObj->setContent($data['self_assessment']);
			$textObj->setUnit($data['hid_unit']);
			$textObj->setUser($this->currentUser);
			$this->em->persist($textObj);
            $this->em->flush();
		}
    }
	
	public function fileSize($size)
	{
		if ($size >= 1073741824) {
		  $fileSize = round($size / 1024 / 1024 / 1024) . 'GB';
		} elseif ($size >= 1048576) {
			$fileSize = round($size / 1024 / 1024) . 'MB';
		} elseif($size >= 1024) {
			$fileSize = round($size / 1024) . 'KB';
		} else {
			$fileSize = $size . ' bytes';
		}
		return $fileSize;
	}
    
	public function saveExistingEvidence($request)
	{
		$evidences = $request->get('evidence-file');
		$unitId = $request->get('select_hid_unit');
			
		$imgObj = $this->em->getRepository('GqAusUserBundle:Evidence\Image');
		$audioObj = $this->em->getRepository('GqAusUserBundle:Evidence\Audio');
		$videoObj = $this->em->getRepository('GqAusUserBundle:Evidence\Video');
		$fileObj = $this->em->getRepository('GqAusUserBundle:Evidence\File');
		$textObj = $this->em->getRepository('GqAusUserBundle:Evidence\Text');
		
		if (!empty($evidences)) {
			foreach ($evidences as $key => $val) {
				if (!empty($val)) {
					switch ($key) {
						case 'image':
							$evidenceObj = $imgObj->find($val);
							$newObj = new Image();
							break;
						case 'audio':
							$evidenceObj = $audioObj->find($val);
							$newObj = new Audio();
							break;
						case 'video':
							$evidenceObj = $videoObj->find($val);
							$newObj = new Video();
							break;
						case 'file':
							$evidenceObj = $fileObj->find($val);
							$newObj = new File();
							break;
						case 'text':
							$evidenceObj = $textObj->find($val);
							$newObj = new Text();
							break;
						default :
							$evidenceObj = $fileObj->find($val);
							$newObj = new File();
							break;
					}
					if (!empty($evidenceObj)) {
						if ($key == 'text') {
							$textObj->setContent($data['self_assessment']);
						} else {
							$newObj->setPath($evidenceObj->getPath());
							$newObj->setName($evidenceObj->getName());
							$newObj->setSize($evidenceObj->getSize());
						}
						$newObj->setUser($this->currentUser);					
						$newObj->setUnit($unitId);
						$this->em->persist($newObj);
						$this->em->flush();
					}
				}//if
			}//foreach
		}
	}
}