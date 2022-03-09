<?php

declare(strict_types = 1);

namespace q\stand_with_ukraine\admin;

// If this file is called directly, Bulk!
if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Read option settings
 * 
 * @since 0.0.1
*/
class read {

	private static $_defaults = [];
	private static $_url_donate = [];

    /**
     * Class constructor to define object props
     * 
     * @since   0.0.1
     * @return  void
    */
    function __construct() {

	}
	
	/**
	 * WP Hooks
	 * 
	 * @since  	0.0.1
	 * @return	__void
	*/
	public function hooks(){

		// \add_action( 'wp_head', [ $this, 'javascript' ] );

	}

	/**
	 * Read stored option value
	 * 
	 * @todo	download links to rotate randomly 
	 * @todo	download list should be updatedable from remote API and cached for a short time in transients
	 * @since   0.0.1
	*/
	public static function option(){

		// get defaults ##
		$_defaults = self::get_defaults();

		// get stored options -- default to empty array ##
		$_option = \get_option( \q_stand_with_ukraine()::get( 'option' ) ) ?? [] ;

		// return merged array ##
		return \wp_parse_args( $_option, $_defaults );

	}

	/**
	 * 
	 * @since 0.0.2
	*/
	public static function get_defaults():array{

		// cache ##
		if( 
			! empty( self::$_defaults ) && 
			is_array( self::$_defaults ) 
		){ 
				
			return self::$_defaults; 
			
		}

		// filter once ##
		$_defaults = \apply_filters( 'q\stand_with_ukraine\admin\read\defaults', [
			'show_banner' 		=> 1,
			'show_donate' 		=> 1,
			'show_download' 	=> 1,
			'message' 			=> \__( 'Stand with Ukraine' ),
			'button_donate' 	=> \__( 'Donate' ),
			'title_donate' 		=> \__( 'Make a donation to humanitation and non-military assistance for Ukraine' ),
			'url_donate'		=> 'https://www.globalgiving.org/projects/',
			'url_donate_custom'	=> '',
			'button_download' 	=> \__( 'Download' ),
			'title_download' 	=> \__( 'Download the WordPress plugin to install on your own website' ),
			'url_download'		=> 'https://wordpress.org/plugins/we-stand-with-ukraine-banner/',
		]);

		// return and set prop value ##
		return self::$_defaults = $_defaults;

	}

	/**
	 * 
	 * @since 0.0.2
	*/
	public static function get_url_donate():array{

		// cache ##
		if( 
			! empty( self::$_url_donate ) && 
			is_array( self::$_url_donate ) 
		){ 
				
			return self::$_url_donate; 
			
		}

		// filter once ##
		$_url_donate = \apply_filters( 'q\stand_with_ukraine\admin\read\url_donate', [
			'Global Giving'		=> 'https://www.globalgiving.org/projects/',
			'UNICEF'			=> 'https://www.unicef.org/emergencies/conflict-ukraine-pose-immediate-threat-children',
			'PAH'				=> 'https://www.pah.org.pl/'
		]);

		// return and set prop value ##
		return self::$_url_donate = $_url_donate;

	}

}
