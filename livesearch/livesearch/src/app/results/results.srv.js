(function() {
    angular.module('livesearch')
        .factory('LivesearchResults', LivesearchResults);

    LivesearchResults.$inject = [];

    function LivesearchResults() {
        var results = [];

        var service = {
            getResults: getResults,
            setResults: setResults
        }

        return service;

        function getResults() {
            return results;
        }

        function setResults(newResults) {
            results = newResults;
        }
    }
})();