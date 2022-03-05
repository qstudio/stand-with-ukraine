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
	 * @since   0.0.1
	*/
	public static function option(){

		$_option = \get_option( \q_stand_with_ukraine()::get( 'option' ) );

		return [
			'{message}' => \__( 'We stand with Ukraine' ),
			'{button_donate}' => \__( 'Donate' ),
			'{button_install}' => \__( 'Install' ),
		];

	}

}
