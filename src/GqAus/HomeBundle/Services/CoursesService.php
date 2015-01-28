<?php

namespace GqAus\HomeBundle\Services;

use Doctrine\ORM\EntityManager;

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
    * Function to get courses info
    * return $result array
    */
    public function getCoursesInfo($id)
    {
        $courseInfo = $this->fetchRequest($id);
        if (!empty($courseInfo)) {
            if(!empty($courseInfo['details']))
            {
                $courseInfo['details'] = html_entity_decode($courseInfo['details']);
            }
        }
        return array('courseInfo' => $courseInfo);
    }
    
    /**
    * Function to api request for courses
    * return $result array
    */
    public function fetchRequest($id) {
        if (!empty($_SESSION['start']) && !empty($_SESSION['api_token'])) {
            if ($_SESSION['start'] + 60 < time()) {
                //@session_unset($_SESSION['api_token']);
                //@session_unset($_SESSION['start']);
                $_SESSION['api_token'] = '';
                $_SESSION['start'] = '';
            }
        } else {
            $_SESSION['start'] = time();
        }
         
        $postFields = array('code' => $id);
        if (!empty($_SESSION['api_token'])) {
            $postFields['token'] = $_SESSION['api_token'];
            $result = $this->accessAPI($postFields);
        } else if (empty($_SESSION['api_token'])) {
            $result = $this->accessAPI($postFields);
            $postFields['token'] = $token = $_SESSION['api_token'] = $this->getTokenGenerated($result);
            $_SESSION['start'] = time();
            if ($token) {
                $result = $this->accessAPI($postFields);
            }
        }

        if (!empty($result)) {
            $qualificationUnits = $this->xml2array($result);
        }
        return (!empty($qualificationUnits['qualification'])) ? $qualificationUnits['qualification'] : array();
    }

    public function accessAPI($fields_string) {
        $apiUrl = $this->container->getParameter('apiUrl');
        $apiAuthUsername = $this->container->getParameter('apiAuthUsername');
        $apiAuthPassword = $this->container->getParameter('apiAuthPassword');
        $url = $apiUrl."qualificationunits";
        
        $authPlugin = new \Guzzle\Plugin\CurlAuth\CurlAuthPlugin($apiAuthUsername, $apiAuthPassword);
        $this->guzzleService->addSubscriber($authPlugin);
        $request = $this->guzzleService->get($url)->setAuth($apiAuthUsername, $apiAuthPassword); 
        $request = $this->guzzleService->post($url, null, $fields_string);// Create a request with basic Auth
        $response = $request->send();// Send the request and get the response
        $result = $response->getBody();
        return $result;
    }

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
 * xml2array() will convert the given XML text to an array in the XML structure.
 * Link: http://www.bin-co.com/php/scripts/xml2array/
 * Arguments : $contents - The XML text
 *                $get_attributes - 1 or 0. If this is 1 the function will get the attributes as well as the tag values - this results in a different array structure in the return value.
 *                $priority - Can be 'tag' or 'attribute'. This will change the way the resulting array sturcture. For 'tag', the tags are given more importance.
 * Return: The parsed XML in an array form. Use print_r() to see the resulting array structure.
 * Examples: $array =  xml2array(file_get_contents('feed.xml'));
 *              $array =  xml2array(file_get_contents('feed.xml', 1, 'attribute'));
 */
function xml2array($contents, $get_attributes=1, $priority = 'tag') {
    if(!$contents) return array();

    if(!function_exists('xml_parser_create')) {
        //print "'xml_parser_create()' function not found!";
        return array();
    }

    //Get the XML parser of PHP - PHP must have this module for the parser to work
    $parser = xml_parser_create('');
    xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8"); # http://minutillo.com/steve/weblog/2004/6/17/php-xml-and-character-encodings-a-tale-of-sadness-rage-and-data-loss
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
    xml_parse_into_struct($parser, trim($contents), $xml_values);
    xml_parser_free($parser);

    if(!$xml_values) return;//Hmm...

    //Initializations
    $xml_array = array();
    $parents = array();
    $opened_tags = array();
    $arr = array();

    $current = &$xml_array; //Refference

    //Go through the tags.
    $repeated_tag_index = array();//Multiple tags with same name will be turned into an array
    foreach($xml_values as $data) {
        unset($attributes,$value);//Remove existing values, or there will be trouble

        //This command will extract these variables into the foreach scope
        // tag(string), type(string), level(int), attributes(array).
        extract($data);//We could use the array by itself, but this cooler.

        $result = array();
        $attributes_data = array();
        
        if(isset($value)) {
            if($priority == 'tag') $result = $value;
            else $result['value'] = $value; //Put the value in a assoc array if we are in the 'Attribute' mode
        }

        //Set the attributes too.
        if(isset($attributes) and $get_attributes) {
            foreach($attributes as $attr => $val) {
                if($priority == 'tag') $attributes_data[$attr] = $val;
                else $result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr'
            }
        }

        //See tag status and do the needed.
        if($type == "open") {//The starting of the tag '<tag>'
            $parent[$level-1] = &$current;
            if(!is_array($current) or (!in_array($tag, array_keys($current)))) { //Insert New tag
                $current[$tag] = $result;
                if($attributes_data) $current[$tag. '_attr'] = $attributes_data;
                $repeated_tag_index[$tag.'_'.$level] = 1;

                $current = &$current[$tag];

            } else { //There was another element with the same tag name

                if(isset($current[$tag][0])) {//If there is a 0th element it is already an array
                    $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;
                    $repeated_tag_index[$tag.'_'.$level]++;
                } else {//This section will make the value an array if multiple tags with the same name appear together
                    $current[$tag] = array($current[$tag],$result);//This will combine the existing item and the new item together to make an array
                    $repeated_tag_index[$tag.'_'.$level] = 2;
                    
                    if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well
                        $current[$tag]['0_attr'] = $current[$tag.'_attr'];
                        unset($current[$tag.'_attr']);
                    }

                }
                $last_item_index = $repeated_tag_index[$tag.'_'.$level]-1;
                $current = &$current[$tag][$last_item_index];
            }

        } elseif($type == "complete") { //Tags that ends in 1 line '<tag />'
            //See if the key is already taken.
            if(!isset($current[$tag])) { //New Key
                $current[$tag] = $result;
                $repeated_tag_index[$tag.'_'.$level] = 1;
                if($priority == 'tag' and $attributes_data) $current[$tag. '_attr'] = $attributes_data;

            } else { //If taken, put all things inside a list(array)
                if(isset($current[$tag][0]) and is_array($current[$tag])) {//If it is already an array...

                    // ...push the new element into that array.
                    $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result;
                    
                    if($priority == 'tag' and $get_attributes and $attributes_data) {
                        $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
                    }
                    $repeated_tag_index[$tag.'_'.$level]++;

                } else { //If it is not an array...
                    $current[$tag] = array($current[$tag],$result); //...Make it an array using using the existing value and the new value
                    $repeated_tag_index[$tag.'_'.$level] = 1;
                    if($priority == 'tag' and $get_attributes) {
                        if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well
                            
                            $current[$tag]['0_attr'] = $current[$tag.'_attr'];
                            unset($current[$tag.'_attr']);
                        }
                        
                        if($attributes_data) {
                            $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data;
                        }
                    }
                    $repeated_tag_index[$tag.'_'.$level]++; //0 and 1 index is already taken
                }
            }

        } elseif($type == 'close') { //End of tag '</tag>'
            $current = &$parent[$level-1];
        }
    }
    
        return($xml_array);
    }
    
    /**
    * Function to update unit electives
    * return $result string
    */
    public function updateUnitElective($userId, $unitId, $courseCode)
    {
        $status = 1;
        $reposObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits');
        $userUnitObj = $reposObj->findOneBy(array('user' => $userId,
                                            'unitId' => $unitId,
                                            'courseCode' => $courseCode)); 
        if (empty($userUnitObj)) {
            $reposObj = new \GqAus\UserBundle\Entity\UserCourseUnits();
            $userObj = $this->em->getRepository('GqAusUserBundle:User')
                ->find($userId);
            $reposObj->setUnitId($unitId);
            $reposObj->setCourseCode($courseCode);
            $reposObj->setStatus(1);
            $reposObj->setUser($userObj);
            $this->em->persist($reposObj);
        } else {
            $status = $userUnitObj->getStatus(); 
            $status = ($status == 1) ? '0' : '1'; 
            $userUnitObj->setStatus($status);
        }
        $this->em->flush();
        $this->em->clear();
        return $status;
    }
    
    /**
    * Function to get elective units
    * return $result array
    */
    public function getElectiveUnits($userId, $courseCode)
    {
        $reposObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits');
        $userCourseUnits = $reposObj->findBy(array('user' => $userId,
                                            'courseCode' => $courseCode,
                                            'status' => '0'));
        $courseUnits = array();
        if (!empty($userCourseUnits)) {
             foreach ($userCourseUnits as $units) {
                $courseUnits[] = $units->getUnitId();
             }
        }
        return $courseUnits;
    }
    
    /**
    * Function to get applicant unit status
    * return $result array
    */
    public function getUnitStatus($applicantId, $unitId)
    {
        $reposObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits');
        $userCourseUnits = $reposObj->findOneBy(array('user' => $applicantId,
                                            'unitId' => $unitId)); 
        return !empty($userCourseUnits) ? $userCourseUnits : '';
    }
    
    /**
    * Function to update qualification unit table
    * return $result array
    */
    public function updateQualificationUnits($userId, $courseCode, $apiResults)
    {
        if (isset($apiResults['courseInfo'])) {
            if (isset($apiResults['courseInfo']['Units'])) {
                $userObj = $this->em->getRepository('GqAusUserBundle:User')
                            ->find($userId);
                if (isset($apiResults['courseInfo']['Units']['Unit'])) {
                    foreach ($apiResults['courseInfo']['Units']['Unit'] as $unit) {
                        $reposObj = $this->em->getRepository('GqAusUserBundle:UserCourseUnits');
                        $userUnitObj = $reposObj->findOneBy(array('user' => $userId,
                                                            'unitId' => $unit['id'],
                                                            'courseCode' => $courseCode));
                        if (empty($userUnitObj)) {
                            $reposUnitObj = new \GqAus\UserBundle\Entity\UserCourseUnits();
                            $reposUnitObj->setUnitId($unit['id']);
                            $reposUnitObj->setCourseCode($courseCode);
                            $reposUnitObj->setStatus(1);
                            $reposUnitObj->setType($unit['type']);
                            $reposUnitObj->setUser($userObj);
                            $reposUnitObj->setFacilitatorstatus('0');
                            $reposUnitObj->setAssessorstatus('0');
                            $reposUnitObj->setRtostatus('0');
                            $this->em->persist($reposUnitObj);
                            $this->em->flush();
                            $this->em->clear();
                        }//if
                    }//for
                }
            }
        }//if
    }
}