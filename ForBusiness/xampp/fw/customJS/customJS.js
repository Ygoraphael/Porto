//grow div destaques
jQuery(document).ready(function () {
    jQuery('.anim').mouseenter(function () {
        var elem = jQuery(this).closest('.anim').find('.widget-box');
        if (elem.data('state')) {
            elem.data('state', false).animate({height: '100%'}, 300);
        } else {
            elem.data('state', true).animate({height: '120%'}, 300);
        }
    });
    jQuery('.anim').mouseleave(function () {
        var elem = jQuery(this).closest('.anim').find('.widget-box');
        if (elem.data('state')) {
            elem.data('state', false).animate({height: '100%'});
        } else {
            elem.data('state', true).animate({height: '120%'});
        }
    });
    jQuery('.widget-box').mouseenter(function () {
        var elemCSS = jQuery(this).closest('.widget-box').find('.hide');
        if (elemCSS.data('state')) {
            elemCSS.data('state', false).css({display: 'none'});
        } else {
            elemCSS.data('state', false).fadeIn(500).css({display: 'block'});
        }
    });
    jQuery('.widget-box').mouseleave(function () {
        var elemCSS = jQuery(this).closest('.widget-box').find('.hide');
        if (elemCSS.data('state')) {
            elemCSS.data('state', false).css({display: 'block'});
        } else {
            elemCSS.data('state', false).css({display: 'none'});
        }
    });
//grow search bar
    jQuery("#search").click(function () {
        setTimeout(function () {
            jQuery('#searchBar').css({'width': '100%'});
        }, 200);
    });
});
//clear default value
jQuery(document).ready(function () {
    jQuery("#searchBar").click(function () {
        jQuery(this).val('');
    });
});

jQuery("#menu-toggle").click(function (e) {
    e.preventDefault();
    jQuery("#wrapper").toggleClass("toggled");
});

jQuery(".accordion-title > .closeIcon").click(function (e) {
    e.preventDefault();
    jQuery("#wrapper").toggleClass("toggled");
});

jQuery('.owl-carousel').owlCarousel({
    loop: false,
    margin: 20,
    dots: true,
    nav: false,
    smartSpeed: 400,
    responsiveClass: true,
    navText: ['<i class="fa fa-long-arrow-left"></i>', '<i class="fa fa-long-arrow-right"></i>'],
    responsive: {
        0: {
            items: 1
        },
        600: {
            items: 2
        },
        1000: {
            items: 4
        }
    }
})

// function to flush footer to bottom
// function autoHeight() {
// jQuery('#content').css('min-height', (
// jQuery(document).height()
// - jQuery('#header').height()
// - jQuery('#footer').height()
// ));
// }
// jQuery(document).ready(function() {
// autoHeight();
// });
// jQuery(window).resize(function() {
// autoHeight();
// });


var native_width = 0;
var native_height = 0;

jQuery(".magnify").mousemove(function (e) {
    if (jQuery(this).css("display") != "none")
    {
        if (!native_width && !native_height)
        {
            var image_object = new Image();
            image_object.src = jQuery(".small").attr("src");
            native_width = image_object.width;
            native_height = image_object.height;
        } else
        {
            var magnify_offset = jQuery(this).offset();
            var mx = e.pageX - magnify_offset.left;
            var my = e.pageY - magnify_offset.top;

            if (mx < jQuery(this).width() && my < jQuery(this).height() && mx > 0 && my > 0) {
                jQuery(".large").fadeIn(100);
            } else {
                jQuery(".large").fadeOut(100);
            }
            if (jQuery(".large").is(":visible"))
            {
                var rx = Math.round(mx / jQuery(".small").width() * native_width - jQuery(".large").width() / 2) * -1;
                var ry = Math.round(my / jQuery(".small").height() * native_height - jQuery(".large").height() / 2) * -1;
                var bgp = rx + "px " + ry + "px";

                var px = mx - jQuery(".large").width() / 2;
                var py = my - jQuery(".large").height() / 2;
                jQuery(".large").css({left: px, top: py, backgroundPosition: bgp});
            }
        }
    }
})

//scroll top
jQuery(document).ready(function () {
    jQuery(window).scroll(function () {
        if (jQuery(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
            jQuery('#return-to-top').fadeIn(200);    // Fade in the arrow
        } else {
            jQuery('#return-to-top').fadeOut(200);   // Else fade out the arrow
        }
    });

    jQuery('#return-to-top').click(function () {      // When arrow is clicked
        jQuery('body,html').animate({
            scrollTop: 0                       // Scroll to top of body
        }, 500);
    });
});