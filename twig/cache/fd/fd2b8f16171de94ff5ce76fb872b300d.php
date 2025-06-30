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
    <script src=\"https://code.jquery.com/jquery-3.7.1.js\" integrity=\"sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=\" crossorigin=\"anonymous\"></script>
    <script src=\"https://code.jquery.com/ui/1.14.1/jquery-ui.js\" integrity=\"sha256-9zljDKpE/mQxmaR4V2cGVaQ7arF3CcXxarvgr7Sj8Uc=\" crossorigin=\"anonymous\"></script>
    <script src=\"https://unpkg.com/vue@3/dist/vue.global.js\"></script>    
    <link rel=\"stylesheet\" href=\"../assets/css/master.css\">
    <link rel=\"stylesheet\" href=\"../assets/css/fonts.css\">
    <script src=\"../assets/js/master.js\"></script>
    <script src=\"https://kit.fontawesome.com/15b6d67935.js\" crossorigin=\"anonymous\"></script>    
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />
</head>
<body>
    <script>
        window.addEventListener('load', function () {
            document.getElementById('preloader').style.display = 'none';
        });
    </script>
    <style>
        #preloader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #fff; /* or dark background */
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        }

        .spinner {
        width: 50px;
        height: 50px;
        border: 5px solid #ccc;
        border-top-color: #333;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        }

        @keyframes spin {
        to {
            transform: rotate(360deg);
        }
        }

    </style>
    <div id=\"preloader\">
  <div class=\"spinner\"></div>
</div>

    ";
        // line 54
        yield from $this->load("header.html", 54)->unwrap()->yield($context);
        // line 55
        yield "    
       ";
        // line 56
        yield from $this->unwrap()->yieldBlock('content', $context, $blocks);
        // line 59
        yield "
    ";
        // line 60
        yield from $this->load("footer.html", 60)->unwrap()->yield($context);
        // line 61
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

    // line 56
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_content(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 57
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
        return array (  139 => 57,  132 => 56,  121 => 4,  114 => 61,  112 => 60,  109 => 59,  107 => 56,  104 => 55,  102 => 54,  49 => 4,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("<!DOCTYPE html>
<html>
<head>
    <title>{% block title %}Default Title{% endblock %}</title>
    <script src=\"https://code.jquery.com/jquery-3.7.1.js\" integrity=\"sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=\" crossorigin=\"anonymous\"></script>
    <script src=\"https://code.jquery.com/ui/1.14.1/jquery-ui.js\" integrity=\"sha256-9zljDKpE/mQxmaR4V2cGVaQ7arF3CcXxarvgr7Sj8Uc=\" crossorigin=\"anonymous\"></script>
    <script src=\"https://unpkg.com/vue@3/dist/vue.global.js\"></script>    
    <link rel=\"stylesheet\" href=\"../assets/css/master.css\">
    <link rel=\"stylesheet\" href=\"../assets/css/fonts.css\">
    <script src=\"../assets/js/master.js\"></script>
    <script src=\"https://kit.fontawesome.com/15b6d67935.js\" crossorigin=\"anonymous\"></script>    
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\" />
</head>
<body>
    <script>
        window.addEventListener('load', function () {
            document.getElementById('preloader').style.display = 'none';
        });
    </script>
    <style>
        #preloader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #fff; /* or dark background */
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        }

        .spinner {
        width: 50px;
        height: 50px;
        border: 5px solid #ccc;
        border-top-color: #333;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        }

        @keyframes spin {
        to {
            transform: rotate(360deg);
        }
        }

    </style>
    <div id=\"preloader\">
  <div class=\"spinner\"></div>
</div>

    {% include 'header.html' %}
    
       {% block content %}
        Default content
        {% endblock %}

    {% include 'footer.html' %}
</body>
</html>
", "base.index.html", "/var/www/frontiertoons/templates/base.index.html");
    }
}
