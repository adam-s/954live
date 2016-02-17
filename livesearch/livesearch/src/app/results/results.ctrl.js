(function() {
    angular.module('livesearch')
        .controller('LivesearchResultsCtrl', LivesearchResultsCtrl);

    LivesearchResultsCtrl.$inject = ['$scope', 'LivesearchResults'];

    function LivesearchResultsCtrl($scope, LivesearchResults) {
        vm = this;
        vm.result = {};

        $scope.$watch(function() {
            return LivesearchResults.getResults();
        }, function (newValue, oldValue) {
            vm.result = newValue;
        })
    }
})();