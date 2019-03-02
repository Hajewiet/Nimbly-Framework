[module user]
[access feature=admin]
[set app-name="Nimbly Framework"]
[set site-name=[app-name]]
[set language=en]
[set body-classes=]
[set html-classes="logged-in admin-page"]
[set page-title=Admin]
[init]
<!doctype html>
<html class="[html-classes]" lang="[language]">
    <head>
        [meta]
        <title>[page-title] | [site-name]</title>
        [stylesheets]
        [scripts]
        [favicon]
    </head>
    <body class="[body-classes]">
        [role-cond user tpl=user-bar]
        <div class="admin-wrapper">
            <div class="admin-body">
                [callouts]
                <div class="admin-content">
                [body]
                </div>
            </div>
            <div class="admin-sidebar">                
                [role-cond admin tpl=admin-menu]
            </div>
        </div>
        <script>
            [load-scripts]
        </script>
    </body>
</html>
