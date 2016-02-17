(function() {
    angular.module('livesearch')
        .factory('LivesearchApi', LivesearchApi);

    LivesearchApi.$inject = ['$http', '$q'];

    function LivesearchApi($http, $q) {
        var service = {
            list: list,
            listGenres: listGenres,
            getItem: getItem
        };

        return service;

        function list(queryString, timeoutPromise, bundle) {
            var deferred = $q.defer();

            var url = '/api/v1.0/livesearch?filter[name][value]='
                + encodeURIComponent(queryString)
                + '&filter[name][operator]=CONTAINS'
                + '&range=5'
                + '&filter[bundle]='
                + encodeURIComponent(bundle);

            $http({
                'method': 'GET',
                'url': url,
                'timeout': timeoutPromise
            }).then(function(results) {
                console.log(results);
                deferred.resolve(results.data);
            });

            return deferred.promise;
        }

        function listGenres(queryString, timeoutPromise, bundle) {
            var deferred = $q.defer();

            var url = '/api/v1.0/livesearchGenres?filter[name][value]='
                + encodeURIComponent(queryString)
                + '&filter[name][operator]=CONTAINS'
                + '&range=5';

            $http({
                'method': 'GET',
                'url': url,
                'timeout': timeoutPromise
            }).then(function(results) {
                console.log(results);
                deferred.resolve(results.data);
            });

            return deferred.promise;
        }

        function getItem(item) {
            console.log(item);
            var deferred = $q.defer();
            var resource = '';
            switch (item.bundle) {
                case 'artists':
                    resource = 'livesearchArtists';
                    break;
                case 'venues':
                    resource = 'livesearchVenues';
                    break;
            }

            var url = '/api/v1.0/' + resource + '/' + item.id;

            $http({
                'method': 'GET',
                'url': url,
            }).then(function(result) {
                console.log(result);
                deferred.resolve(result.data.data[0]);
            });

            return deferred.promise;
        }
    }
})();