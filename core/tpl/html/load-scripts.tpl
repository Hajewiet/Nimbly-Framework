$script('http://code.jquery.com/jquery-1.11.3.min.js', 'jquery');
$script('https://cdn.jsdelivr.net/what-input/2.1.0/what-input.min.js', 'what-input');

$script.ready(\['jquery', 'what-input'], function () {
    $script('https://cdn.jsdelivr.net/foundation/6.2.1/foundation.min.js', 'foundation');
});

$script.ready('foundation', function() {
    $(document).foundation();
});
