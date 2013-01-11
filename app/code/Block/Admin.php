<?php

namespace WP_Sharrre\Administrator;

/**
 *  Admin class for WP Sharrre
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

if ( ! class_exists( 'WP_Sharrre_Admin' ) ) :

    class WP_Sharrre_Admin {

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
         * add the admin settings page under Settings
         * called from App.php
         */
        function add_settings_page() {
            add_submenu_page(
                'options-general.php',
                'WP Sharrre Settings',
                'WP Sharrre',
                'activate_plugins',
                'wp-sharrre',
                array( $this, 'wp_sharrre_settings' ) );
        }

        /**
         * Display the settings page
         */
        function wp_sharrre_settings() {
            global $wp_sharrre_settings_api;

            ?>
        <div class="wrap">
            <div id="icon-options-general" class="icon32"></div>
            <h2>WP Sharrre Settings</h2>
            <?php
            settings_errors( '', false, true );

            // Output settings form
            $wp_sharrre_settings_api->show_navigation();
            $wp_sharrre_settings_api->show_forms();
            ?>
        </div>
        <?php
        }

        /**
         * Get the sections
         *
         * @return array
         */
        function get_settings_sections() {
            $sections = array(

                array(
                    'id'        => 'wp_sharrre_setup',
                    'title'     => 'Setup'
                ),

                array(
                    'id'        => 'wp_sharrre_show_buttons',
                    'title'     =>  'Show Buttons'
                ),

                /** not using yet
                array(
                    'id'        => 'wp_sharrre_button',
                    'title'     => 'Share Button'
                ),
                */

                array(
                    'id'        => 'wp_sharrre_pinterest',
                    'title'     => 'Pinterest Logo'
                )
            );

            return $sections;
        }

        /**
         * Get the setting fields
         *
         * @return array
         */
        function get_settings_fields() {

            $setup_google_analytics = "
            <h2>Track Tweets, Facebook Likes, Google Plus, etc</h2>
            <strong>Installation</strong>
            <p>If not already the case, you need to update you Google Analytics code. It should look like this:</p>
            <div style=\"padding:0 15px; background: #fefbf3; border:1px solid #ccc; margin-bottom:20px; \">
            <pre>&lt;script type=\"text/javascript\"&gt;
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-xxxxxx-x']);
_gaq.push(['_trackPageview']);
(function() {
  var ga = document.createElement('script');
  ga.type = 'text/javascript';
  ga.async = true;
  ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
  var s = document.getElementsByTagName('script')[0];
  s.parentNode.insertBefore(ga, s);
}) ();
&lt;script&gt;</pre>
            </div>

            <p><strong>Enable tracking in Show Buttons tab</strong></p>

            <h2>Viewing your Google Analytics social tracking reports</h2>
            <p>Go in the Google Analytics Interface</p>
            <p><img src=\"" . WP_SHARRRE_URL . "/assets/img/track1.png\" /></p>
            <p>Then in the left menu go to <strong>Vistors > Social > Engagement</strong> (or Pages or Actions).</p>
            <p><img src=\"" . WP_SHARRRE_URL . "/assets/img/track2.png\" /></p>
            <p>Your results, if your tracking is properly set up, will look similar to this:</p>
            <p><img src=\"" . WP_SHARRRE_URL . "/assets/img/track3.png\" /></p>
            <p>Further reading: <a href=\"https://developers.google.com/analytics/devguides/collection/gajs/gaTrackingSocial\" target=\"_blank\">Social Interaction Analytics</a>
            ";

            $settings_fields = array (

                'wp_sharrre_setup'      => array(
                    array(
                        'name'          => 'setup',
                        'label'         => 'Setup Google Analytics',
                        'desc'          => $setup_google_analytics,
                        'type'          => 'about'
                    )
                ),

                'wp_sharrre_show_buttons'  => array(
                    array(
                      'name'            => 'google_plus',
                      'label'           => 'Show Google Plus',
                      'desc'            => '',
                      'type'            => 'checkbox'
                    ),

                    array(
                        'name'          => 'facebook',
                        'label'         => 'Show Facebook',
                        'desc'          => '',
                        'type'          => 'checkbox'
                    ),

                    array(
                        'name'          => 'twitter',
                        'label'         => 'Show Twitter',
                        'desc'          => '',
                        'type'          => 'checkbox'
                    ),

                    array(
                        'name'          => 'delicious',
                        'label'         => 'Show Delicious',
                        'desc'          => '',
                        'type'          => 'checkbox'
                    ),

                    array(
                        'name'          => 'stumbleupon',
                        'label'         => 'Show StumbleUpon',
                        'desc'          => '',
                        'type'          => 'checkbox'
                    ),

                    array(
                        'name'          => 'linkedin',
                        'label'         => 'Show LinkedIn',
                        'desc'          => '',
                        'type'          => 'checkbox'
                    ),

                    array(
                        'name'          => 'pinterest',
                        'label'         => 'Show Pinterest',
                        'desc'          => '',
                        'type'          => 'checkbox'
                    ),

                    array(
                        'name'          => 'tracking',
                        'label'         => 'Enable Google Analytics tracking',
                        'desc'          => '',
                        'type'          => 'checkbox'
                    )
                ),

                'wp_sharrre_button'     => array(
                    array(
                        'name'          => 'share_button_text',
                        'label'         => 'Share Button Text',
                        'desc'          => '',
                        'default'       => 'share',
                        'type'          => 'text',
                        'size'          => '70'
                    ),

                    array(
                        'name'          => 'share_button_bg_color',
                        'label'         => 'Share Button Bg Color',
                        'desc'          => '',
                        'default'       => '#417dce',
                        'type'          => 'colorpicker'
                    ),

                    array(
                        'name'          => 'count_bg_color',
                        'label'         => 'Count Bg Color',
                        'desc'          => '',
                        'default'       => '#eeeeee',
                        'type'          => 'colorpicker'
                    )
                ),

                'wp_sharrre_pinterest'  => array(

                    array(
                        'name'          => 'pinterest_defaults',
                        'label'         => 'Pinterest Defaults',
                        'desc'          => 'This Pinterest Default image will be used if no image is found on a page.',
                        'type'          => 'about'
                    ),

                    array(
                        'name'          => 'pinterest_default_image',
                        'label'         => 'Pinterest Default Image',
                        'desc'          => '',
                        'default'       => 'http://monasheemountainmultimedia.com/assets/mmm_AE_logo-300x120.png',
                        'type'          => 'media'
                    )
                )

            );

            return $settings_fields;
        }

        /**
         * Initialize the admin page
         * called from App.php
         */
        function wp_sharrre_admin_init() {
            global $wp_sharrre_settings_api;

            // set the settings
            $wp_sharrre_settings_api->set_sections( $this->get_settings_sections() );
            $wp_sharrre_settings_api->set_fields( $this->get_settings_fields() );

            // initialize the settings
            $wp_sharrre_settings_api->admin_init();
        }

    }

endif; // end if class_exists