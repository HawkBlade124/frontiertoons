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

/* base.index.html */
class __TwigTemplate_ce62608e6e8a1be953d57f9138296cb0 extends Template
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
            'title' => [$this, 'block_title'],
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield "<!DOCTYPE html>
<html>
<head>
    <title>";
        // line 4
        yield from $this->unwrap()->yieldBlock('title', $context, $blocks);
        yield "</title>
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />
    <script src=\"https://code.jquery.com/jquery-3.7.1.js\" integrity=\"sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=\" crossorigin=\"anonymous\"></script>
    <script src=\"https://code.jquery.com/ui/1.14.1/jquery-ui.js\" integrity=\"sha256-9zljDKpE/mQxmaR4V2cGVaQ7arF3CcXxarvgr7Sj8Uc=\" crossorigin=\"anonymous\"></script>
    <script src=\"https://unpkg.com/vue@3/dist/vue.global.js\"></script>
    <link rel=\"stylesheet\" href=\"../assets/css/master.css\">
    <script src=\"https://kit.fontawesome.com/15b6d67935.js\" crossorigin=\"anonymous\"></script>
    <script src=\"/assets/js/functions/master.js\"></script>    
    <script src=\"/assets/js/functions/UserFunctions.js\"></script>        
    <script src=\"/assets/js/functions/popovers.js\"></script> 
    <script src=\"https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js\"></script>
</head>
<div id=\"popup\" style=\"display:none\"></div>
<body>
    
    ";
        // line 19
        if ((($context["hideHeaderFooter"] ?? null) == false)) {
            // line 20
            yield "        ";
            yield from $this->load("header.html", 20)->unwrap()->yield($context);
            // line 21
            yield "    ";
        }
        // line 22
        yield "       ";
        yield from $this->unwrap()->yieldBlock('content', $context, $blocks);
        // line 25
        yield "    ";
        if ((($context["hideHeaderFooter"] ?? null) == false)) {
            // line 26
            yield "        ";
            yield from $this->load("footer.html", 26)->unwrap()->yield($context);
            // line 27
            yield "    ";
        }
        // line 28
        yield "</body>
</html>
";
        yield from [];
    }

    // line 4
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_title(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Default Title";
        yield from [];
    }

    // line 22
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 23
        yield "        Default content
        ";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "base.index.html";
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
        return array (  112 => 23,  105 => 22,  94 => 4,  87 => 28,  84 => 27,  81 => 26,  78 => 25,  75 => 22,  72 => 21,  69 => 20,  67 => 19,  49 => 4,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<!DOCTYPE html>
<html>
<head>
    <title>{% block title %}Default Title{% endblock %}</title>
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />
    <script src=\"https://code.jquery.com/jquery-3.7.1.js\" integrity=\"sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=\" crossorigin=\"anonymous\"></script>
    <script src=\"https://code.jquery.com/ui/1.14.1/jquery-ui.js\" integrity=\"sha256-9zljDKpE/mQxmaR4V2cGVaQ7arF3CcXxarvgr7Sj8Uc=\" crossorigin=\"anonymous\"></script>
    <script src=\"https://unpkg.com/vue@3/dist/vue.global.js\"></script>
    <link rel=\"stylesheet\" href=\"../assets/css/master.css\">
    <script src=\"https://kit.fontawesome.com/15b6d67935.js\" crossorigin=\"anonymous\"></script>
    <script src=\"/assets/js/functions/master.js\"></script>    
    <script src=\"/assets/js/functions/UserFunctions.js\"></script>        
    <script src=\"/assets/js/functions/popovers.js\"></script> 
    <script src=\"https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js\"></script>
</head>
<div id=\"popup\" style=\"display:none\"></div>
<body>
    
    {% if hideHeaderFooter == false %}
        {% include 'header.html' %}
    {% endif %}
       {% block content %}
        Default content
        {% endblock %}
    {% if hideHeaderFooter == false %}
        {% include 'footer.html' %}
    {% endif %}
</body>
</html>
", "base.index.html", "/var/www/frontiertoons/templates/base.index.html");
    }
}
