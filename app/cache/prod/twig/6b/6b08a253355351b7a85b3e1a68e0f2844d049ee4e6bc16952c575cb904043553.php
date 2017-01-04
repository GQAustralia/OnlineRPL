<?php

/* main.html.twig */
class __TwigTemplate_e7c3cba2b97b421808766e2f7f48d9d5a3117bfedd6471139ec93db0d1dd0ffe extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'content' => array($this, 'block_content'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"en\">
  <head>
    <!-- Required meta tags always come first -->\t
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, user-scalable= no, shrink-to-fit=no\">
    <meta http-equiv=\"x-ua-compatible\" content=\"ie=edge\">
    <meta http-equiv=\"X-Frame-Options\" content=\"SAMEORIGIN\">
\t<title>";
        // line 9
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
    <link rel=\"stylesheet\" href=\"";
        // line 10
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bundle\TwigBundle\Extension\AssetsExtension')->getAssetUrl("public/css/bootstrap.min.css"), "html", null, true);
        echo "\" />
    <link rel=\"stylesheet\" href=\"";
        // line 11
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bundle\TwigBundle\Extension\AssetsExtension')->getAssetUrl("public/css/bootstrap-flex.css"), "html", null, true);
        echo "\" />
    <link rel=\"stylesheet\" href=\"";
        // line 12
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bundle\TwigBundle\Extension\AssetsExtension')->getAssetUrl("public/css/bootstrap-grid.css"), "html", null, true);
        echo "\" />
    <link rel=\"stylesheet\" href=\"";
        // line 13
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bundle\TwigBundle\Extension\AssetsExtension')->getAssetUrl("public/css/bootstrap-reboot.css"), "html", null, true);
        echo "\">
    <link rel=\"stylesheet\" href=\"";
        // line 14
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bundle\TwigBundle\Extension\AssetsExtension')->getAssetUrl("public/css/pages/all/login.css"), "html", null, true);
        echo "\">  
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
    
    ";
        // line 17
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 19
        echo "    </head>
<body>
    <script> 
      if (self == top) {
        var theBody = document.getElementsByTagName('body')[0]
        theBody.style.display = \"block\"
      } else { 
        top.location = self.location 
      }
    </script>
    <main class=\"main_container\">
        <div class=\"body_section login_page\">
            <div class=\"login_section\">
                <div class=\"gqa_logo\">\t\t\t\t
                    <img src=\"";
        // line 33
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bundle\TwigBundle\Extension\AssetsExtension')->getAssetUrl("public/images/logo.png"), "html", null, true);
        echo "\" alt=\"gqa-logo\" class=\"hidden-xs\"/>
                    <img src=\"";
        // line 34
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bundle\TwigBundle\Extension\AssetsExtension')->getAssetUrl("public/images/loginlogo.png"), "html", null, true);
        echo "\" alt=\"gqa-logo\" class=\"hidden-sm hidden-md hidden-lg\"/>
                </div>
                ";
        // line 36
        $this->displayBlock('content', $context, $blocks);
        // line 37
        echo "            </div>
        </div>
    </main>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js\"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src=\"";
        // line 43
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bundle\TwigBundle\Extension\AssetsExtension')->getAssetUrl("public/js/bootstrap.min.js"), "html", null, true);
        echo "\"></script>
\t<script src=\"";
        // line 44
        echo twig_escape_filter($this->env, $this->env->getExtension('Symfony\Bundle\TwigBundle\Extension\AssetsExtension')->getAssetUrl("public/js/jquery.validate.js"), "html", null, true);
        echo "\"></script>
   ";
        // line 45
        $this->displayBlock('javascripts', $context, $blocks);
        // line 47
        echo "  </body>
</html>";
    }

    // line 9
    public function block_title($context, array $blocks = array())
    {
    }

    // line 17
    public function block_stylesheets($context, array $blocks = array())
    {
        // line 18
        echo "   ";
    }

    // line 36
    public function block_content($context, array $blocks = array())
    {
    }

    // line 45
    public function block_javascripts($context, array $blocks = array())
    {
        // line 46
        echo "   ";
    }

    public function getTemplateName()
    {
        return "main.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  131 => 46,  128 => 45,  123 => 36,  119 => 18,  116 => 17,  111 => 9,  106 => 47,  104 => 45,  100 => 44,  96 => 43,  88 => 37,  86 => 36,  81 => 34,  77 => 33,  61 => 19,  59 => 17,  53 => 14,  49 => 13,  45 => 12,  41 => 11,  37 => 10,  33 => 9,  23 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "main.html.twig", "C:\\xampp\\htdocs\\onlinerpl\\app\\Resources\\views\\main.html.twig");
    }
}
