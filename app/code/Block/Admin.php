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
            settings_errors();

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
                    'id'        => 'wp_sharrre_general',
                    'title'     =>  'General Settings'
                ),

                array(
                    'id'        => 'wp_sharrre_colors',
                    'title'     => 'Colors'
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
            $settings_fields = array (

                'wp_sharrre_general'  => array(
                    array(
                      'name'        => 'google_plus',
                      'label'       => 'Show Google Plus',
                      'desc'        => '',
                      'type'        => 'checkbox'
                    )
                ),

                'wp_sharrre_colors' => array(
                    array(
                        'name'      => 'share_button_bg_color',
                        'label'     => 'Share Button Bg Color',
                        'desc'      => '',
                        'type'      => 'colorpicker'
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