(function () {
    angular.module('livesearch')
        .controller('LivesearchFormCtrl', LivesearchFormCtrl);

    LivesearchFormCtrl.$inject = ['LivesearchApi', 'LivesearchResults'];

    function LivesearchFormCtrl(LivesearchApi, LivesearchResults) {
        var vm = this;

        vm.bundle = 'genres';

        vm.list = function (queryString, timeoutPromise) {
            return LivesearchApi.list(queryString, timeoutPromise, vm.bundle);
        };

        vm.listGenres = function (queryString, timeoutPromise) {
            return LivesearchApi.listGenres(queryString, timeoutPromise);
        };

        vm.selectedObject = function(item) {
            if (item) {
                LivesearchApi
                    .getItem(item.originalObject)
                    .then(function(results) {
                        LivesearchResults.setResults(results);
                    });
            } else {
                LivesearchResults.setResults([]);
            }
        }

        vm.selectedGenresObject = function(item) {
            if (item) {
                console.log(item);
                window.location = item.originalObject.url;
            } else {
                LiveSearchResults.setResults([]);
            }
        }
    }
})();