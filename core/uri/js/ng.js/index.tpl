[bootstrap-modules]

var nimbly_ng_app = angular.module("nimbly_ng", \[]);

/* custom scripts, e.g. controllers */

[ng-scripts]


/* start angular */

angular.element(document).ready(function() {
    angular.bootstrap(document, \["nimbly_ng"]);
});