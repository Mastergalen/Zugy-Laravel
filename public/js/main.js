var app = angular.module('zugy.main', ['ngAnimate', 'ui.bootstrap', 'ngTouch']).controller('NavbarCtrl', function($scope) {
    $scope.navCollapsed = true;
    $scope.cartCollapsed = true;
});

angular.element(document).ready(function() {
    angular.bootstrap(document, ['zugy.main']);
});