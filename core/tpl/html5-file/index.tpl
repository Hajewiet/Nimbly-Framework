[set app-name="Nimbly Framework"]
[set site-name=[app-name]]
[set language=en]
[set body-classes=page]
[set page-title=Home]
<!DOCTYPE html>
<html>
    <head lang="[language]">
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>[page-title] | [site-name]</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/foundation/5.5.3/css/foundation.min.css">
        <link rel="stylesheet" href="[base-url]/css/app.css">
        [style-tag]
        [script js/base.js]
    </head>
    <body class="[body-classes]">
        [header]
        [body]
        [footer]
        <script>
            $script('http://code.jquery.com/jquery-1.11.3.min.js', 'jquery');
            $script('https://ajax.googleapis.com/ajax/libs/angularjs/1.4.5/angular.min.js', 'angular');
            $script('https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js', 'modernizr');
            $script('[base-url]/js/ng.js');
            $script.ready(\['jquery', 'modernizr'], function () {
                $script('https://cdn.jsdelivr.net/foundation/5.5.3/js/foundation.min.js', 'foundation');
            });
            $script.ready('foundation', function() {
                $(document).foundation();
            });
        </script>
    </body>
</html>