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

        <div id=\"siteLogo\">
            <a :href=\"homeUrl\">FrontierToons</a>
        </div>
 
        <nav id=\"navigation\">
            <div id=\"nav\">
                <ul id=\"navList\">
                    <li class=\"navListLI\" :class=\"{ active: current === 'catalog' }\">
                        <a class=\"navLink\" href=\"/catalog\" @click=\"current = 'catalog'\">Comic Catalog</a>
                    </li>
                    <li class=\"navListLI\" :class=\"{ active: current === 'register' }\">
                        <a class=\"navLink\" href=\"/register\" @click=\"current = 'register'\">Become An Author</a>
                    </li>
                    <li class=\"navListLI\" :class=\"{ active: current === 'about' }\">
                        <a class=\"navLink\" href=\"/about\" @click=\"current = 'about'\">About Us</a>
                    </li>
                    <li class=\"navListLI\" :class=\"{ active: current === 'contact' }\">
                        <a class=\"navLink\" href=\"/contact\" @click=\"current = 'contact'\">Contact Us</a>
                    </li>
                    <li class=\"navListLI\" :class=\"{ active: current === 'blog' }\">
                        <a class=\"navLink\" href=\"/blog\" @click=\"current = 'blog'\">Blog</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div id=\"navListRight\">                
                ";
        // line 30
        $context["loggedIn"] = ($context["logged_in"] ?? null);
        yield "                
                ";
        // line 31
        if ((($context["loggedIn"] ?? null) == true)) {
            yield "                   
                    <div class=\"navLinkRight\" :class=\"{ active: current === 'dashboard' }\">
                        <a class=\"navLinkBtn\" href=\"/dashboard\" @click=\"current = 'dashboard'\">
                            <i class=\"fa-slab fa-regular fa-circle-user\"></i>  ";
            // line 34
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, ($context["session"] ?? null), "Username", [], "any", false, false, false, 34), "html", null, true);
            yield "
                        </a>
                    </div>
                    <div class=\"navLinkRight\" :class=\"{ active: current === 'favorites' }\">
                        <a class=\"navLinkBtn\" href=\"/favorites\" @click=\"current = 'favorites'\" >
                            <i class=\"fa-slab fa-regular fa-heart\"></i>
                        </a>
                    </div>
                    ";
        } else {
            // line 43
            yield "                    <div class=\"navLinkRight\" :class=\"{ active: current === 'login' }\">
                        <a class=\"navLinkBtn\" href=\"/login\" @click=\"current = 'login'\" >
                            <i class=\"fa-jelly fa-regular fa-arrow-right-to-bracket\"></i> Login
                        </a>
                    </div>

                ";
        }
        // line 50
        yield "                <div class=\"searchWrapper\">
                    <button class=\"search\" type=\"submit\"><i class=\"fa-slab fa-regular fa-magnifying-glass\"></i></button>
                    <form action=\"/catalog\" method=\"POST\">                            
                        <input type=\"text\">
                    </form>
                </div>
        </div>
    </div>
</header>


<script>
    const { createApp } = Vue;

    createApp({
        data() {
            return {
                current: '";
        // line 67
        yield (((CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["app"] ?? null), "request", [], "any", false, true, false, 67), "attributes", [], "any", false, true, false, 67), "get", ["_route"], "method", true, true, false, 67) &&  !(null === CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["app"] ?? null), "request", [], "any", false, false, false, 67), "attributes", [], "any", false, false, false, 67), "get", ["_route"], "method", false, false, false, 67)))) ? ($this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["app"] ?? null), "request", [], "any", false, false, false, 67), "attributes", [], "any", false, false, false, 67), "get", ["_route"], "method", false, false, false, 67), "html", null, true)) : (""));
        yield "',
                logoText: 'FrontierToons',
                homeUrl: '/'
            }
        }
    }).mount('#headerWrapper');

</script>";
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
        return array (  123 => 67,  104 => 50,  95 => 43,  83 => 34,  77 => 31,  73 => 30,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<header>
    <div id=\"headerWrapper\">

        <div id=\"siteLogo\">
            <a :href=\"homeUrl\">FrontierToons</a>
        </div>
 
        <nav id=\"navigation\">
            <div id=\"nav\">
                <ul id=\"navList\">
                    <li class=\"navListLI\" :class=\"{ active: current === 'catalog' }\">
                        <a class=\"navLink\" href=\"/catalog\" @click=\"current = 'catalog'\">Comic Catalog</a>
                    </li>
                    <li class=\"navListLI\" :class=\"{ active: current === 'register' }\">
                        <a class=\"navLink\" href=\"/register\" @click=\"current = 'register'\">Become An Author</a>
                    </li>
                    <li class=\"navListLI\" :class=\"{ active: current === 'about' }\">
                        <a class=\"navLink\" href=\"/about\" @click=\"current = 'about'\">About Us</a>
                    </li>
                    <li class=\"navListLI\" :class=\"{ active: current === 'contact' }\">
                        <a class=\"navLink\" href=\"/contact\" @click=\"current = 'contact'\">Contact Us</a>
                    </li>
                    <li class=\"navListLI\" :class=\"{ active: current === 'blog' }\">
                        <a class=\"navLink\" href=\"/blog\" @click=\"current = 'blog'\">Blog</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div id=\"navListRight\">                
                {% set loggedIn = logged_in %}                
                {% if loggedIn == true %}                   
                    <div class=\"navLinkRight\" :class=\"{ active: current === 'dashboard' }\">
                        <a class=\"navLinkBtn\" href=\"/dashboard\" @click=\"current = 'dashboard'\">
                            <i class=\"fa-slab fa-regular fa-circle-user\"></i>  {{session.Username}}
                        </a>
                    </div>
                    <div class=\"navLinkRight\" :class=\"{ active: current === 'favorites' }\">
                        <a class=\"navLinkBtn\" href=\"/favorites\" @click=\"current = 'favorites'\" >
                            <i class=\"fa-slab fa-regular fa-heart\"></i>
                        </a>
                    </div>
                    {% else %}
                    <div class=\"navLinkRight\" :class=\"{ active: current === 'login' }\">
                        <a class=\"navLinkBtn\" href=\"/login\" @click=\"current = 'login'\" >
                            <i class=\"fa-jelly fa-regular fa-arrow-right-to-bracket\"></i> Login
                        </a>
                    </div>

                {% endif %}
                <div class=\"searchWrapper\">
                    <button class=\"search\" type=\"submit\"><i class=\"fa-slab fa-regular fa-magnifying-glass\"></i></button>
                    <form action=\"/catalog\" method=\"POST\">                            
                        <input type=\"text\">
                    </form>
                </div>
        </div>
    </div>
</header>


<script>
    const { createApp } = Vue;

    createApp({
        data() {
            return {
                current: '{{ app.request.attributes.get(\"_route\") ?? \"\" }}',
                logoText: 'FrontierToons',
                homeUrl: '/'
            }
        }
    }).mount('#headerWrapper');

</script>", "header.html", "/var/www/frontiertoons/templates/header.html");
    }
}
