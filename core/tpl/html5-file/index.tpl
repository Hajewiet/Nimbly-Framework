[set app-name=Waffle]
[set site-name=[app-name]]
[set language=en]
[set body-classes=page]
[set page-title=Home]
[set jquery-url="http://code.jquery.com/jquery-1.10.1.min.js"]
<!DOCTYPE html>
<html>
<head lang="[language]">
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>[page-title] | [site-name]</title>
[css-links]
[style-tag]
[script js/base.js]
</head>
<body class="[body-classes]">
[header]
[body]
[footer]
<script>
[scripts]
</script>
</body>
</html>