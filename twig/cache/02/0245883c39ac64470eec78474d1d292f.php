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
        <div id=\"siteLogo\">FrontierToons</div>
        <nav id=\"navigation\">
            <ul id=\"navList\">
                <li class=\"navLink\"><a href=\"/catalog\">Comic Catalog</a></li>
                <li class=\"navLink\"><a href=\"#\">Adventures</a></li>
                <li class=\"navLink\"><a href=\"/register\">Become An Author</a></li>                
                <li class=\"navLink\"><a href=\"/catalog\">Comic Catalog</a></li>
                <li class=\"navLink\"><a href=\"#\">Blog</a></li>
            </ul>
            <ul id=\"navListRight\">
                <li class=\"navLinkRight\"><a href=\"/login\"><i class=\"fa-light fa-user-cowboy\"></i> Login</a></li>
                <li class=\"navLinkRight\"><a href=\"/login\"><i class=\"fa-kit fa-light-user-cowboy-circle-plus\"></i> Register</a></li>
                <li class=\"navLinkRight\"><i class=\"fa-light fa-magnifying-glass\"></i> Search</li>
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
    public function getDebugInfo(): array
    {
        return array (  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<header>
    <div id=\"headerWrapper\">
        <div id=\"siteLogo\">FrontierToons</div>
        <nav id=\"navigation\">
            <ul id=\"navList\">
                <li class=\"navLink\"><a href=\"/catalog\">Comic Catalog</a></li>
                <li class=\"navLink\"><a href=\"#\">Adventures</a></li>
                <li class=\"navLink\"><a href=\"/register\">Become An Author</a></li>                
                <li class=\"navLink\"><a href=\"/catalog\">Comic Catalog</a></li>
                <li class=\"navLink\"><a href=\"#\">Blog</a></li>
            </ul>
            <ul id=\"navListRight\">
                <li class=\"navLinkRight\"><a href=\"/login\"><i class=\"fa-light fa-user-cowboy\"></i> Login</a></li>
                <li class=\"navLinkRight\"><a href=\"/login\"><i class=\"fa-kit fa-light-user-cowboy-circle-plus\"></i> Register</a></li>
                <li class=\"navLinkRight\"><i class=\"fa-light fa-magnifying-glass\"></i> Search</li>
            </ul>
        </nav>
    </div>
</header>", "header.html", "/var/www/frontiertoons/templates/header.html");
    }
}
