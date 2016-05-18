$script('http://code.jquery.com/jquery-1.11.3.min.js', 'jquery');
$script('https://ajax.googleapis.com/ajax/libs/angularjs/1.4.5/angular.min.js', 'angular');
$script('https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js', 'modernizr');

$script.ready('angular', function() {
    $script('[base-url]/js/ng.js');
});

$script.ready(\['jquery', 'modernizr'], function () {
    $script('https://cdn.jsdelivr.net/foundation/5.5.3/js/foundation.min.js', 'foundation');
});

$script.ready('foundation', function() {
    $(document).foundation();
});

