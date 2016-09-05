<?php

namespace GqAus\HomeBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;
use GqAus\UserBundle\Entity\UserCourseUnits;

class ApiService
{

    
    private $container;
    
    private $guzzleService;
    
    private $xmlService;
    
    public function __construct($container, $guzzleService, $xmlService) 
    {
        $this->container = $container;
        $this->guzzleService = $guzzleService;
        $this->xmlService = $xmlService;
        
    } 
    
   /**
    * Access the API endpoints
    * 
    * @param string $endPoint
    * @param array $params
    * @param string $method
    * @return array
    */
    public function accessAPI($endPoint, array $params = null, $method = "POST" )
    {
        $apiUrl = $this->container->getParameter('apiUrl'). $endPoint;

        if ($params) {
            $response = $this->guzzleService->request($method, $apiUrl, [
                            'query' => $params
                            ]);
        } else {
            $response = $this->guzzleService->request($method, $apiUrl);
        }

        $result = $response->getBody();
        return $this->convertXMLToArray($result);
    }
    
    /**
     * Convert the XML results to array
     * 
     * @param string $data
     * @return array
     */
    private function convertXMLToArray($data)
    {
        
        return $this->xmlService->xml2array($data);
    }
    

}
