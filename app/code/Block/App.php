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

            // register the ripper snow widget
            //add_action( 'widgets_init', function(){ return register_widget( 'rmr_reports\Widget_Ripper_Snow' ); } );

            // add scripts
            if( !is_admin() )
                add_action( 'init', array( $this, 'wp_sharrre_scripts' ) );

            // add div via filter hook
            add_filter( 'the_content', array( $wp_sharrre_frontend, 'add_sharrre_the_content' ) );

            // add settings page
            if( is_admin() )
                add_action( 'admin_menu', array( $wp_sharrre_admin, 'add_settings_page' ) );

            // check for update
            //add_action( 'admin_init', array( $this, 'rmr_reports_updater' ) );
        }

        /**
         * wp_sharrre_scripts function
         *
         * Add CSS and JS scripts
         */
        function wp_sharrre_scripts() {
            wp_register_script( 'sharrre-js', WP_SHARRRE_URL . '/assets/js/jquery.sharrre.min.js', array( 'jquery' ), '1.3.3', true );
            wp_enqueue_script( 'sharrre-js');

            wp_register_script( 'wp-sharrre-js', WP_SHARRRE_URL . '/assets/js/wp-sharrre.js', array( 'jquery' ), WP_SHARRRE_VERSION, true );
            wp_enqueue_script( 'wp-sharrre-js');

            wp_register_style( 'wp-sharrre-css', WP_SHARRRE_URL . '/assets/css/wp-sharrre.css', true, WP_SHARRRE_VERSION );
            wp_enqueue_style( 'wp-sharrre-css' );

            // google plus counter script
            wp_localize_script( 'sharrre-js', 'WP_Share', array( 'sharrre_php' => WP_SHARRRE_URL . '/lib/vendor/sharrre/sharrre.php' ) );
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

                //new \WP_SHARRRE_Updater( $config );
            }
        }
    }

endif; // end if class_exists