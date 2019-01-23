[module user]
[set app-name="Nimbly Framework"]
[set site-name=[app-name]]
[set language=en]
[set body-classes=]
[set html-classes="[logged-in]"]
[set page-title=Home]
[set head=]
[init]
<!doctype html>
<html class="[html-classes]" lang="[language]">
    <head>
        [meta]
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
