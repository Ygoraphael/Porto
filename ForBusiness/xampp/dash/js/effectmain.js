var isAnimating = false;
var newLocation = '';

function runApp(app) {
    var newPage = mainDir + app;

    if (!isAnimating)
        changePage(newPage);
}

function changePage(url) {
    isAnimating = true;
    // trigger page animation
    $('body').addClass('page-is-changing');
    $('.cd-loading-bar').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function () {
        loadNewContent(url);
        newLocation = url;
        $('.cd-loading-bar').off('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend');
    });
}

function loadNewContent(url) {
    url = ('' == url) ? 'index.html' : url;
    var newSection = 'cd-' + url.replace('.html', '');
    var section = $('<div class="cd-main-content ' + newSection + '"></div>');

    section.load(url + ' .cd-main-content > *', function (event) {
        $.ajax({
            "url": url,
            success: function (data) {
                var delay = (transitionsSupported()) ? 1200 : 0;
                setTimeout(function () {
					delete globalScript;
					
                    $('.main').html(data);

                    (section.hasClass('cd-about')) ? $('body').addClass('cd-about') : $('body').removeClass('cd-about');
                    $('body').removeClass('page-is-changing');
                    $('.cd-loading-bar').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function () {
                        isAnimating = false;
                        $('.cd-loading-bar').off('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend');
                    });

                    if (!transitionsSupported())
                        isAnimating = false;
                }, delay);
            }
        })
    });
}

function transitionsSupported() {
    return $('html').hasClass('csstransitions');
}