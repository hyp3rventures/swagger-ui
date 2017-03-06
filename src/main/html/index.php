<?php
    session_start();
    if(empty($_SESSION["authenticated"]) || $_SESSION["authenticated"] != 'true') {
        header('Location: login.php');
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Swagger explorer</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="images/logo.png">

    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <!--style type="text/css"></style-->

    <link href="css/index.css" rel="stylesheet"/>
    <link href='css/standalone.css' rel='stylesheet'/>
    <link href='css/api-explorer.css' rel='stylesheet' type='text/css'/>
    <link href='css/screen.css' media='screen' rel='stylesheet' type='text/css'/>
    <link href="css/font-awesome.min.css" rel="stylesheet"/>

    <script src='lib/jquery-1.8.0.min.js' type='text/javascript'></script>
    <script src='lib/jquery.slideto.min.js' type='text/javascript'></script>
    <script src='lib/jquery.wiggle.min.js' type='text/javascript'></script>
    <script src='lib/jquery.ba-bbq.min.js' type='text/javascript'></script>
    <script src='lib/handlebars-2.0.0.js' type='text/javascript'></script>
    <script src='lib/underscore-min.js' type='text/javascript'></script>
    <script src='lib/backbone-min.js' type='text/javascript'></script>
    <script src='swagger-ui.min.js' type='text/javascript'></script>
    <script src='lib/jsoneditor.js' type='text/javascript'></script>
    <script src='lib/highlight.7.3.pack.js' type='text/javascript'></script>
    <script src='lib/marked.js' type='text/javascript'></script>
    <script src='lib/swagger-oauth.js' type='text/javascript'></script>
    <script src='lib/bootstrap.min.js' type='text/javascript'></script>

    <script type="text/javascript">
        $(function () {
            window.swaggerUi = new SwaggerUi({
                url: 'https://app-staging.hyp3r.co/api/v1/swagger_doc',
                dom_id: "swagger-ui-container",
                supportedSubmitMethods: ['get', 'post', 'put', 'delete', 'patch'],
                onComplete: function (swaggerApi, swaggerUi) {
                    if (typeof initOAuth == "function") {

                        initOAuth({
                            clientId: "ffe7748a-3a3f-4860-a02a-42ab08e4fde2",
                            realm: "realm",
                            appName: "Swagger"
                        });

                    }

                    $('pre code').each(function (i, e) {
                        hljs.highlightBlock(e)
                    });

                    if (swaggerUi.options.url) {
                        $('#input_baseUrl').val(swaggerUi.options.url);
                    }
                    if (swaggerUi.options.apiKey) {
                        $('#input_apiKey').val(swaggerUi.options.apiKey);
                    }

                    $('.sticky-nav [data-resource]').click(function () {
                        scrollBy(0, -66);
                    });

                    $("[data-toggle='tooltip']").tooltip();

                    addApiKeyAuthorization();
                },
                onFailure: function (data) {
                    log("Unable to Load SwaggerUI");
                },
                docExpansion: "none",
                sorter: "alpha"
            });

            function addApiKeyAuthorization() {
                var key = encodeURIComponent($('#input_apiKey')[0].value);
                if (key && key.trim() != "") {
                    var apiKeyAuth = new SwaggerClient.ApiKeyAuthorization("Authorization", "Bearer " + key, "header");
                    window.swaggerUi.api.clientAuthorizations.add("key", apiKeyAuth);
                    log("added key " + key);
                }
            }

            $('#input_apiKey').change(addApiKeyAuthorization);
            // if you have an apiKey you would like to pre-populate on the page for demonstration purposes...
            /*
             var apiKey = "myApiKeyXXXX123456789";
             $('#input_apiKey').val(apiKey);
             */

            window.swaggerUi.load();

            function log() {
                if ('console' in window) {
                    console.log.apply(console, arguments);
                }
            }
        });
    </script>
    <script src="js/custom.js" type="text/javascript"></script>
</head>

<body class="page-docs" style="zoom: 1;" data-spy="scroll" data-target="#navbar-collapse" data-offset="110">
<header class="site-header">
    <nav role="navigation" class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" data-toggle="collapse" data-target="#navbar-collapse" class="navbar-toggle"><span
                        class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span
                        class="icon-bar"></span><span class="icon-bar"></span></button>
                <h1 class="navbar-brand"><a href="http://hyp3r.com"><img alt="Hyp3r" src="images/brand-logo.png"></a></h1>
            </div>
            <div id="navbar-collapse" class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a class="scroll_link" href="#Section_Header_Overview">Overview</a></li>
                    <li><a class="scroll_link" href="#Section_Header_Auth">Authentication</a></li>
                    <li><a class="scroll_link" href="#Section_Header_Conventions">API Conventions</a></li>
                    <li><a class="scroll_link" href="#Section_Header_API">API Endpoints</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user-circle-o" aria-hidden="true"></i> <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#"><i class="fa fa-key fa-fw" aria-hidden="true"></i>&nbsp; API Keys</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="/logout"><i class="fa fa-sign-out fa-fw" aria-hidden="true"></i>&nbsp; Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<section class="container">
    <div class="row">
        <h2 id="Section_Header_Overview">Introduction</h2>
        <p>
        The Hyp3r API is organized around <a href="http://en.wikipedia.org/wiki/Representational_State_Transfer">REST</a>. Our API has predictable, resource-oriented URLs, and uses HTTP response codes to indicate API errors. We use built-in HTTP features, like HTTP authentication and HTTP verbs, which are understood by off-the-shelf HTTP clients. We support <a href="http://en.wikipedia.org/wiki/Cross-origin_resource_sharing">cross-origin resource sharing</a>, allowing you to interact securely with our API from a client-side web application (though you should never expose your secret API key in any public website's client-side code). <a href="http://www.json.org/">JSON</a> is returned by all API responses, including errors.
      </p>
      <p style="color: lightgray">
        To make the API as explorable as possible, accounts have test mode and live mode API keys. There is no "switch" for changing between modes, just use the appropriate key to perform a live or test transaction.
      </p>

    </div>
    <hr>
    <div class="row">
        <h2 id="Section_Header_Auth">Authentication</h2>
        <p>
            Authentication is performed via two custom HYP3R headers and all requests must be made over HTTPS.
        </p>
        <p>
            The two required headers are <code>X-Entity-Email</code> and <code>X-Entity-Token</code>. Requests that
            require authentication will return <code>401 Unauthorized</code> if the credentials are invalid and
            <code>403 Forbidden</code> if the resource is not available to your credentials. In some instances, the
            API may also return <code>404 Not Found</code> if the resource is not associated with your credentials.
        </p>
        <p>
            Below is a sample curl request to test your credentials:
        </p>
        <div class="swagger-section">
            <pre>

curl -H 'X-Entity-Email: developer@hyp3r.com' -H 'X-Entity-Token: 108cc33ac430856e6bfc06c92e4aa782' -H 'Accept: application/json' 'https://app-staging.hyp3r.co/api/v1/venues/all?organization_id=1'
            </pre>
        </div>
    </div>
    <hr>
    <div class="row">
        <h2 id="Section_Header_Conventions">API Conventions</h2>
        <h4>Pagination</h4>
        <p>
            Requests that return multiple items will be paginated to 27 items by default. You can specify
            further pages with the <code>page</code> parameter. You can also set a custom page size up to 200 with the
            <code>per_page</code> parameter. More details are specified per resource in the
            <a class="scroll_link" href="#Section_Header_API">API Endpoints</a>.
        </p>
        <div class="swagger-section">
            <pre><code class="json"><span class="value">  {
    "<span class="attribute">number</span>": <span class="value"><span class="number">0</span></span>,
    "<span class="attribute">size</span>": <span class="value"><span class="number">0</span></span>,
    "<span class="attribute">totalElements</span>": <span class="value"><span class="number">0</span></span>,
    "<span class="attribute">totalPages</span>": <span class="value"><span class="number">0</span>
  }</span></span></code></pre>
        </div>
        <p>Note that page numbering is 0-based and that omitting the <code>page</code> parameter will return the first page.</p>
        <h4>HTTP Status Codes</h4>

        <p>
        The API uses conventional HTTP response codes to indicate the
        success or failure of an API request.  In general,
        codes in the <code>2xx</code> range indicate success, codes in the
        <code>4xx</code> range indicate an error that failed given the
        information provided (e.g., a required parameter was
        omitted, a charge failed, etc.), and codes in the <code>5xx</code>
        range indicate an error with the servers.
        </p>
    </div>
    <hr>
    <div class="row">
        <h2 id="Section_Header_API">API Endpoints</h2>
        <p>
            Before diving into the endpoints, please review the sections above for an overview of high-level concepts and
            use cases.
        </p>
    </div>
</section>
<section class="content">
    <div id="api2-explorer">
        <div class="swagger-section page-docs" style="zoom: 1">
            <div class="main-section">
                <div id="swagger-ui-container" class="swagger-ui-wrap">
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>
