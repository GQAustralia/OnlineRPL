<?php

namespace GqAus\HomeBundle\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;
use GqAus\UserBundle\Entity\UserCourses;
use GqAus\UserBundle\Entity\UserCourseUnits;
use GuzzleHttp\Exception\ServerException;

class CoursesService {

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
    public function __construct($em, $container, $mailer, $guzzleService) {
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
    public function getCourseDetails($qcode, $uid) {
        return $this->em->getRepository('GqAusUserBundle:UserCourses')
                        ->findOneBy(array('courseCode' => $qcode, 'user' => $uid));
    }

    /**
     * Function to get courses info
     * @param int $id
     * return array
     */
    public function getCoursesInfo($id) {
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
    public function getPackagerulesInfo($id) {
        $packageInfo = $this->fetchQualificationRequest($id);
        $packageInfoPackage = null;
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
    public function getCourseInfo($id) {
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
    public function getUnitInfo($id) {
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
    public function getUserCoursesInfo($id) {
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
    public function fetchRequest($id) {
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
    public function fetchQualificationRequest($id) {
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
    public function fetchCourseRequest($id) {
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
    public function fetchUnitRequest($id) {
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
    public function accessCourseAPI($fieldString) {
        $apiUrl = $this->container->getParameter('apiUrl');
        $apiAuthUsername = $this->container->getParameter('apiAuthUsername');
        $apiAuthPassword = $this->container->getParameter('apiAuthPassword');
        $url = $apiUrl . "unitsbyqualifications";

        try {
            $response = $this->guzzleService->request('POST', $url, [
                'auth' => [$apiAuthUsername, $apiAuthPassword],
                'query' => $fieldString
            ]);
        } catch (ServerException $e) {

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
    public function accessQualificationAPI($fieldString) {
        $apiUrl = $this->container->getParameter('apiUrl');
        $apiAuthUsername = $this->container->getParameter('apiAuthUsername');
        $apiAuthPassword = $this->container->getParameter('apiAuthPassword');
        $url = $apiUrl . "qualifications";

        try {
            $response = $this->guzzleService->request('POST', $url, [
                'auth' => [$apiAuthUsername, $apiAuthPassword],
                'query' => $fieldString
            ]);
        } catch (ServerException $e) {

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
    public function accessAPI($fieldString) {
        $apiUrl = $this->container->getParameter('apiUrl');
        $apiAuthUsername = $this->container->getParameter('apiAuthUsername');
        $apiAuthPassword = $this->container->getParameter('apiAuthPassword');
        $url = $apiUrl . "qualificationunits";

        try {
            $response = $this->guzzleService->request('POST', $url, [
                'auth' => [$apiAuthUsername, $apiAuthPassword],
                'query' => $fieldString
            ]);
        } catch (ServerException $e) {

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
    public function accessUnitAPI($fieldString) {
        $apiUrl = $this->container->getParameter('apiUrl');
        $apiAuthUsername = $this->container->getParameter('apiAuthUsername');
        $apiAuthPassword = $this->container->getParameter('apiAuthPassword');
        $url = $apiUrl . "units";

        try {
            $response = $this->guzzleService->request('POST', $url, [
                'auth' => [$apiAuthUsername, $apiAuthPassword],
                'query' => $fieldString
            ]);
        } catch (ServerException $e) {

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
    public function getReqUnitsForCourseByCourseId($courseCode) {
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
        } catch (ServerException $e) {
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
        if (!empty($qualificationUnits['package'])) {
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
    public function getTokenGenerated($result) {
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
    function xml2array($contents, $getAttributes = 1, $priority = 'tag') {
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
    public function updateUnitElective($userId, $unitId, $courseCode) {
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
            $userUnitObj->setElectiveStatus($status);
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
    public function getSelectedElectiveUnits($userId, $courseCode) {
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
    public function getElectiveUnits($userId, $courseCode, $type = 'elective') {
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
    public function getCoreElectiveUnitsCount($userId, $courseCode, $type) {
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
    public function getUnitStatus($applicantId, $unitId, $courseCode) {
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
    public function getOneUnitStatus($applicantId, $courseCode) {
        $reposObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits');
        $userCourseUnits = $reposObj->findBy(array(
            'user' => $applicantId,
            'courseCode' => $courseCode,
            'issubmitted' => '1'));
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
    public function getSubmittedCoreStatus($applicantId, $courseCode, $unittype) {
        $reposObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits');
        $userCourseUnits = $reposObj->findBy(array(
            'user' => $applicantId,
            'courseCode' => $courseCode,
            'type' => $unittype,
            'issubmitted' => '1',
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
    public function getSubmittedElectiveStatus($applicantId, $courseCode, $unittype) {
        $reposObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits');
        $userCourseUnits = $reposObj->findBy(array(
            'user' => $applicantId,
            'courseCode' => $courseCode,
            'type' => $unittype,
            'issubmitted' => '1',
            'electiveStatus' => '1'));

        return !empty($userCourseUnits) ? count($userCourseUnits) : '';
    }

    /**
     * Function to update qualification unit table
     * @param int $userId
     * @param string $courseCode
     * @param array $apiResults
     */
    public function updateQualificationUnits($userId, $courseCode, $apiResults) {
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
    public function getQualificationElectiveUnits($userId, $courseCode) {
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
    public function getsubmitUnitForReview($userId, $courseCode, $unitId) {
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
    public function getQualificationElectiveStatus($userId, $courseCode, $unitId) {
        $reposObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits');
        $userCourseUnits = $reposObj->findBy(array('user' => $userId,
            'courseCode' => $courseCode, 'unitId' => $unitId, 'type' => 'elective'));
        $courseUnits = array();

        return $userCourseUnits;
    }

    /**
     * Function to get Elective CheckedValues
     * @param type $userId
     * @param type $courseCode     /
     */
    public function getElectiveCheckedValues($userId, $courseCode) {
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
    public function getEvidenceByCourse($userId, $courseCode) {
        $reqNoUnits = $this->getReqUnitsForCourseByCourseId($courseCode);
        if (empty($reqNoUnits)) {
            return '0%';
        }
        $eviPercentage = 0;
        $totalElecOfUnits = 0;
        $totalCoreOfUnits = 0;
        $courseCoreUnitObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits')->findBy(array('user' => $userId, 'courseCode' => $courseCode, 'type' => 'core', 'issubmitted' => '1'));
        $courseElecUnitObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits')->findBy(array('user' => $userId, 'courseCode' => $courseCode, 'type' => 'elective', 'issubmitted' => '1'));
        $totalCoreOfUnits = count($courseCoreUnitObj);
        $totalElecOfUnits = count($courseElecUnitObj);
        if ($totalElecOfUnits > $reqNoUnits['elective'])
            $totalElecOfUnits = $reqNoUnits['elective'];
        $totalNoOfUnits = $totalCoreOfUnits + $totalElecOfUnits;
        if ($totalNoOfUnits > 0) {
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
    public function getUnitsSubmittedbyCourse($userId, $courseCode) {
        $reqNoUnits = $this->getReqUnitsForCourseByCourseId($courseCode);
        $eviPercentage = 0;
        $totalElecOfUnits = 0;
        $totalCoreOfUnits = 0;
        $courseCoreUnitObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits')->findBy(array('user' => $userId, 'courseCode' => $courseCode, 'type' => 'core', 'issubmitted' => '1'));
        $courseElecUnitObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits')->findBy(array('user' => $userId, 'courseCode' => $courseCode, 'type' => 'elective', 'issubmitted' => '1'));
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
    public function getUserCourseUnits($userId, $courseCode, $type = 'elective') {
        $reposObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits');
        $userCourseUnits = $reposObj->findBy(array('user' => $userId,
            'courseCode' => $courseCode,
            'type' => $type
        ));

        return $userCourseUnits;
    }

    /**
     * Function to update user selected units status to 0
     * @param int $userId
     * @param string $courseCode
     * return string
     */
    public function resetUnitElectives($userId, $courseCode) {
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

    public function convertToBytes($from) {
        $number = substr($from, 0, -2);
        switch (strtoupper(substr($from, -2))) {
            case "KB":
                return $number * 1024;
            case "MB":
                return $number * pow(1024, 2);
            case "GB":
                return $number * pow(1024, 3);
            case "TB":
                return $number * pow(1024, 4);
            case "PB":
                return $number * pow(1024, 5);
            default:
                return 0;
        }
    }

    public function getTotalUploadSize($userId) {

        $totalSize = 0;
        $reposObj = $this->em->getRepository('GqAusUserBundle:Evidence');
        $evidences = $reposObj->findBy(array('user' => $userId));
        foreach ($evidences as $evidence) {
            $totalSize += $this->convertToBytes($evidence->getSize());
        }
        return $totalSize;
    }

    public function getUploadDetails($userId) {
        $reposObj = $this->em->getRepository('GqAusUserBundle:EvidenceCategory');
        $evidenceCategories = $reposObj->findAll();
        $evidence_category = [];
        foreach ($evidenceCategories as $evidencecategory) {
            $evidenceCat = [];
            $evidenceCat['name'] = $evidencecategory->getName();
            $evidenceCat['id'] = $evidencecategory->getId();
            $evidence_category[] = $evidenceCat;
        }
        $uploadDetails = array();
        $uploadDetails['evidenceCategory'] = $evidence_category;
        $uploadDetails['totalUploadSize'] = $this->getTotalUploadSize($userId);
        $uploadDetails['maxUploadSize'] = 10 * 1024 * 1024 * 1024;
        return $uploadDetails;
    }

    private function mimeTypes() {
        $mimeTypes = array(
            'ai' => 'application/postscript',
            'aif' => 'audio/x-aiff',
            'aifc' => 'audio/x-aiff',
            'aiff' => 'audio/x-aiff',
            'asc' => 'text/plain',
            'atom' => 'application/atom+xml',
            'atom' => 'application/atom+xml',
            'au' => 'audio/basic',
            'avi' => 'video/x-msvideo',
            'bcpio' => 'application/x-bcpio',
            'bin' => 'application/octet-stream',
            'bmp' => 'image/bmp',
            'cdf' => 'application/x-netcdf',
            'cgm' => 'image/cgm',
            'class' => 'application/octet-stream',
            'cpio' => 'application/x-cpio',
            'cpt' => 'application/mac-compactpro',
            'csh' => 'application/x-csh',
            'css' => 'text/css',
            'csv' => 'text/csv',
            'dcr' => 'application/x-director',
            'dir' => 'application/x-director',
            'djv' => 'image/vnd.djvu',
            'djvu' => 'image/vnd.djvu',
            'dll' => 'application/octet-stream',
            'dmg' => 'application/octet-stream',
            'dms' => 'application/octet-stream',
            'doc' => 'application/msword',
            'dtd' => 'application/xml-dtd',
            'dvi' => 'application/x-dvi',
            'dxr' => 'application/x-director',
            'eps' => 'application/postscript',
            'etx' => 'text/x-setext',
            'exe' => 'application/octet-stream',
            'ez' => 'application/andrew-inset',
            'gif' => 'image/gif',
            'gram' => 'application/srgs',
            'grxml' => 'application/srgs+xml',
            'gtar' => 'application/x-gtar',
            'hdf' => 'application/x-hdf',
            'hqx' => 'application/mac-binhex40',
            'htm' => 'text/html',
            'html' => 'text/html',
            'ice' => 'x-conference/x-cooltalk',
            'ico' => 'image/x-icon',
            'ics' => 'text/calendar',
            'ief' => 'image/ief',
            'ifb' => 'text/calendar',
            'iges' => 'model/iges',
            'igs' => 'model/iges',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'js' => 'application/x-javascript',
            'json' => 'application/json',
            'kar' => 'audio/midi',
            'latex' => 'application/x-latex',
            'lha' => 'application/octet-stream',
            'lzh' => 'application/octet-stream',
            'm3u' => 'audio/x-mpegurl',
            'man' => 'application/x-troff-man',
            'mathml' => 'application/mathml+xml',
            'me' => 'application/x-troff-me',
            'mesh' => 'model/mesh',
            'mid' => 'audio/midi',
            'midi' => 'audio/midi',
            'mif' => 'application/vnd.mif',
            'mov' => 'video/quicktime',
            'movie' => 'video/x-sgi-movie',
            'mp2' => 'audio/mpeg',
            'mp3' => 'audio/mpeg',
            'mp4' => 'video/mp4',
            'mpe' => 'video/mpeg',
            'mpeg' => 'video/mpeg',
            'mpg' => 'video/mpeg',
            'mpga' => 'audio/mpeg',
            'ms' => 'application/x-troff-ms',
            'msh' => 'model/mesh',
            'mxu' => 'video/vnd.mpegurl',
            'nc' => 'application/x-netcdf',
            'oda' => 'application/oda',
            'ogg' => 'application/ogg',
            'pbm' => 'image/x-portable-bitmap',
            'pdb' => 'chemical/x-pdb',
            'pdf' => 'application/pdf',
            'pgm' => 'image/x-portable-graymap',
            'pgn' => 'application/x-chess-pgn',
            'png' => 'image/png',
            'pnm' => 'image/x-portable-anymap',
            'ppm' => 'image/x-portable-pixmap',
            'ppt' => 'application/vnd.ms-powerpoint',
            'ps' => 'application/postscript',
            'qt' => 'video/quicktime',
            'ra' => 'audio/x-pn-realaudio',
            'ram' => 'audio/x-pn-realaudio',
            'ras' => 'image/x-cmu-raster',
            'rdf' => 'application/rdf+xml',
            'rgb' => 'image/x-rgb',
            'rm' => 'application/vnd.rn-realmedia',
            'roff' => 'application/x-troff',
            'rss' => 'application/rss+xml',
            'rtf' => 'text/rtf',
            'rtx' => 'text/richtext',
            'sgm' => 'text/sgml',
            'sgml' => 'text/sgml',
            'sh' => 'application/x-sh',
            'shar' => 'application/x-shar',
            'silo' => 'model/mesh',
            'sit' => 'application/x-stuffit',
            'skd' => 'application/x-koan',
            'skm' => 'application/x-koan',
            'skp' => 'application/x-koan',
            'skt' => 'application/x-koan',
            'smi' => 'application/smil',
            'smil' => 'application/smil',
            'snd' => 'audio/basic',
            'so' => 'application/octet-stream',
            'spl' => 'application/x-futuresplash',
            'src' => 'application/x-wais-source',
            'sv4cpio' => 'application/x-sv4cpio',
            'sv4crc' => 'application/x-sv4crc',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',
            'swf' => 'application/x-shockwave-flash',
            't' => 'application/x-troff',
            'tar' => 'application/x-tar',
            'tcl' => 'application/x-tcl',
            'tex' => 'application/x-tex',
            'texi' => 'application/x-texinfo',
            'texinfo' => 'application/x-texinfo',
            'tif' => 'image/tiff',
            'tiff' => 'image/tiff',
            'tr' => 'application/x-troff',
            'tsv' => 'text/tab-separated-values',
            'txt' => 'text/plain',
            'ustar' => 'application/x-ustar',
            'vcd' => 'application/x-cdlink',
            'vrml' => 'model/vrml',
            'vxml' => 'application/voicexml+xml',
            'wav' => 'audio/x-wav',
            'wbmp' => 'image/vnd.wap.wbmp',
            'wbxml' => 'application/vnd.wap.wbxml',
            'wml' => 'text/vnd.wap.wml',
            'wmlc' => 'application/vnd.wap.wmlc',
            'wmls' => 'text/vnd.wap.wmlscript',
            'wmlsc' => 'application/vnd.wap.wmlscriptc',
            'wrl' => 'model/vrml',
            'xbm' => 'image/x-xbitmap',
            'xht' => 'application/xhtml+xml',
            'xhtml' => 'application/xhtml+xml',
            'xls' => 'application/vnd.ms-excel',
            'xml' => 'application/xml',
            'xpm' => 'image/x-xpixmap',
            'xsl' => 'application/xml',
            'xslt' => 'application/xslt+xml',
            'xul' => 'application/vnd.mozilla.xul+xml',
            'xwd' => 'image/x-xwindowdump',
            'xyz' => 'chemical/x-xyz',
            'zip' => 'application/zip'
        );
        return $mimeTypes;
    }

    public function getEvidencesByUnit($userId, $unitCode, $courseCode) {
        $reposObj = $this->em->getRepository('GqAusUserBundle:Evidence');
        $evidences = $reposObj->findBy(['user' => $userId, 'unit' => $unitCode, 'course' => $courseCode]);
        $userEvidence = [];

        foreach ($evidences as $evidence) {
            $evd = [];
            $evd['id'] = $evidence->getId();
            $type = $evidence->getType();
            $evd['type'] = $type;
            $evd['created'] = $evidence->getCreated();
            $evd['path'] = $evidence->getPath();
            $evd['s3Path'] = $evd['mimeType'] = $evd['fileType'] = '';
            if ($type != 'text') {
                $s3Path = '';
                if ($type != 'recording')
                    $s3Path = $this->container->getParameter('amazon_s3_base_url') . 'user-' . $userId . '/' . $evd['path'];
                else
                    $s3Path = $this->container->getParameter('amazon_s3_base_url') . $this->container->getParameter('tokbox_key') . '/' . $evd['path'] . '/archive.mp4';
                $evd['s3Path'] = $s3Path;
                $info = pathinfo($s3Path);
                $basename = isset($info['basename']) ? $info['basename'] : '';
                $ext = isset($info['extension']) ? $info['extension'] : '';
                $evd['mimeType'] = (isset($this->mimeTypes()[$ext]) ? $this->mimeTypes()[$ext] : '');
                if (empty($evd['mimeType'])) {
                    $contentType = get_headers($s3Path, 1)["Content-Type"];
                    $evd['mimeType'] = ($contentType != '') ? $contentType : 'application/octet-stream';
                }
                $evd['fileType'] = $ext;
            }

            $evd['name'] = ($type == 'text') ? '' : $evidence->getName();
            $evd['content'] = ($type == 'text') ? $evidence->getContent() : '';
            $evd['size'] = $evidence->getSize();
            $evd['facilitatorViewStatus'] = $evidence->getfacilitatorViewStatus();
            $evd['jobId'] = ($evidence->getJobId()) ? $evidence->getJobId() : '';

            $userEvidence[] = $evd;
        }

        return $userEvidence;
//        foreach ($evidences as $evidence) {
//           $totalSize += $this->convertToBytes($evidence->getSize());
//        }
    }

    /**
     * Function to get All evidence Except text By user
     * @param object $request
     * return string
     */
    public function getEvidenceLibraryAction($userId) {
        $evidences = $this->em->getRepository('GqAusUserBundle:Evidence')->findByUser($userId);
        $userEvidence = [];
        foreach ($evidences as $evidence) {
            $type = $evidence->getType();
            if ($type != 'text') {
                $evd = [];
                $evd['id'] = $evidence->getId();
                $evd['catId'] = $evidence->getCategory()?$evidence->getCategory()->getId():0;
                $evd['created'] = $evidence->getCreated();
                $evd['type'] = $type;
                $evd['path'] = $evidence->getPath();
                $evd['s3Path'] = $evd['mimeType'] = $evd['fileType'] = '';
                if ($type != 'text') {
                    $s3Path = '';
                    if ($type != 'recording')
                        $s3Path = $this->container->getParameter('amazon_s3_base_url') . 'user-' . $userId . '/' . $evd['path'];
                    else
                        $s3Path = $this->container->getParameter('amazon_s3_base_url') . $this->container->getParameter('tokbox_key') . '/' . $evd['path'] . '/archive.mp4';
                    $evd['s3Path'] = $s3Path;
                    $info = pathinfo($s3Path);
                    $basename = isset($info['basename']) ? $info['basename'] : '';
                    $ext = isset($info['extension']) ? $info['extension'] : '';
                    $evd['mimeType'] = (isset($this->mimeTypes()[$ext]) ? $this->mimeTypes()[$ext] : '');
                    if (empty($evd['mimeType'])) {
                        $contentType = get_headers($s3Path, 1)["Content-Type"];
                        $evd['mimeType'] = ($contentType != '') ? $contentType : 'application/octet-stream';
                    }
                    $evd['fileType'] = $ext;
                }

                $evd['name'] = ($type == 'text') ? '' : $evidence->getName();
                $evd['content'] = ($type == 'text') ? $evidence->getContent() : '';
                $evd['size'] = $evidence->getSize();
                $evd['unitCode'] = $evidence->getUnit();
                $noOfRcrds = $this->getLinkedToMultiUnitOrNot($evidence);
                $evd['linkToMulti'] = ($noOfRcrds>1) ? 'multi' : 'single';
                $evd['linkedTo'] = ($noOfRcrds>1) ? ($noOfRcrds-1) : 0;
                $evd['facilitatorViewStatus'] = $evidence->getfacilitatorViewStatus();
                $evd['courseCode'] = ($evidence->getCourse()) ? $evidence->getCourse() : '';
                $evd['jobId'] = ($evidence->getJobId()) ? $evidence->getJobId() : '';
                $userEvidence[] = $evd;
            }
        }
        return $userEvidence;
    }

    /**
     * Function to retrieve the evidence is linked to single unit or multi unit.
     * @param type $evdId
     * return the string
     */
    public function getLinkedToMultiUnitOrNot($evidence) {
        $vidObj = $this->em->getRepository('GqAusUserBundle:Evidence\Video');
        $audObj = $this->em->getRepository('GqAusUserBundle:Evidence\Audio');
        $filObj = $this->em->getRepository('GqAusUserBundle:Evidence\File');
        $imgObj = $this->em->getRepository('GqAusUserBundle:Evidence\Image');
        $texObj = $this->em->getRepository('GqAusUserBundle:Evidence\Text');
        $evdObj = $this->em->getRepository('GqAusUserBundle:Evidence')->findOneById($evidence);
        switch ($evdObj->getType()) {
            case 'image':
                $evidenceObj = $imgObj->findOneById($evidence);
                $query = $this->em->getRepository('GqAusUserBundle:Evidence\Image')->createQueryBuilder('ei')->groupBy('ei.path')->select('count(ei.path) as totalRcrds')->where(sprintf('ei.%s = :%s', 'path', 'evdPath'))->setParameter('evdPath', $evidenceObj->getPath());
                break;
            case 'audio':
                $evidenceObj = $audObj->findOneById($evidence);
                $query = $this->em->getRepository('GqAusUserBundle:Evidence\Audio')->createQueryBuilder('ea')->groupBy('ea.path')->select('count(ea.path) as totalRcrds')->where(sprintf('ea.%s = :%s', 'path', 'evdPath'))->setParameter('evdPath', $evidenceObj->getPath());
                break;
            case 'video':
                $evidenceObj = $vidObj->findOneById($evidence);
                $query = $this->em->getRepository('GqAusUserBundle:Evidence\Video')->createQueryBuilder('ev')->groupBy('ev.path')->select('count(ev.path) as totalRcrds')->where(sprintf('ev.%s = :%s', 'path', 'evdPath'))->setParameter('evdPath', $evidenceObj->getPath());
                break;
            case 'file':
                $evidenceObj = $filObj->findOneById($evidence);
                $query = $this->em->getRepository('GqAusUserBundle:Evidence\File')->createQueryBuilder('ef')->groupBy('ef.path')->select('count(ef.path) as totalRcrds')->where(sprintf('ef.%s = :%s', 'path', 'evdPath'))->setParameter('evdPath', $evidenceObj->getPath());
                break;
            case 'text':
                $evidenceObj = $texObj->findOneById($evidence);
                $query = $this->em->getRepository('GqAusUserBundle:Evidence\Text')->createQueryBuilder('et')->groupBy('et.path')->select('count(et.path) as totalRcrds')->where(sprintf('et.%s = :%s', 'path', 'evdPath'))->setParameter('evdPath', $evidenceObj->getPath());
                break;
            default :
                $evidenceObj = $filObj->findOneById($evidence);
                $query = $this->em->getRepository('GqAusUserBundle:Evidence\File')->createQueryBuilder('ef')->groupBy('ef.path')->select('count(ef.path) as totalRcrds')->where(sprintf('ef.%s = :%s', 'path', 'evdPath'))->setParameter('evdPath', $evidenceObj->getPath());
                break;
        }
        if (!empty($evidenceObj)) {
            $courseObj = $query->getQuery()->getResult();
            $noOfRcrds = $courseObj[0]['totalRcrds'];
            return $noOfRcrds;
        }        
    }
    
    /**
     * Get the status class
     * @param type $statusText
     * @return string
     */
    public function getStatusClass($statusText) {
        $cls = 'label-warning';
        switch ($statusText) {
            case 'Submitted':
                $cls = 'label-warning';
                break;
            case 'Satisfactory':
                $cls = 'label-default';
                break;
            case 'Not yet satisfactory':
            case 'Not yet competent':
                $cls = 'label-danger';
                break;
            case 'Competent':
                $cls = 'label-success';
                break;
            default:
                $cls = 'label-warning';
        }
        return $cls;
    }

    /**
     * Function to retrieve the list of applicants from the facilitator
     * @param type $facId
     */
    public function listOfApplicantsForLoggedinUser($facId = '') {
        $query = $this->em->getRepository('GqAusUserBundle:UserCourses')
                        ->createQueryBuilder('uc')
                        ->groupBy('uc.user')
//            ->select('uc.user')
                        ->where(sprintf('uc.%s = :%s', 'facilitator', 'facilitatorId'))->setParameter('facilitatorId', $facId);

        $courseObj = $query->getQuery()->getResult();
        return $courseObj;
    }

}
