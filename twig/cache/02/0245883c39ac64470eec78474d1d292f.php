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

/* header.html */
class __TwigTemplate_a86b7be2021bc2b5ca6a9defbc709aaa extends Template
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
        yield "<header>
    <div id=\"headerWrapper\">
        <div id=\"siteLogo\"><a href=\"/\">FrontierToons</a></div>
        <nav id=\"navigation\">
            <ul id=\"navList\">
                <li class=\"navListLI\"><a class=\"navLink\" href=\"/catalog\">Comic Catalog</a></li>
                <li class=\"navListLI\"><a class=\"navLink\" href=\"/catalog\">Adventures</a></li>
                <li class=\"navListLI\"><a class=\"navLink\" href=\"/register\">Become An Author</a></li>                
                <li class=\"navListLI\"><a class=\"navLink\" href=\"/catalog\">Comic Catalog</a></li>
                <li class=\"navListLI\"><a class=\"navLink\" href=\"https://blog.frontiertoons.com\">Blog</a></li>
                <li class=\"navListLI\"><i class=\"fa-light fa-magnifying-glass\"></i> Search</li>
            </ul>
            <ul id=\"navListRight\">                
                ";
        // line 14
        $context["loggedIn"] = ($context["logged_in"] ?? null);
        yield "                                
                ";
        // line 15
        if ((($context["loggedIn"] ?? null) == true)) {
            // line 16
            yield "                    <li class=\"navLinkRight\"><a class=\"navLinkBtn\" href=\"/dashboard\"><i class=\"fa-light fa-circle-user\"></i>Your Profile</a></li>
                    ";
        } else {
            // line 18
            yield "                    <li class=\"navLinkRight\"><a class=\"navLinkBtn\" href=\"/login\"><i class=\"fa-light fa-user-cowboy\"></i> Login/Register</a></li>
                ";
        }
        // line 20
        yield "                <li class=\"navLinkRight\"></li>
            </ul>
        </nav>
    </div>
</header>";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "header.html";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  71 => 20,  67 => 18,  63 => 16,  61 => 15,  57 => 14,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<header>
    <div id=\"headerWrapper\">
        <div id=\"siteLogo\"><a href=\"/\">FrontierToons</a></div>
        <nav id=\"navigation\">
            <ul id=\"navList\">
                <li class=\"navListLI\"><a class=\"navLink\" href=\"/catalog\">Comic Catalog</a></li>
                <li class=\"navListLI\"><a class=\"navLink\" href=\"/catalog\">Adventures</a></li>
                <li class=\"navListLI\"><a class=\"navLink\" href=\"/register\">Become An Author</a></li>                
                <li class=\"navListLI\"><a class=\"navLink\" href=\"/catalog\">Comic Catalog</a></li>
                <li class=\"navListLI\"><a class=\"navLink\" href=\"https://blog.frontiertoons.com\">Blog</a></li>
                <li class=\"navListLI\"><i class=\"fa-light fa-magnifying-glass\"></i> Search</li>
            </ul>
            <ul id=\"navListRight\">                
                {% set loggedIn = logged_in %}                                
                {% if loggedIn == true %}
                    <li class=\"navLinkRight\"><a class=\"navLinkBtn\" href=\"/dashboard\"><i class=\"fa-light fa-circle-user\"></i>Your Profile</a></li>
                    {% else %}
                    <li class=\"navLinkRight\"><a class=\"navLinkBtn\" href=\"/login\"><i class=\"fa-light fa-user-cowboy\"></i> Login/Register</a></li>
                {% endif %}
                <li class=\"navLinkRight\"></li>
            </ul>
        </nav>
    </div>
</header>", "header.html", "/var/www/frontiertoons/templates/header.html");
    }
}
