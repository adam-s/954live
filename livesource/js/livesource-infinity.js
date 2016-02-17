(function ($) {
    'use strict'

    // Cached reference to $(window) and $(document).
    var $window = $(window),
        $document = $(document);

    // Set some defaults
    var scrollThreshold = 250;

    // Initial page for infinate scroll will be 2;
    var page = 2;

    // Goes until data is not returned. A flag for finished state
    var more = true;

    // Debouce timeout container
    // @link http://stackoverflow.com/questions/7392058/more-efficient-way-to-handle-window-scroll-functions-in-jquery
    var scrollTimer = null,
        debounceDelay = 200;

    Drupal.behaviors.livesourceInfinity = {
        attach: function (context, settings) {
            $window.scroll(function() {
                if (scrollTimer) {
                    clearTimeout(scrollTimer);
                }
                scrollTimer = setTimeout(handleScroll, debounceDelay);
            })
        },
        detach: function (context, settings, trigger) {
            // remove event listeners
        }
    };

    function handleScroll() {
        scrollTimer = null;
        if (more && window.innerHeight + window.pageYOffset > $document.height() - scrollThreshold){
            // ^ Bail if there is no more
            callback();
        }
    }

    function callback () {
        $('#loader').show(); // show that the script is doing something

        var data = {};
        data.page = page++;
        // ^ set the query string values need to increment the page
        // after the fact because it's possible for this to be called
        // again before the previous information is returned. I guess it
        // is possible to return the response not in order. Fortunately
        // it is asyncronous so who cares?? lol
        if ($('.livesource-infinity').data('tid')) {
            data.tid = $('.livesource-infinity').data('tid');
        }

        $.ajax({
            url: '/api/livesource-infinity',
            method: 'get',
            data: data,
            success: function(response) {
                console.log(response);
                $('.livesource-infinity').append(response.data); // Too easy
                more = response.more; // Is there more to load?
                $('#loader').hide(); // all finished
            },
            error: function (xhr) {

            }
        });
    };

})(jQuery);