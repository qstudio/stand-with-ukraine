<?php

declare(strict_types = 1);

/**
 * Stand with Ukraine Banner Plugin for WordPress.org
 *
 * @package         Stand with Ukraine
 * @author          Q Studio <social@qstudio.us>
 * @license         GPL-2.0+
 * @copyright       2022 Q Studio
 *
 * @wordpress-plugin
 * Plugin Name:     Stand with Ukraine Banner Plugin
 * Plugin URI:      https://github.com/qstudio/wordpress-plugin-stand-with-ukraine
 * Description:     Stand with Ukraine Banner Plugin for WordPress.org
 * Version:         0.0.2
 * Author:          Q Studio
 * Author URI:      https://qstudio.us
 * License:         GPL-2.0+
 * Requires PHP:    7.0 
 * Copyright:       Q Studio
 * Class:           q_stand_with_ukraine
 * Text Domain:     q-stand-with-ukraine
 * Domain Path:     /languages
*/

// namespace plugin ##
namespace q\stand_with_ukraine;

// If this file is called directly, Bulk!
if ( ! defined( 'ABSPATH' ) ) {
	return;
}

// plugin activation hook to store current application and plugin state ##
\register_activation_hook( __FILE__, [ '\\q\\stand_with_ukraine\\plugin', 'activation_hook' ] );

// plugin deactivation hook - clear stored data ##
\register_deactivation_hook( __FILE__, [ '\\q\\stand_with_ukraine\\plugin', 'deactivation_hook' ] );

// required bits to get set-up ##
require_once __DIR__ . '/library/api/function.php';
require_once __DIR__ . '/autoload.php';
require_once __DIR__ . '/plugin.php';
require_once __DIR__ . '/hooks.php';

// get plugin instance ##
$plugin = plugin::get_instance();

// validate instance ##
if( ! ( $plugin instanceof \q\stand_with_ukraine\plugin ) ) {

	error_log( 'Error in stand_with_ukraine plugin instance' );

	// nothing else to do here ##
	return;

}

// set text domain on init hook ##
\add_action( 'init', [ $plugin, 'load_plugin_textdomain' ], 1 );

$hooks = new \q\stand_with_ukraine\hooks();

// fire hooks - build factory objects and translations ## 
\add_action( 'after_setup_theme', function() use( $hooks ){

	// admin hooks ##
	$hooks->admin( 
		new \q\stand_with_ukraine\admin\api,
		new \q\stand_with_ukraine\admin\create,
		new \q\stand_with_ukraine\admin\read,
		new \q\stand_with_ukraine\admin\update,
		new \q\stand_with_ukraine\admin\delete    
	);

	// asset hooks ##
	$hooks->asset( 
		new \q\stand_with_ukraine\asset\enqueue()  
	);

	// theme hooks ##
	$hooks->theme( 
		new \q\stand_with_ukraine\theme\render()  
	);

}, 3 );
