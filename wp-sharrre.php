<?php
/**
 * @package WP Sharrre
 * @since   December 19, 2012
 * @license http://www.gnu.org/licenses/gpl-2.0.html
 */
/*
Plugin Name: WP Sharrre
Plugin URI: https://derekmarcinyshyn.github.com/wp-sharrre
Description: WP Sharrre is a WordPress plugin based on a jQuery plugin that allows you to create nice widgets sharing for Facebook, Twitter, Google Plus and more.
Author: Derek Marcinyshyn
Author URI: http://derek.marcinyshyn.com
Version: 1.0
License: GPLv2

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

// Exit if called directly
defined( 'ABSPATH' ) or die( "Cannot access pages directly." );

// Plugin version
define( 'WP_SHARRRE_VERSION', '1.0');

// Plugin
define( 'WP_SHARRRE_PLUGIN', __FILE__ );

// Plugin directory
define( 'WP_SHARRRE_DIRECTORY', dirname( plugin_basename(__FILE__) ) );

// Plugin path
define( 'WP_SHARRRE_PATH', WP_PLUGIN_DIR . '/' . WP_SHARRRE_DIRECTORY );

// App path
define( 'WP_SHARRRE_APP_PATH', WP_SHARRRE_PATH . '/app' );

// Lib path
define( 'WP_SHARRRE_LIB_PATH', WP_SHARRRE_PATH . '/lib' );

// URL
define( 'WP_SHARRRE_URL', WP_PLUGIN_URL . '/' . WP_SHARRRE_DIRECTORY );


// Require main class
require_once( WP_SHARRRE_APP_PATH . '/code/Block/App.php' );

// Require admin class
require_once( WP_SHARRRE_APP_PATH . '/code/Block/Admin.php' );

// Require widgets class
require_once( WP_SHARRRE_APP_PATH . '/code/View/Frontend.php' );

// Require updater class
//include_once( WP_SHARRRE_LIB_PATH . '/vendor/updater/updater.php' );

// ====================================
// = Initialize and setup application =
// ====================================

global  $wp_sharrre_app,
        $wp_sharrre_frontend,
        $wp_sharrre_admin;

// Frontend view
$wp_sharrre_frontend = \WP_SHARRRE\Frontend::get_instance();

// Settings page
$wp_sharrre_admin = \WP_SHARRRE\Admin::get_instance();

// Main class app initialization in App::__construct()
use WP_Sharrre\App;
$wp_sharrre_app = \WP_SHARRRE\App::get_instance();