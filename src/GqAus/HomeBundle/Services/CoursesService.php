<?php

namespace GqAus\HomeBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;
use GqAus\UserBundle\Entity\UserCourseUnits;
use GuzzleHttp\Exception\ServerException;

class CoursesService
{

    private $repository;

    /**
     * @var Object
     */
    private $container;

    /**
     * @var Object
     */
    private $mailer;

    /**
     * @var Object
     */
    private $guzzleService;

    /**
     * Constructor
     * @param object $em
     * @param object $container
     * @param object $mailer
     * @param object $guzzleService
     */
    public function __construct($em, $container, $mailer, $guzzleService)
    {
        $this->em = $em;
        $this->repository = $em->getRepository('GqAusUserBundle:User');
        $this->container = $container;
        $this->mailer = $mailer;
        $this->guzzleService = $guzzleService;
    }

    /**
     * Function to get courses details
     * @param string $qcode
     * @param int $uid
     * return array
     */
    public function getCourseDetails($qcode, $uid)
    {
        return $this->em->getRepository('GqAusUserBundle:UserCourses')
                ->findOneBy(array('courseCode' => $qcode, 'user' => $uid));
    }

    /**
     * Function to get courses info
     * @param int $id
     * return array
     */
    public function getCoursesInfo($id)
    {
        $courseInfo = $this->fetchRequest($id);
        if (!empty($courseInfo)) {
            if (!empty($courseInfo['details'])) {
                $courseInfo['details'] = html_entity_decode($courseInfo['details']);
            }
        }        
        return array('courseInfo' => $courseInfo);
    }
    /**
     * Function to get package rules
     * @param int $id
     * return array
     */
    public function getPackagerulesInfo($id)
    {
        $packageInfo = $this->fetchQualificationRequest($id);
        $packageInfoPackage =  null;
        if (!empty($packageInfo)) {
            if (!empty($packageInfo['packaging'])) {
                $packageInfoPackage = htmlspecialchars_decode($packageInfo['packaging']);
            }
        }        
        return $packageInfoPackage;
    }
    
    /**
     * Function to get course Info
     * @param int $id
     * return array
     */
    public function getCourseInfo($id)
    {
    	$courseInfo = $this->fetchQualificationRequest($id);
    	if (!empty($courseInfo)) {
    		if (!empty($courseInfo['qualification'])) {
    			$courseInfo = htmlspecialchars_decode($courseInfo['qualification']);
    		}
    	}
    	return $courseInfo;
    }
    
     /**
     * Function to get Unit info
     * @param int $id
     * return array
     */
    public function getUnitInfo($id)
    {   
        $unitInfo = $this->fetchUnitRequest($id);
       
        if (!empty($unitInfo)) {
            if (!empty($unitInfo['details'])) {
                $unitInfo['details'] = html_entity_decode($courseInfo['details']);
            }
        }        
        return array('unitInfo' => $unitInfo);
    }

    /**
     * Function to get courses info
     * @param int $id
     * return array
     */
    public function getUserCoursesInfo($id)
    {
        $courseInfo = $this->fetchCourseRequest($id);
        if (!empty($courseInfo)) {
            if (!empty($courseInfo['details'])) {
                $courseInfo['details'] = html_entity_decode($courseInfo['details']);
            }
        }        
        return array('courseInfo' => $courseInfo);
    }
    /**
     * Function to api request for courses
     * @param int $id
     * return array
     */
    public function fetchRequest($id)
    {
        $session = new Session();
        $start = $session->get('start');
        $apiToken = $session->get('api_token');
        if (!empty($start) && !empty($apiToken)) {
            if ($start + 60 < time()) {
                $session->set('api_token', '');
                $session->set('start', '');
            }
        } else {
            $session->set('start', time());
        }
        $postFields = array('code' => $id);
        $apiToken = $session->get('api_token');
        if (!empty($apiToken)) {
            $postFields['token'] = $apiToken;
            $result = $this->accessAPI($postFields);
        } else if (empty($apiToken)) {
            $result = $this->accessAPI($postFields);
            $postFields['token'] = $token = $this->getTokenGenerated($result);
            $session->set('api_token', $token);
            $session->set('start', time());
            if ($token) {
                $result = $this->accessAPI($postFields);
            }
        }

        if (!empty($result)) {
            $qualificationUnits = $this->xml2array($result);
        }
        return (!empty($qualificationUnits['qualification'])) ? $qualificationUnits['qualification'] : array();
    }
    /**
     * Function to api request for courses
     * @param int $id
     * return array
     */
    public function fetchQualificationRequest($id)
    {
        $session = new Session();
        $start = $session->get('start');
        $apiToken = $session->get('api_token');
        if (!empty($start) && !empty($apiToken)) {
            if ($start + 60 < time()) {
                $session->set('api_token', '');
                $session->set('start', '');
            }
        } else {
            $session->set('start', time());
        }
        $postFields = array('code' => $id);
        $apiToken = $session->get('api_token');
        if (!empty($apiToken)) {
            $postFields['token'] = $apiToken;
            $result = $this->accessQualificationAPI($postFields);
        } else if (empty($apiToken)) {
            $result = $this->accessQualificationAPI($postFields);
            $postFields['token'] = $token = $this->getTokenGenerated($result);
            $session->set('api_token', $token);
            $session->set('start', time());
            if ($token) {
                $result = $this->accessQualificationAPI($postFields);
            }
        }

        if (!empty($result)) {
            $qualificationUnits = $this->xml2array($result);
        }
        return (!empty($qualificationUnits['qualification'])) ? $qualificationUnits['qualification'] : array();
    }
    /**
     * Function to api request for courses
     * @param int $id
     * return array
     */
    public function fetchCourseRequest($id)
    {
        $session = new Session();
        $start = $session->get('start');
        $apiToken = $session->get('api_token');
        if (!empty($start) && !empty($apiToken)) {
            if ($start + 60 < time()) {
                $session->set('api_token', '');
                $session->set('start', '');
            }
        } else {
            $session->set('start', time());
        }
        $postFields = array('code' => $id);
        $apiToken = $session->get('api_token');
        if (!empty($apiToken)) {
            $postFields['token'] = $apiToken;
            $result = $this->accessCourseAPI($postFields);
        } else if (empty($apiToken)) {
            $result = $this->accessCourseAPI($postFields);
            $postFields['token'] = $token = $this->getTokenGenerated($result);
            $session->set('api_token', $token);
            $session->set('start', time());
            if ($token) {
                $result = $this->accessCourseAPI($postFields);
            }
        }

        if (!empty($result)) {         
            $qualificationUnits = $this->xml2array($result);
        }       
//        $myfile = fopen("newfile.txt", "r") or die("Unable to open file!");
//        $qualificationUnits =  json_decode(fread($myfile,filesize("newfile.txt")),true);
//        dump($qualificationUnits); 
//        fclose($myfile);
//        exit();
        return (!empty($qualificationUnits['package'])) ? $qualificationUnits['package'] : array();
    }
    /**
     * Function to api request for unit
     * @param int $id
     * return array
     */
    public function fetchUnitRequest($id)
    {
        $session = new Session();
        $start = $session->get('start');
        $apiToken = $session->get('api_token');
        if (!empty($start) && !empty($apiToken)) {
            if ($start + 60 < time()) {
                $session->set('api_token', '');
                $session->set('start', '');
            }
        } else {
            $session->set('start', time());
        }
        $postFields = array('code' => $id);
        $apiToken = $session->get('api_token');
        if (!empty($apiToken)) {
            $postFields['token'] = $apiToken;
            $result = $this->accessUnitAPI($postFields);
        } else if (empty($apiToken)) {
            $result = $this->accessUnitAPI($postFields);
            $postFields['token'] = $token = $this->getTokenGenerated($result);
            $session->set('api_token', $token);
            $session->set('start', time());
            if ($token) {
                $result = $this->accessUnitAPI($postFields);
            }
        }
        
        if (!empty($result)) {
            $qualificationUnits = $this->xml2array($result);
        }
        
        return (!empty($qualificationUnits['unit'])) ? $qualificationUnits['unit'] : array();
    }
    /**
     * Function to access API
     * @param string $fieldString
     * return array
     */
    public function accessCourseAPI($fieldString)
    {
        $apiUrl = $this->container->getParameter('apiUrl');
        $apiAuthUsername = $this->container->getParameter('apiAuthUsername');
        $apiAuthPassword = $this->container->getParameter('apiAuthPassword');
        $url = $apiUrl . "unitsbyqualifications";
        
        try {
        				$response = $this->guzzleService->request('POST', $url, [
						        		'auth' => [$apiAuthUsername, $apiAuthPassword],
						        		'query' => $fieldString
						        		]);
        }catch (ServerException $e) {
        	
        				$response = $e->getResponse(true);
        }
        
        if ($response->getStatusCode() != 200) {
        	return null;
        }
        
        $result = $response->getBody();
        return $result;
    }
    /**
     * Function to access API
     * @param string $fieldString
     * return array
     */
    public function accessQualificationAPI($fieldString)
    {
        $apiUrl = $this->container->getParameter('apiUrl');
        $apiAuthUsername = $this->container->getParameter('apiAuthUsername');
        $apiAuthPassword = $this->container->getParameter('apiAuthPassword');
        $url = $apiUrl . "qualifications";
        
        try {
        				$response = $this->guzzleService->request('POST', $url, [
						        		'auth' => [$apiAuthUsername, $apiAuthPassword],
						        		'query' => $fieldString
						        		]);
        }catch (ServerException $e) {
        	 
        				$response = $e->getResponse(true);
        }
        
        if ($response->getStatusCode() != 200) {
        	return null;
        }
        
        $result = $response->getBody();
        return $result;
    }
    /**
     * Function to access API
     * @param string $fieldString
     * return array
     */
    public function accessAPI($fieldString)
    {
        $apiUrl = $this->container->getParameter('apiUrl');
        $apiAuthUsername = $this->container->getParameter('apiAuthUsername');
        $apiAuthPassword = $this->container->getParameter('apiAuthPassword');
        $url = $apiUrl . "qualificationunits";

        try {
				        $response = $this->guzzleService->request('POST', $url, [
				        			'auth' => [$apiAuthUsername, $apiAuthPassword],
				        			'query' => $fieldString
				        			]);
        }catch (ServerException $e) {
        
        				$response = $e->getResponse(true);
        }
        
        if ($response->getStatusCode() != 200) {
        	return null;
        }
        
        $result = $response->getBody();
        return $result;
    }
    /**
     * Function to access unit API
     * @param string $fieldString
     * return array
     */
    public function accessUnitAPI($fieldString)
    {   
        $apiUrl = $this->container->getParameter('apiUrl');
        $apiAuthUsername = $this->container->getParameter('apiAuthUsername');
        $apiAuthPassword = $this->container->getParameter('apiAuthPassword');
        $url = $apiUrl . "units";
      
        try {
        				$response = $this->guzzleService->request('POST', $url, [
					        		'auth' => [$apiAuthUsername, $apiAuthPassword],
					        		'query' => $fieldString
					        		]);
        }catch (ServerException $e) {
        
        				$response = $e->getResponse(true);
        }
        
        if ($response->getStatusCode() != 200) {
        	return null;
        }
        
        $result = $response->getBody();
        return $result;
    }
    /**
     * Function to get the Required Units Count is having both core & elective units
     * @param type $courseCode
     * @return integer
     */
    public function getReqUnitsForCourseByCourseId($courseCode){
        $params = array('code' => $courseCode);
        $totalReqUnits = 0;
        $apiUrl = $this->container->getParameter('apiUrl');
        $apiAuthUsername = $this->container->getParameter('apiAuthUsername');
        $apiAuthPassword = $this->container->getParameter('apiAuthPassword');
        $url = $apiUrl . "unitsbyqualifications";

        try {
        				$response = $this->guzzleService->request('POST', $url, [
						        		'auth' => [$apiAuthUsername, $apiAuthPassword],
						        		'query' => $params
						        		]);
        }catch (ServerException $e) {
    								$response = $e->getResponse(true);
    				}

								if ($response->getStatusCode() != 200) {
									return array();
								}
								
        $result = $response->getBody();
        if (!empty($result)) {         
            $qualificationUnits = $this->xml2array($result);
        }      
        $unitsCount = array();
        if(!empty($qualificationUnits['package'])){
        				if (!empty($qualificationUnits['package']['Units']['Core'])) {
            				$unitsCount['core'] = count($qualificationUnits['package']['Units']['Core']['unit']);
        				}
        				if (!empty($qualificationUnits['package']['Units']['Elective'])) {
           				 $unitsCount['elective'] = $qualificationUnits['package']['Units']['Elective']['validation']['requirement'];
        				}
        }
        return $unitsCount;
    }

    /**
     * Function to generate api token
     * @param string $result
     * return string
     */
    public function getTokenGenerated($result)
    {
        $token = false;
        $p = xml_parser_create();
        xml_parse_into_struct($p, $result, $vals, $index);
        xml_parser_free($p);
        if (isset($vals[0]['tag']) && isset($vals[0]['value'])) {
            if (strtoupper($vals[0]['tag']) == 'TOKEN') {
                $token = $vals[0]['value'];
                $token = base64_decode($token);
            }
        }
        return $token;
    }

    /**
     * Function to convert the given XML text to an array in the XML structure.
     * @param string $contents
     * @param int $getAttributes
     * @param string $priority
     * return string
     */
    function xml2array($contents, $getAttributes = 1, $priority = 'tag')
    {        
        if (!$contents) {
            return array();
        }

        if (!function_exists('xml_parser_create')) {
            return array();
        }

        //Get the XML parser of PHP - PHP must have this module for the parser to work
        $parser = xml_parser_create('');
        xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8");
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
        xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
        xml_parse_into_struct($parser, trim($contents), $xmlValues);
        xml_parser_free($parser);

        if (!$xmlValues) {
            return;
        }
        
        //Initializations
        $xmlArray = array();
        $parents = array();
        $openedTags = array();
        $arr = array();

        $current = &$xmlArray; //Refference
        //Go through the tags.
        $repeatedTagIndex = array(); //Multiple tags with same name will be turned into an array
        foreach ($xmlValues as $data) {
            unset($attributes, $value); //Remove existing values, or there will be trouble
            //This command will extract these variables into the foreach scope
            // tag(string), type(string), level(int), attributes(array).
            extract($data); //We could use the array by itself, but this cooler.

            $result = array();
            $attributesData = array();

            if (isset($value)) {
                if ($priority == 'tag') {
                    $result = $value;
                } else {
                    $result['value'] = $value; //Put the value in a assoc array if we are in the 'Attribute' mode
                }
            }

            //Set the attributes too.
            if (isset($attributes) and $getAttributes) {
                foreach ($attributes as $attr => $val) {
                    if ($priority == 'tag') {
                        $attributesData[$attr] = $val;
                    } else {
                        $result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr'
                    }
                }
            }

            //See tag status and do the needed.
            if ($type == "open") {//The starting of the tag '<tag>'
                $parent[$level - 1] = &$current;
                if (!is_array($current) or ( !in_array($tag, array_keys($current)))) { //Insert New tag
                    $current[$tag] = $result;
                    if ($attributesData)
                        $current[$tag . '_attr'] = $attributesData;
                    $repeatedTagIndex[$tag . '_' . $level] = 1;

                    $current = &$current[$tag];
                } else { //There was another element with the same tag name
                    if (isset($current[$tag][0])) {//If there is a 0th element it is already an array
                        $current[$tag][$repeatedTagIndex[$tag . '_' . $level]] = $result;
                        $repeatedTagIndex[$tag . '_' . $level] ++;
                    } else {//This section will make the value an array if multiple tags with the same name appear together
                        $current[$tag] = array($current[$tag], $result); //This will combine the existing item and the new item together to make an array
                        $repeatedTagIndex[$tag . '_' . $level] = 2;

                        if (isset($current[$tag . '_attr'])) { //The attribute of the last(0th) tag must be moved as well
                            $current[$tag]['0_attr'] = $current[$tag . '_attr'];
                            unset($current[$tag . '_attr']);
                        }
                    }
                    $lastItemIndex = $repeatedTagIndex[$tag . '_' . $level] - 1;
                    $current = &$current[$tag][$lastItemIndex];
                }
            } elseif ($type == "complete") { //Tags that ends in 1 line '<tag />'
                //See if the key is already taken.
                if (!isset($current[$tag])) { //New Key
                    $current[$tag] = $result;
                    $repeatedTagIndex[$tag . '_' . $level] = 1;
                    if ($priority == 'tag' and $attributesData)
                        $current[$tag . '_attr'] = $attributesData;
                } else { //If taken, put all things inside a list(array)
                    if (isset($current[$tag][0]) and is_array($current[$tag])) {//If it is already an array...
                        // ...push the new element into that array.
                        $current[$tag][$repeatedTagIndex[$tag . '_' . $level]] = $result;

                        if ($priority == 'tag' and $getAttributes and $attributesData) {
                            $current[$tag][$repeatedTagIndex[$tag . '_' . $level] . '_attr'] = $attributesData;
                        }
                        $repeatedTagIndex[$tag . '_' . $level] ++;
                    } else { //If it is not an array...
                        $current[$tag] = array($current[$tag], $result); //...Make it an array using using the existing value and the new value
                        $repeatedTagIndex[$tag . '_' . $level] = 1;
                        if ($priority == 'tag' and $getAttributes) {
                            if (isset($current[$tag . '_attr'])) { //The attribute of the last(0th) tag must be moved as well
                                $current[$tag]['0_attr'] = $current[$tag . '_attr'];
                                unset($current[$tag . '_attr']);
                            }

                            if ($attributesData) {
                                $current[$tag][$repeatedTagIndex[$tag . '_' . $level] . '_attr'] = $attributesData;
                            }
                        }
                        $repeatedTagIndex[$tag . '_' . $level] ++; //0 and 1 index is already taken
                    }
                }
            } elseif ($type == 'close') { //End of tag '</tag>'
                $current = &$parent[$level - 1];
            }
        }
       
        return($xmlArray);
    }

    /**
     * Function to update unit electives
     * @param int $userId
     * @param int $unitId
     * @param string $courseCode
     * return integer
     */
    public function updateUnitElective($userId, $unitId, $courseCode)
    {
        $status = 1;
        $reposObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits');
        $userUnitObj = $reposObj->findOneBy(array('user' => $userId,
            'unitId' => $unitId,
            'courseCode' => $courseCode));
        if (empty($userUnitObj)) {
            $reposObj = new UserCourseUnits();
            $userObj = $this->em->getRepository('GqAusUserBundle:User')
                ->find($userId);
            $reposObj->setUnitId($unitId);
            $reposObj->setCourseCode($courseCode);
            $reposObj->setStatus(1);
            $reposObj->setElectiveStatus(1);
            $reposObj->setUser($userObj);
            $this->em->persist($reposObj);
        } else {
            $status = $userUnitObj->getElectiveStatus();
            $status = ($status == 1) ? '0' : '1';
            $userUnitObj->setElectiveStatus($status);
            if($status == '0') {
                $userUnitObj->setStatus(0);
                $userUnitObj->setIssubmitted(0);
                $userUnitObj->setFacilitatorstatus(0);
                $userUnitObj->setAssessorstatus(0);
                $userUnitObj->setRtostatus(0);
                
            }
        }
        $this->em->flush();
        $this->em->clear();
        return $status;
    }
    /**
     * Function to get the selected elective units from the candidate to loggedin users in the elective units section 
     * @param type $userId
     * @param type $courseCode
     * @return type
     */
    public function getSelectedElectiveUnits($userId, $courseCode){
        $reposObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits');
        $userCourseUnits = $reposObj->findBy(array('user' => $userId, 'courseCode' => $courseCode, 'electiveStatus' => '1'));
        $courseUnits = array();
        if (!empty($userCourseUnits)) {
            foreach ($userCourseUnits as $units) {
                $courseUnits[trim($units->getUnitId())] = trim($units->getUnitId());
            }
        }
        return $courseUnits;
    }

    /**
     * Function to get elective units
     * @param int $userId
     * @param string $courseCode
     * @param string $type
     * return array
     */
    public function getElectiveUnits($userId, $courseCode, $type='elective')
    {
        $reposObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits');
        $userCourseUnits = $reposObj->findBy(array('user' => $userId, 'courseCode' => $courseCode, 'status' => '1', 'type' => $type));
        $courseUnits = array();
        if (!empty($userCourseUnits)) {
            foreach ($userCourseUnits as $units) {
                $courseUnits[trim($units->getUnitId())] = trim($units->getUnitId());
            }
        }
        return $courseUnits;
    }
    /**
     * Function to get count of core and elective units
     * @param int $userId
     * @param string $courseCode
     * return int
     */
    public function getCoreElectiveUnitsCount($userId, $courseCode,$type)
    {
        $reposObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits');
        $userCourseUnits = $reposObj->findBy(array('user' => $userId,
            'courseCode' => $courseCode,
            'type' => $type));
        $courseUnits = array();
        if (!empty($userCourseUnits)) {
            foreach ($userCourseUnits as $units) {
                $courseUnits[trim($units->getUnitId())] = trim($units->getUnitId());
            }
        }        
        return count($courseUnits);
    }
    /**
     * Function to get applicant unit status
     * @param int $applicantId
     * @param int $unitId
     * @param string $courseCode
     * return array
     */
    public function getUnitStatus($applicantId, $unitId, $courseCode)
    {
        $reposObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits');
        $userCourseUnits = $reposObj->findOneBy(array(
            'user' => $applicantId,
            'unitId' => $unitId,
            'courseCode' => $courseCode));
        return !empty($userCourseUnits) ? $userCourseUnits : '';
    }
  /**
     * Function to get applicant any unit status
     * @param int $applicantId     
     * @param string $courseCode
     * return int
     */
    public function getOneUnitStatus($applicantId, $courseCode)
    {
        $reposObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits');
        $userCourseUnits = $reposObj->findBy(array(
            'user' => $applicantId,            
            'courseCode' => $courseCode,
            'issubmitted' => '1' ));
        $result = !empty($userCourseUnits) ? count($userCourseUnits) : '0';
        return $result;
    }
    /**
     * Function to get core Units Status
     * @param int $applicantId     
     * @param string $courseCode
     * @param string $unittype
     * return array
     */
    public function getSubmittedCoreStatus($applicantId, $courseCode, $unittype)
    {
        $reposObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits');
        $userCourseUnits = $reposObj->findBy(array(
            'user' => $applicantId,            
            'courseCode' => $courseCode,
            'type'=> $unittype,
            'issubmitted' => '1' ,            
            'status' => '1'));
        
        return !empty($userCourseUnits) ? count($userCourseUnits) : '';
    }
     /**
     * Function to get submitted elective Units Status
     * @param int $applicantId     
     * @param string $courseCode
     * @param string $unittype
     * return array
     */
    public function getSubmittedElectiveStatus($applicantId, $courseCode, $unittype)
    {
        $reposObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits');
        $userCourseUnits = $reposObj->findBy(array(
            'user' => $applicantId,            
            'courseCode' => $courseCode,
            'type'=> $unittype,
            'issubmitted' => '1' ,            
            'electiveStatus' => '1'));
        
        return !empty($userCourseUnits) ? count($userCourseUnits) : '';
    }
    /**
     * Function to update qualification unit table
     * @param int $userId
     * @param string $courseCode
     * @param array $apiResults
     */
    public function updateQualificationUnits($userId, $courseCode, $apiResults)
    {
        if (isset($apiResults['courseInfo'])) {
            if (isset($apiResults['courseInfo']['Units'])) {
                $userObj = $this->em->getRepository('GqAusUserBundle:User')
                    ->find($userId);
                if (isset($apiResults['courseInfo']['Units']['Unit'])) {
                    if (array_key_exists('id', $apiResults['courseInfo']['Units']['Unit'])) {
                        $unitResults[] = $apiResults['courseInfo']['Units']['Unit'];
                    } else {
                        $unitResults = $apiResults['courseInfo']['Units']['Unit'];
                    }
                    foreach ($unitResults as $unit) {
                        $reposObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits');
                        $userUnitObj = $reposObj->findOneBy(array('user' => $userId,
                            'unitId' => $unit['id'],
                            'courseCode' => trim($courseCode)));
                        if (empty($userUnitObj)) {
                            $reposUnitObj = new UserCourseUnits();
                            $reposUnitObj->setUnitId($unit['id']);
                            $reposUnitObj->setCourseCode($courseCode);
                            if (trim($unit['type']) == 'core') {
                                $reposUnitObj->setStatus('1'); //by default setting as inactive
                            } else {
                                $reposUnitObj->setStatus('0'); //by default setting as inactive
                            }
                            $reposUnitObj->setType($unit['type']);
                            $reposUnitObj->setUser($userObj);
                            $reposUnitObj->setFacilitatorstatus('0');
                            $reposUnitObj->setAssessorstatus('0');
                            $reposUnitObj->setRtostatus('0');
                            $reposUnitObj->setElectiveStatus('');
                            $reposUnitObj->SetIssubmitted('');
                            $this->em->persist($reposUnitObj);
                            $this->em->flush();
                        }//if
                    }//for
                }
            }
        }//if
    }

    /**
     * Function to get qualification elective units
     * @param int $userId
     * @param string $courseCode
     * return array
     */
    public function getQualificationElectiveUnits($userId, $courseCode)
    {
        $reposObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits');
        $userCourseUnits = $reposObj->findBy(array('user' => $userId,
            'courseCode' => $courseCode));
        $courseUnits = array();
        $courseApprovedUnits = array();
        if (!empty($userCourseUnits)) {
            foreach ($userCourseUnits as $units) {
                $facilitatorstatus = $units->getFacilitatorstatus();
                $aStatus = $units->getAssessorstatus();
                $rStatus = $units->getRtostatus();
                if ($units->getStatus() == '0') {
                    $courseUnits[] = $units->getUnitId();
                }
                if (($aStatus == 1 && $rStatus == 2) || ($aStatus == 2 && $rStatus == 0) ||
                    ($aStatus == 0 && $rStatus == 0)) {
                    $courseApprovedUnits[] = $units->getUnitId();
                }
            }
        }
        return compact('courseUnits', 'courseApprovedUnits');
    }
    /**
     * Function to Submit Unit for Review
     */
    
    public function getsubmitUnitForReview($userId,$courseCode,$unitId)
    {
         $reposObj = $this->em->getRepository('GqAusUserBundle:Evidence');
        $evidences = $reposObj->findBy(array('user' => $userId, 'unit' => $unitId, 'course' => $courseCode));
        return $evidences;
    }
    /**
     * Function to get qualification elective units using elective_status
     * @param int $userId
     * @param string $courseCode
     * return array
     */
    public function getQualificationElectiveStatus($userId, $courseCode,$unitId)
    {
        $reposObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits');
        $userCourseUnits = $reposObj->findBy(array('user' => $userId,
            'courseCode' => $courseCode,'unitId'=>$unitId,'type'=>'elective'));
        $courseUnits = array();
  
        return $userCourseUnits;
    }
     /**
     * Function to get Elective CheckedValues
     * @param type $userId
     * @param type $courseCode     /
     */
    public function getElectiveCheckedValues($userId, $courseCode)
    {
         $reposObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits');
         $userCourseUnits = $reposObj->findBy(array('user' => $userId,
            'courseCode' => $courseCode,
            'type' => 'elective',
            'electiveStatus' => '1'));
        $courseUnits = array();
        if (!empty($userCourseUnits)) {
            foreach ($userCourseUnits as $units) {
                $courseUnits[trim($units->getUnitId())] = trim($units->getUnitId());
            }
        }                
        return count($courseUnits);
    }
    /**
     * Function to get the Evidence percenatge based on the units in the course 
     * @param int $userId
     * @param string $coursecode
     * return string
     */
    public function getEvidenceByCourse($userId, $courseCode){
        $reqNoUnits = $this->getReqUnitsForCourseByCourseId($courseCode);
        if (empty($reqNoUnits)) {
        				return '0%';
        }
        $eviPercentage = 0;
        $totalElecOfUnits = 0;
        $totalCoreOfUnits = 0;
        $courseCoreUnitObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits')->findBy(array('user' => $userId, 'courseCode' => $courseCode, 'type' => 'core', 'issubmitted' => '1' ));
        $courseElecUnitObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits')->findBy(array('user' => $userId, 'courseCode' => $courseCode, 'type' => 'elective', 'issubmitted' => '1' ));
        $totalCoreOfUnits = count($courseCoreUnitObj);
        $totalElecOfUnits = count($courseElecUnitObj);
        if($totalElecOfUnits > $reqNoUnits['elective'])
            $totalElecOfUnits = $reqNoUnits['elective'];
        $totalNoOfUnits = $totalCoreOfUnits + $totalElecOfUnits;
        if($totalNoOfUnits > 0){
            $eviPercentage = ($totalNoOfUnits / (($reqNoUnits['core']) + ($reqNoUnits['elective']))) * 100;
            $eviPercentage = ($eviPercentage > 100) ? '100' : $eviPercentage;
        }
        return round($eviPercentage) . '%';
    }
    
    /**
     * Function to get the Evidence percenatge based on the units in the course
     * @param int $userId
     * @param string $coursecode
     * return string
     */
    public function getUnitsSubmittedbyCourse($userId, $courseCode){
    	$reqNoUnits = $this->getReqUnitsForCourseByCourseId($courseCode);
    	$eviPercentage = 0;
    	$totalElecOfUnits = 0;
    	$totalCoreOfUnits = 0;
    	$courseCoreUnitObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits')->findBy(array('user' => $userId, 'courseCode' => $courseCode, 'type' => 'core', 'issubmitted' => '1' ));
    	$courseElecUnitObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits')->findBy(array('user' => $userId, 'courseCode' => $courseCode, 'type' => 'elective', 'issubmitted' => '1' ));
    	$totalCoreOfUnits = count($courseCoreUnitObj);
    	$totalElecOfUnits = count($courseElecUnitObj);
    	
    	return array('core' => $totalCoreOfUnits, 'elective' => $totalElecOfUnits);
    }
    
    /** 
     * Function to get the Units and details
     * @param int $userId
     * @param string $courseCode
     * @param string $unitCode
     * return string
     */
    public function getUserCourseUnits($userId, $courseCode, $type = 'elective'){
    	$reposObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits');
         $userCourseUnits = $reposObj->findBy(array('user' => $userId,
            'courseCode' => $courseCode,
            'type' => $type
             ));
        $courseUnits = array();
        if (!empty($userCourseUnits)) {
            foreach ($userCourseUnits as $units) {
                $unit = [];
                $unit['id'] = $units->getId();
                $unit['unitId'] = $units->getUnitId();
                $unit['userId'] = $units->getUser()->getId();
                $unit['courseCode'] = $units->getCourseCode();
                $unit['type'] = $units->getType();
                $unit['facilitatorStatus'] = $units->getFacilitatorstatus();
                $unit['assessorStatus'] = $units->getAssessorstatus();
                $unit['rtoStatus'] = $units->getRtostatus();
                $unit['status'] = $units->getStatus();
                $unit['electiveStatus'] = $units->getElectiveStatus();
                $unit['isSubmitted'] = $units->getIssubmitted();
                $courseUnits[trim($units->getUnitId())] =  $unit;    
            }
        } 
        
        return $courseUnits;
    }
    
    /** 
     * Function to update user selected units status to 0
     * @param int $userId
     * @param string $courseCode
     * return string
     */
    
    public function resetUnitElectives($userId, $courseCode)
    {
        $reposObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits');
        $userCourseUnits = $reposObj->findBy(array('user' => $userId,
            'courseCode' => $courseCode,
            'type' => 'elective'
        ));
        if (!empty($userCourseUnits)) {
            foreach ($userCourseUnits as $units) {
                $units->setElectiveStatus('0');
                $this->em->persist($units);
                $this->em->flush();
            }
        }
        
    }
}
