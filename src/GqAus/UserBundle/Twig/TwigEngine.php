<?php
namespace GqAus\UserBundle\Twig;
use Symfony\Bundle\TwigBundle\TwigEngine as BaseTwigEngine;
use Symfony\Component\Templating\TemplateNameParserInterface;
use Symfony\Component\Config\FileLocatorInterface;
use Detection\MobileDetect;

class TwigEngine extends BaseTwigEngine
{
    protected $mobileDetect;
    public function __construct(\Twig_Environment $environment, TemplateNameParserInterface $parser, FileLocatorInterface $locator, MobileDetect $mobileDetect)
    {
        $this->mobileDetect = $mobileDetect;
        parent::__construct($environment, $parser, $locator);
    }
    public function render($name, array $parameters = array())
    {
        if ($this->mobileDetect->isMobile() && !$this->mobileDetect->isTablet()) {
            //$name = preg_replace('~:(?!.*:)~', '/mobile:', $name);
        }
        return parent::render($name, $parameters);
    }
}