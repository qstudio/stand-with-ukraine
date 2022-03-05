<?php

declare(strict_types = 1);

namespace q\stand_with_ukraine;

// import classes ##
use q\stand_with_ukraine\core\helper as h;

// If this file is called directly, Bulk!
if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/*
* Main Plugin Class
*/
final class plugin {

    /**
     * Instance
     *
     * @var     Object      $_instance
     */
	private static $_instance;

	// static props ##
	private static 
	
		// current tag ##
		$version = '0.0.2',
		
		// log ##
		$log = null,

		// option key ## 
		$option = 'q_stand_with_ukraine'
		
	;

    /**
     * Initiator
     *
     * @since   0.0.2
     * @return  Object    
     */
    public static function get_instance() {

        // object defined once --> singleton ##
        if ( 
            isset( self::$_instance ) 
            && NULL !== self::$_instance
        ){

            return self::$_instance;

        }

        // create an object, if null ##
        self::$_instance = new self;

        // store instance in filter, for potential external access ##
        \add_filter( __NAMESPACE__.'/instance', function() {

            return self::$_instance;
            
        });

        // return the object ##
        return self::$_instance; 

    }

    /**
     * Class constructor to define object props --> empty
     * 
     * @since   0.0.1
     * @return  void
    */
    private function __construct() {

        // empty ##
		
	}
	
    /**
     * Get stored object property
	 * 
     * @param   $key    string
     * @since   0.0.2
     * @return  Mixed
    */
    public static function get( $key = null ) {

        // check if key set ##
        if( is_null( $key ) ){

            // return false;
			return self::get_instance();

        }
        
        // return if isset ##
        return self::$$key ?? false ;

    }

    /**
     * Set stored object properties 
     * 
	 * @todo	Make this work with single props, not from an array
     * @param   $key    string
     * @param   $value  Mixed
     * @since   0.0.2
     * @return  Mixed
    */
    public static function set( $key = null, $value = null ) {

        // sanity ##
        if( 
            is_null( $key ) 
        ){

            return false;

        }

        // __log( 'prop->set: '.$key.' -> '.$value );

        // set new value ##
		return self::$$key = $value;

    }

    /**
     * Load Text Domain for translations
     *
     * @since       0.0.1
     * @return      Void
     */
    public function load_plugin_textdomain(){

        // The "plugin_locale" filter is also used in load_plugin_textdomain()
        $locale = apply_filters( 'plugin_locale', \get_locale(), 'q-stand-with-ukraine' );

        // try from global WP location first ##
        \load_textdomain( 'q-stand-with-ukraine', WP_LANG_DIR.'/plugins/q-stand-with-ukraine-'.$locale.'.mo' );

        // try from plugin last ##
        \load_plugin_textdomain( 'q-stand-with-ukraine', FALSE, \plugin_dir_path( __FILE__ ).'src/languages/' );

    }

    /**
     * Plugin activation
     *
     * @since   0.0.1
     * @return  void
     */
    public static function activation_hook(){

        // Log::write( 'Plugin Activated..' );

        // check user caps ##
        if ( ! \current_user_can( 'activate_plugins' ) ) {
            
            return;

        }

        $plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
        \check_admin_referer( "activate-plugin_{$plugin}" );

        // store data about the current plugin state at activation point ##
        $config = [
            'configured'            => true , 
            'version'               => self::get( 'version' ) ,
            'wp'                    => \get_bloginfo( 'version' ) ?? null ,
			'timestamp'             => time(),
		];
		
        // activation running, so update configuration flag ##
        \update_option( 'q\stand-with-ukraine', $config, true );

    }

    /**
     * Plugin deactivation
     *
     * @since   0.0.1
     * @return  void
     */
    public static function deactivation_hook(){

        // Log::write( 'Plugin De-activated..' );

        // check user caps ##
        if ( ! \current_user_can( 'activate_plugins' ) ) {
        
            return;
        
        }

        $plugin = isset( $_REQUEST['plugin'] ) ? $_REQUEST['plugin'] : '';
        \check_admin_referer( "deactivate-plugin_{$plugin}" );

        // de-configure plugin ##
        \delete_option('q\stand-with-ukraine');

        // clear rewrite rules ##
        \flush_rewrite_rules();

	}
	
    /**
     * Get Plugin URL
     *
	 * @todo		__deprecate
     * @since       0.1
     * @param       string      $path   Path to plugin directory
     * @return      string      Absoulte URL to plugin directory
     */
    public static function get_url( $path = '' ){

        return \plugins_url( $path, __FILE__ );

    }

    /**
     * Get Plugin Path
     *
	 * @todo		__deprecate
     * @since       0.1
     * @param       string      $path   Path to plugin directory
     * @return      string      Absoulte URL to plugin directory
     */
    public static function get_path( $path = '' ){

        return \plugin_dir_path( __FILE__ ).$path;

	}
	
}
