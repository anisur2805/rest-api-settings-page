<?php
/**
 * Plugin Name: Rest API Setting Page
 * Description: Awesome Desc...
 * Plugin URI:  rest-api-settings-page
 * Version:     1.0
 * Author:      Anisur Rahman
 * Author URI:  http://github.com/anisur2805/
 * Text Domain: rest-api-setting-page
 * License:     GPL v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}
require_once __DIR__ . '/Menu.php';
require_once __DIR__ . '/API.php';

add_action( 'init', function () {
	$assets_url = plugin_dir_url( __FILE__ );
	if ( is_admin() ) {
		new Apex_Menu( $assets_url );
	}
} );
