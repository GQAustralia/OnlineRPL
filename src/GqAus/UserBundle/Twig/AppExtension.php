<?php 
namespace GqAus\UserBundle\Twig;

use Symfony\Component\HttpKernel\KernelInterface;

class AppExtension extends \Twig_Extension {
    
    private $userService;
    public function __construct($userService)
    {
        $this->userService = $userService;
    }
    /**
     * {@inheritdoc}
     */
    public function getFunctions() {
        return array(
            'completeness' => new \Twig_Function_Method($this, 'evidenceCompleteness'),
            'timeRemaining' => new \Twig_Function_Method($this, 'getTimeRemaining')
        );
    }

    /**
     * @param userId $string
     * @param courseCode $string
     * @return int
     */
    public function evidenceCompleteness($userId, $courseCode)
    {
        $result = $this->userService->getEvidenceCompleteness($userId, $courseCode);
        return $result;
    }
    
    /**
     * @param id $string
     * @return string
     */
    public function getTimeRemaining($id)
    {
        $result = $this->userService->getTimeRemaining($id);
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return 'my_bundle';
    }
}
 ?>