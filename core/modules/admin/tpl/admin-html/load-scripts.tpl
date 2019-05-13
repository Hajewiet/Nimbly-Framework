$script('https://code.jquery.com/jquery-3.3.1.min.js', 'jquery');

$script.ready('jquery', function() {
    $script('[base-url]/js/app.js?v=[app-modified]', 'app');
});

[feature-cond edit tpl=edit-script]
