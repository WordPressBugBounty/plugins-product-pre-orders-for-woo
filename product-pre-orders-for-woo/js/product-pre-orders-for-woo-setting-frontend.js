/*
* Label variable
*/
jQuery(document).ready(function ($) {
    "use strict";
    jQuery(function ($) {
        let button = $('.single_add_to_cart_button').eq(0),
            add_to_cart_text = button.html()
        $('form.variations_form')
            .on('show_variation', function (event, variation) {
                // Prevent show variation not correct
                let current_variation = $('.variation_id').val();
                if ( variation.variation_id != current_variation ) {
                    return;
                }
                if (variation.hasOwnProperty('pre_order_label')) {
                    button.html(variation.pre_order_label);
                } else {
                    button.html(add_to_cart_text);
                }
            })
            .on('hide_variation', function (event) {
                event.preventDefault();
                button.html(add_to_cart_text);
            });

    });
});

