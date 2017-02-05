[set app-name="Nimbly Framework"]
[set site-name=[app-name]]
[set language=en]
[set body-classes=]
[set html-classes=no-js]
[set page-title=Home]
<!doctype html>
<html class="[html-classes]" lang="[language]">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>[page-title] | [site-name]</title>
        [stylesheets]
        [style-tag]
		[base-script]
        <link rel="shortcut icon" href="[base-url]/favicon.png" />
    </head>
    <body class="[body-classes]">
        [header]
        [system-messages]
        [body]
        [footer]
        <script>
            [load-scripts]
        </script>
    </body>
</html>