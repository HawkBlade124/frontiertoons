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
                <li class=\"navListLI\"><a class=\"navLink\" href=\"/register\">Become An Author</a></li>
                <li class=\"navListLI\"><a class=\"navLink\" href=\"/blog\">Blog</a></li>
                <li class=\"navListLI\"><i class=\"fa-light fa-magnifying-glass\"></i> Search</li>
            </ul>
            <ul id=\"navListRight\">                
                ";
        // line 12
        $context["loggedIn"] = ($context["logged_in"] ?? null);
        // line 13
        yield "                ";
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["users"] ?? null), "username", [], "any", false, false, false, 13), "html", null, true);
        yield "
                ";
        // line 14
        if ((($context["loggedIn"] ?? null) == true)) {
            // line 15
            yield "                    <li class=\"navLinkRight\"><a class=\"navLinkBtn\" href=\"/dashboard\" data-=\"loggedIn\"><i class=\"fa-slab fa-regular fa-circle-user\"></i> Your Profile</a></li>
                    ";
        } else {
            // line 17
            yield "                    <li class=\"navLinkRight\"><a class=\"navLinkBtn\" href=\"/login\"><i class=\"fa-jelly fa-regular fa-arrow-right-to-bracket\"></i> Login/Register</a></li>
                ";
        }
        // line 19
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
        return array (  72 => 19,  68 => 17,  64 => 15,  62 => 14,  57 => 13,  55 => 12,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<header>
    <div id=\"headerWrapper\">
        <div id=\"siteLogo\"><a href=\"/\">FrontierToons</a></div>
        <nav id=\"navigation\">
            <ul id=\"navList\">
                <li class=\"navListLI\"><a class=\"navLink\" href=\"/catalog\">Comic Catalog</a></li>                
                <li class=\"navListLI\"><a class=\"navLink\" href=\"/register\">Become An Author</a></li>
                <li class=\"navListLI\"><a class=\"navLink\" href=\"/blog\">Blog</a></li>
                <li class=\"navListLI\"><i class=\"fa-light fa-magnifying-glass\"></i> Search</li>
            </ul>
            <ul id=\"navListRight\">                
                {% set loggedIn = logged_in %}
                {{users.username}}
                {% if loggedIn == true %}
                    <li class=\"navLinkRight\"><a class=\"navLinkBtn\" href=\"/dashboard\" data-=\"loggedIn\"><i class=\"fa-slab fa-regular fa-circle-user\"></i> Your Profile</a></li>
                    {% else %}
                    <li class=\"navLinkRight\"><a class=\"navLinkBtn\" href=\"/login\"><i class=\"fa-jelly fa-regular fa-arrow-right-to-bracket\"></i> Login/Register</a></li>
                {% endif %}
                <li class=\"navLinkRight\"></li>
            </ul>
        </nav>
    </div>
</header>", "header.html", "/var/www/frontiertoons/templates/header.html");
    }
}
