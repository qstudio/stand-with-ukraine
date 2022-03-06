<?php

declare(strict_types = 1);

namespace q\stand_with_ukraine\admin;

// import ##
use q\stand_with_ukraine\core\helper as h;

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

		$_option = \get_option( \q_stand_with_ukraine()::get( 'option' ) );
		h::log( $_option );

		return [
			'{message}' 		=> \__( 'We stand with Ukraine' ),
			'{button_donate}' 	=> \__( 'Donate' ),
			'{title_donate}' 	=> \__( 'Make a donatation to humanitation and non-military assistance to Ukraine' ),
			'{url_donate}'		=> 'https://www.globalgiving.org/projects/ukraine-crisis-relief-fund/',
			'{button_download}' => \__( 'Download' ),
			'{title_download}' 	=> \__( 'Download the WordPress plugin to install on your own website' ),
			'{url_download}'	=> 'https://github.com/qstudio/wordpress-plugin-stand-with-ukraine',
		];

	}

}
