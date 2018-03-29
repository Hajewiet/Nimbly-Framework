[set app-name="Nimbly Framework"]
[set site-name=[app-name]]
[set language=en]
[set body-classes=]
[set html-classes=]
[set page-title=Home]
[set head=]
[module user]
[init]
<!doctype html>
<html class="[html-classes]" lang="[language]">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>[page-title] | [site-name]</title>
        [stylesheets]
        [head]
        [scripts]
        [favicon]
    </head>
    <body class="[body-classes]">
        [role-cond user tpl=user-bar]
        [top]
        [page]
        [bottom]
        [left]
        [right]
        <script>
            [load-scripts]
        </script>
    </body>
</html>
