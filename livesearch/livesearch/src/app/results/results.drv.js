(function() {
    angular.module('livesearch')
        .directive('livesearchResults', livesearchResults);

    livesearchResults.$inject = [];

    function livesearchResults() {
        var directive = {
            restrict: 'EA',
            controller: 'LivesearchResultsCtrl',
            controllerAs: 'vm',
            bindToController: true,
            scope: {},
            templateUrl: 'src/app/results/results.tpl.html'
        };

        return directive;
    }
})();