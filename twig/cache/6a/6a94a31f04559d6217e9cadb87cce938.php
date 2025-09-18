<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* footer.html */
class __TwigTemplate_7e2f22defec6ec8c2b7812f48df440a5 extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield "<footer>    
    <div id=\"footerWrap\">
        <div id=\"footerTop\">
            <div class=\"footCol\">
                <h2><a href=\"/\">FrontierToons</a></h2>            
            </div>        
            <div class=\"footCol\">
                <h3>Quick Links</h3>
                <ul class=\"footLinkList\">
                    <li class=\"footerLink\"><a href=\"\">Home</a></li>
                    <li class=\"footerLink\"><a href=\"\">About Us</a></li>
                    <li class=\"footerLink\"><a href=\"\">Catalog</a></li>
                    <li class=\"footerLink\"><a href=\"\">Author List</a></li>
                </ul>            
            </div>
            <div class=\"footCol\">
                <h3>Keep Up to Date</h3>
                <ul class=\"footLinkList\">                
                    <li class=\"footerLink\"><a href=\"\">What Makes Us Different</a></li>                
                    <li class=\"footerLink\"><a href=\"\">FAQ</a></li>
                    <li class=\"footerLink\"><a href=\"\">Blog</a></li>
                </ul>            
            </div>
            <div class=\"footCol\">           
                <h3>Legal</h3>
                <ul class=\"footLinkList\">
                    <li class=\"footerLink\"><a href=\"\">Terms of Use</a></li>
                    <li class=\"footerLink\"><a href=\"\">Privacy Policy</a></li>
                </ul>
            </div>
            <div class=\"footCol\">           
                <h3>Sign Up For Our Newsletter</h3>                
<div class=\"ml-embedded\" data-form=\"sDUfut\"></div>
  
  
      <script src=\"https://groot.mailerlite.com/js/w/webforms.min.js?v176e10baa5e7ed80d35ae235be3d5024\" type=\"text/javascript\"></script>
        <script>
            fetch(\"https://assets.mailerlite.com/jsonp/1752054/forms/163471664729818976/takel\")
        </script>
            </div>
        </div>
        <div id=\"copyright\">
            &copy; 2025 Benjamin Fuller <a href=\"frontiertoons@gmail.com\">FrontierToons@gmail.com</a>
        </div>
    </div>

</footer>";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "footer.html";
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<footer>    
    <div id=\"footerWrap\">
        <div id=\"footerTop\">
            <div class=\"footCol\">
                <h2><a href=\"/\">FrontierToons</a></h2>            
            </div>        
            <div class=\"footCol\">
                <h3>Quick Links</h3>
                <ul class=\"footLinkList\">
                    <li class=\"footerLink\"><a href=\"\">Home</a></li>
                    <li class=\"footerLink\"><a href=\"\">About Us</a></li>
                    <li class=\"footerLink\"><a href=\"\">Catalog</a></li>
                    <li class=\"footerLink\"><a href=\"\">Author List</a></li>
                </ul>            
            </div>
            <div class=\"footCol\">
                <h3>Keep Up to Date</h3>
                <ul class=\"footLinkList\">                
                    <li class=\"footerLink\"><a href=\"\">What Makes Us Different</a></li>                
                    <li class=\"footerLink\"><a href=\"\">FAQ</a></li>
                    <li class=\"footerLink\"><a href=\"\">Blog</a></li>
                </ul>            
            </div>
            <div class=\"footCol\">           
                <h3>Legal</h3>
                <ul class=\"footLinkList\">
                    <li class=\"footerLink\"><a href=\"\">Terms of Use</a></li>
                    <li class=\"footerLink\"><a href=\"\">Privacy Policy</a></li>
                </ul>
            </div>
            <div class=\"footCol\">           
                <h3>Sign Up For Our Newsletter</h3>                
<div class=\"ml-embedded\" data-form=\"sDUfut\"></div>
  
  
      <script src=\"https://groot.mailerlite.com/js/w/webforms.min.js?v176e10baa5e7ed80d35ae235be3d5024\" type=\"text/javascript\"></script>
        <script>
            fetch(\"https://assets.mailerlite.com/jsonp/1752054/forms/163471664729818976/takel\")
        </script>
            </div>
        </div>
        <div id=\"copyright\">
            &copy; 2025 Benjamin Fuller <a href=\"frontiertoons@gmail.com\">FrontierToons@gmail.com</a>
        </div>
    </div>

</footer>", "footer.html", "/var/www/frontiertoons/templates/footer.html");
    }
}
