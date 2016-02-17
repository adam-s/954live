(function() {
    angular.module('livesearch')
        .directive('livesearchForm', livesearchForm);

    livesearchForm.$inject = [];

    function livesearchForm() {
        var directive = {
            restrict: 'EA',
            controller: 'LivesearchFormCtrl',
            controllerAs: 'vm',
            bindToController: true,
            scope: {},
            templateUrl: 'src/app/form/form.tpl.html'
        }

        return directive;
    }
})();