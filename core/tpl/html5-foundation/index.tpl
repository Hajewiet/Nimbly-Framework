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
        [stylesheets]
        [style-tag]
        [script js/base.js]
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