<?php

namespace GqAus\UserBundle\Services\UserCourse;

use Doctrine\ORM\EntityManager;

class FileService
{

    private $em;
    
    public function __construct($em)
    {
        $this->em = $em;
    }
    
    /**
     * Get a specific file type from an file object array
     * 
     * @param array $files
     * @param string $type
     * @return boolean | string
     */
    public function getFileType($files, $type = "EnrollmentForm")
    {
        foreach ($files as $file) {
            if ($file->getType() == $type) {
                return $file->getPath();
            }
        }
        return false;
    }
    
    public function getFile($courseId, $type = "EnrollmentForm" )
    {
        
        $fileEm = $this->em->getRepository('GqAusUserBundle:CourseFile');
        $file = $fileEm->findOneBy(array('courseVal' => $courseId, 'type' => $type) );
        if ($file) {
            return $file;
        } else {
            return false;
        }
    }
    

}