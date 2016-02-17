<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
<div class="search ng-cloak" ng-app="livesearch">
    <hr/>
    <div class="col-md-4">
        <h1 class="search-title">
            <span>Search</span>
            <span class="search-sub-header typewriter">Genres, artists & venues</span>
        </h1>
    </div>
    <div class="col-md-8">
        <livesearch-form></livesearch-form>
        <div>{{searchquery}}</div>
    </div>
    <div class="col-xs-12">
        <hr/>
        <livesearch-results></livesearch-results>
    </div>
</div>