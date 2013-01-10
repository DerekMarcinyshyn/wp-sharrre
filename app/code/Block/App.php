<?php

namespace WP_Sharrre;

/**
 *  App class for WP Sharrre
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

if ( ! class_exists( 'App' ) ) :

    class App {

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
         * Default constructor -- application initialization
         */
        private function __construct() {
            global  $wp_sharrre_frontend,
                    $wp_sharrre_admin;

            // add scripts only on frontend
            if ( !is_admin() ) {

                // TODO: only if want to display vertical
                //add_action( 'init', array( $this, 'wp_sharrre_scripts' ) );

                add_action( 'init', array( $this, 'wp_sharrre_scripts_horizontal' ) );
            }

            // TODO: if display vertical use this
            // add div via filter hook
            //add_filter( 'the_content', array( $wp_sharrre_frontend, 'add_sharrre_the_content' ) );


            // add settings page
            add_action( 'admin_menu', array( $wp_sharrre_admin, 'add_settings_page' ) );
            add_action( 'admin_init', array( $wp_sharrre_admin, 'wp_sharrre_admin_init' ) );

            // check for update
            add_action( 'admin_init', array( $this, 'wp_sharrre_updater' ) );
        }

        function wp_sharrre_scripts_horizontal() {
            wp_register_script( 'sharrre-js', WP_SHARRRE_URL . '/assets/js/jquery.sharrre.min.js', array( 'jquery' ), '1.3.3', true );
            wp_enqueue_script( 'sharrre-js');
        }

        /**
         * wp_sharrre_scripts function
         * for displaying in a vertical format
         *
         * Add CSS and JS scripts
         */
        function wp_sharrre_scripts() {
            global $first_img;

            wp_register_script( 'sharrre-js', WP_SHARRRE_URL . '/assets/js/jquery.sharrre.min.js', array( 'jquery' ), '1.3.3', true );
            wp_enqueue_script( 'sharrre-js');

            wp_register_script( 'wp-sharrre-js', WP_SHARRRE_URL . '/assets/js/wp-sharrre.js', array( 'jquery' ), WP_SHARRRE_VERSION, true );
            wp_enqueue_script( 'wp-sharrre-js');

            wp_register_style( 'wp-sharrre-css', WP_SHARRRE_URL . '/assets/css/wp-sharrre.css', true, WP_SHARRRE_VERSION );
            wp_enqueue_style( 'wp-sharrre-css' );

            // get the settings options
            $show_buttons = get_option( 'wp_sharrre_show_buttons' );

            // set the variables -- if unchecked they will not appear in the array
            $gp = false;
            $fb = false;
            $tw = false;
            $de = false;
            $st = false;
            $li = false;
            $pi = false;
            $tracking = false;

            if ( isset( $show_buttons['google_plus'] ) ) $gp = true;
            if ( isset( $show_buttons['facebook'] ) ) $fb = true;
            if ( isset( $show_buttons['twitter'] ) ) $tw = true;
            if ( isset( $show_buttons['delicious'] ) ) $de = true;
            if ( isset( $show_buttons['stumbleupon'] ) ) $st = true;
            if ( isset( $show_buttons['linkedin'] ) ) $li = true;
            if ( isset( $show_buttons['pinterest'] ) ) $pi = true;
            if ( isset( $show_buttons['tracking'] ) ) $tracking = true;

            // push the settings to frontend in footer
            wp_localize_script(
                'sharrre-js',
                'WP_Sharrre',
                array(
                    'sharrre_php'       => WP_SHARRRE_URL . '/lib/vendor/sharrre/sharrre.php',
                    'google_plus'       => $gp,
                    'facebook'          => $fb,
                    'twitter'           => $tw,
                    'delicious'         => $de,
                    'stumbleupon'       => $st,
                    'linkedin'          => $li,
                    'pinterest'         => $pi,
                    'pinimage'          => $first_img,
                    'tracking'          => $tracking
                ) );
        }

        /**
         * get the WP Sharrre Options
         *
         * @param $option
         * @param $section
         * @param string $default
         * @return string
         */
        function wp_sharrre_get_option( $option, $section, $default = '' ) {

            $options = get_option( $section );

            if ( isset( $options[$option] ) ) {
                return $options[$option];
            }

            return $default;
        }

        /**
         * wp_sharrre_updater class
         *
         * Check GitHub to see if there is an update available
         */
        function wp_sharrre_updater() {

            define( 'WP_SHARRRE_FORCE_UPDATE', true );

            if ( is_admin() ) {
                $config = array(
                    'slug'                  => WP_SHARRRE_DIRECTORY . '/wp-sharrre.php',
                    'proper_folder_name'    => 'wp-sharrre',
                    'api_url'               => 'https://api.github.com/repos/DerekMarcinyshyn/wp-sharrre',
                    'raw_url'               => 'https://raw.github.com/DerekMarcinyshyn/wp-sharrre/master',
                    'github_url'            => 'https://github.com/DerekMarcinyshyn/wp-sharrre',
                    'zip_url'               => 'https://github.com/DerekMarcinyshyn/wp-sharrre/zipball/master',
                    'sslverify'             => false,
                    'requires'              => '3.0',
                    'tested'                => '3.5',
                    'readme'                => 'README.md',
                    'access_token'          => '',
                );

                new \WP_SHARRRE_Updater( $config );
            }
        }
    }

endif; // end if class_exists