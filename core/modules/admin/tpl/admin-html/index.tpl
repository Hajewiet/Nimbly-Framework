[module user]
[set app-name="Nimbly Framework"]
[set site-name=[app-name]]
[set language=en]
[set body-classes=]
[set html-classes="[logged-in]"]
[set page-title=Admin]
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
        <div class="wrapper">
            <div class="admin-body">
                [callouts]
                [body]
            </div>
            <div class="admin-sidebar">
                [role-cond admin tpl=admin-menu]
                [role-cond user tpl=user-menu]
            </div>
        </div>
        <script>
            [load-scripts]
        </script>
    </body>
</html>
