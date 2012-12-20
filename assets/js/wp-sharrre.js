jQuery(document).ready(function() {

    // float the buttons
    var offset = jQuery(".wp-sharrre-container").offset();
    var top_padding = 15;

    jQuery(window).scroll(function() {
        if ( jQuery(window).scrollTop() > offset.top ) {
            jQuery(".wp-sharrre-container").stop().animate({
                marginTop: jQuery(window).scrollTop() - offset.top + top_padding
            });
        } else {
            jQuery(".wp-sharrre-container").stop().animate({
                marginTop: 0
            });
        }
    });

    // add the buttons to the container
    jQuery('#wp-sharrre').sharrre({
        share: {
            googlePlus:     true,
            facebook:       true,
            twitter:        true,
            delicious:      true,
            stumbleupon:    true,
            linkedin:       true,
            pinterest:      true
        },

        buttons: {
            googlePlus:     { size:     'medium' },
            facebook:       { layout:   'button_count' },
            twitter:        { count:    'horizontal' },
            delicious:      { size:     'medium' },
            stumbleupon:    { layout:   '1' },
            linkedin:       { counter:  'right' },
            pinterest:      { media: 'http://monasheemountainmultimedia.com/img/logo.png', description: 'Hello World', layout: 'horizontal' }
        },

        hover: function(api, options) {
            jQuery(api.element).find('.buttons').show();
        },

        hide: function(api, options) {
            jQuery(api.element).find('.buttons').hide();
        },

        //enableCounter: false
        enableTracking: true,
        urlCurl: WP_Share.sharrre_php
    });

});