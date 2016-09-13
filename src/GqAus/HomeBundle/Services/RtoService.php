<?php

namespace GqAus\HomeBundle\Services;


class RtoService
{

    /**
     * @var Object
     */
    private $container;

    private $apiService;

    /**
     * Constructor
     * @param object $em
     * @param object $container
     */
    public function __construct($em, $container, $apiService)
    {
        $this->em = $em;
        $this->container = $container;
        $this->apiService = $apiService;
        
    }

    /**
     * Function to get RTO details
     * 
     * @param string $qcode
     * @param int $uid
     * return array
     */
    public function findByCode($code)
    {
        return $this->em->getRepository('GqAusUserBundle:User')
                ->findOneBy(array('last_name' => $code));
    }

    /**
     * Function to get the enrollment for for 
     * 
     * @param string $code
     * @return boolean|string
     */
    public function findRTOEnrollmentForm($code)
    {
         
        if ($code != "") {
            // get the RTO enrollment form from Qual Platform
            $rtoDetails = $this->apiService->accessAPI("rtodetails", array('code' => $code));
            if (isset($rtoDetails['qualifications']['enrollment_form'])) {
                if ($rtoDetails['qualifications']['enrollment_form']) {
                    return $rtoDetails['qualifications']['enrollment_form'];
                } else {
                    return false;
                }         
                
            } else {
                return false;
            }
            
        } else {
            return false;
        }
    }
    
   
    

}
