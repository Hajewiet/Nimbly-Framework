[module user]
[access feature=manage-content,admin]
[set app-name="Nimbly Framework"]
[set site-name=[app-name]]
[set language=en]
[set body=]
[set init=]
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
        [nimbly-bar]
        [mobile-editor-menu]
        <div class="admin-wrapper">
            <a class="only-sm mobile-menu-link" data-push="#off-left-panel">&#9776; menu/a>
            <div class="admin-body">
                [callouts]
                <div class="admin-content">
                    [body]
                </div>
            </div>
            <div class="admin-sidebar no-mobile">                
                [editor-menu]
            </div>
        </div>
        <script>
            [load-scripts]
        </script>
    </body>
</html>
