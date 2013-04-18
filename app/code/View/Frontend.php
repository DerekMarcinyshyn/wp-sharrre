<?php

namespace WP_Sharrre\View;

/**
 *  Frontend class for WP Sharrre
 *
 * PHP version 5.3.x +
 *
 * Copyright (c) 2012 Derek Marcinyshyn
 *
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package    WP Sharrre
 * @author     Derek Marcinyshyn <derek@marcinyshyn.com>
 * @copyright  Copyright (c) 2012 Derek Marcinyshyn
 * @version    1.0
 * @license    http://www.gnu.org/licenses/gpl-2.0.html
 * @link       https://derekmarcinyshyn.github.com/wp-sharrre
 */

if ( ! class_exists( 'Frontend' ) ) :

    class Frontend {

        /**
         * _instance class variable
         *
         * Class instance
         *
         * @var null | object
         */
        private static $_instance = NULL;

        static function get_instance() {
            if( self::$_instance === NULL ) {
                self::$_instance = new self();
            }

            return self::$_instance;
        }

        /**
         * Constructor
         *
         * Default constructor
         */
        private function __construct() {}

        /**
         * TODO: displays the sharrre vertically via the_content() -- not enabled yet
         *
         * @param $content
         * @return string
         */
        function add_sharrre_the_content( $content ) {

            $sharrre = '';
            $sharrre .= '<div class="wp-sharrre-container">';
            $sharrre .= '<div class="wp-sharrre-inner">';
            $sharrre .= '<div id="wp-sharrre" data-url="' . get_bloginfo('wpurl') . '"';
            $sharrre .= ' data-title="share" data-text="wp-sharrre"></div>';
            $sharrre .= '</div>';
            $sharrre .= '</div>';

            return $sharrre . $content;
        }

        /**
         * Displays html on the frontend
         *
         * @return string
         */
        public static function display_wp_sharrre() {
            global $post;

            // initialize variables
            $wp_sharrre_button_options = get_option( 'wp_sharrre_button' );
            $wp_sharrre_show_button = get_option( 'wp_sharrre_show_buttons' );
            $wp_sharrre_pinterest = get_option( 'wp_sharrre_pinterest' );

            $gp = 0;
            $fb = 0;
            $tw = 0;
            $de = 0;
            $st = 0;
            $li = 0;
            $pi = 0;
            $tracking = 0;

            if ( isset( $wp_sharrre_show_button['google_plus'] ) ) $gp = true;
            if ( isset( $wp_sharrre_show_button['facebook'] ) ) $fb = true;
            if ( isset( $wp_sharrre_show_button['twitter'] ) ) $tw = true;
            if ( isset( $wp_sharrre_show_button['delicious'] ) ) $de = true;
            if ( isset( $wp_sharrre_show_button['stumbleupon'] ) ) $st = true;
            if ( isset( $wp_sharrre_show_button['linkedin'] ) ) $li = true;
            if ( isset( $wp_sharrre_show_button['pinterest'] ) ) $pi = true;
            if ( isset( $wp_sharrre_show_button['tracking'] ) ) $tracking = true;

            // find the first image associated with the post
            $args = array(
                'numberposts'       => 1,
                'order'             => 'ASC',
                'post_mime_type'    => 'image',
                'post_parent'       => $post->ID,
                'post_status'       => null,
                'post_type'         => 'attachment'
            );

            $post_images_data = get_children( $args );

            // setting for default image?
            $post_image_src[0] = '';
            $post_image_src[0] = $wp_sharrre_pinterest['pinterest_default_image'];

            if ( $post_images_data ) {
                foreach ( $post_images_data as $post_image_data) {
                    $post_image_src = wp_get_attachment_image_src( $post_image_data->ID, 'full' );
                }
            }

            // the html div holder
            $html = '';
            $html .= '<div id="wp-sharrre" data-url="' . get_bloginfo('wpurl') . '"';
            $html .= ' data-text="' . $post->post_title . '"';
            $html .= ' data-title="' . $wp_sharrre_button_options['share_button_text']  . '"></div>';

            // sharrre javascript
            $html .= '
                <script type="text/javascript">
                jQuery(document).ready(function() {
                    jQuery("#wp-sharrre").sharrre({
                        share: {
                            googlePlus:     ' . $gp . ',
                            twitter:        ' . $tw . ',
                            delicious:      ' . $de . ',
                            stumbleupon:    ' . $st . ',
                            linkedin:       ' . $li . ',
                            pinterest:      ' . $pi . ',
                            facebook:       ' . $fb . ',
                        },

                        buttons: {
                                googlePlus:     { size:     "medium" },
                                facebook:       { layout:   "button_count" },
                                twitter:        { count:    "horizontal" },
                                delicious:      { size:     "medium" },
                                stumbleupon:    { layout:   "1" },
                                linkedin:       { counter:  "right" },
                                pinterest:      { media: "' . $post_image_src[0] . '", description: "' . $post->post_title . '", layout: "horizontal" }
                            },

                        buttonClassName:    "'.$wp_sharrre_show_button['button_class_name'].'",
                        enableCounter:      false,
                        enableHover:        false,
                        enableTracking:     ' . $tracking . ',
                        urlCurl:            "' . WP_SHARRRE_URL . '/sharrre.php"
                    });
                });
                </script>
                <style>
                    #wp-sharrre { float:left; z-index: 999; }
                    .sharrre .' . $wp_sharrre_show_button['button_class_name'] . ' { float:left; width: 80px; }
                    .sharrre .googleplus { width: 70px!important; }
                    .sharrre .delicious { width: 100px!important; }
                    .sharrre .twitter { width: 85px!important; }
                    .sharrre .linkedin { width: 100px!important; }
                    .sharrre .pinterest { width: 50px!important; }
                    .fb-like span { width: 450px!important; overflow:visible!important; z-index: 999; }
                </style>
                <div style="clear:both"></div>
            ';

            return $html;
        }

    }
endif; // if class_exists