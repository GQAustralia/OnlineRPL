<?php namespace GqAus\UserBundle\Twig;

class AppExtension extends \Twig_Extension
{
	private $userService;
	public function __construct($userService)
    {
        $this->userService = $userService;
    }
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('price', array($this, 'priceFilter')),
        );
    }

    public function priceFilter($userId, $courseCode)
    {
		$result = $this->userService->getEvidenceCompleteness($userId, $courseCode);
        return $result;
    }

    public function getName()
    {
        return 'app_extension';
    }
} ?>