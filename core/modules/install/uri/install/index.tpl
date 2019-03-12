[module install forms admin]
[check-fresh-install]
[if not fresh_install="yes" redirect=errors/404]
[set step=1]
[set page-title="Installation Step [step]/3"]
[session-test]
[if session_ok=pass tpl=post]
[set app-name="Nimbly CMS"]
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
		<meta http-equiv="x-ua-compatible" content="ie=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>[page-title] | [app-name]</title>
        <style>
		    [include file=[base-path]core/uri/css/app.css/css/style.css]
		    
		    .progress-bar {
		        position: relative;
		        height: 1rem;
		        background-color: #eee;
		        margin-bottom: 1rem;
		    }
		    .progress-meter {
		        position: absolute;
		        height: 1rem;
		        background-color: #338e2d;
		    }

		    .callout {
		    	border-radius: 5px;
		    	padding: 10px!important;
		    	color: #fff;
		    	margin-bottom: 2em;
		    }

		    .callout.alert {
		    	background-color: #f44336;
		    	opacity: .8;
		    	font-weight: bold;
		    }
		</style>
        <link rel="shortcut icon" href="[base-url]/favicon.png" />
    </head>
    <body class="install">
        <div class="admin-wrapper">
            <div class="admin-body">
                <div class="admin-content">
                    [body-step]
                </div>
            </div>
        </div>
    </body>
</html>