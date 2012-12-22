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
            googlePlus:     Boolean(WP_Sharrre.google_plus),
            facebook:       Boolean(WP_Sharrre.facebook),
            twitter:        Boolean(WP_Sharrre.twitter),
            delicious:      Boolean(WP_Sharrre.delicious),
            stumbleupon:    Boolean(WP_Sharrre.stumbleupon),
            linkedin:       Boolean(WP_Sharrre.linkedin),
            pinterest:      Boolean(WP_Sharrre.pinterest)
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

        enableTracking: Boolean(WP_Sharrre.tracking),
        urlCurl: WP_Sharrre.sharrre_php
    });

});