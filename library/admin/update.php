<?php

declare(strict_types = 1);

namespace q\stand_with_ukraine\admin;

// If this file is called directly, Bulk!
if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Update option settings
 * 
 * @since 0.0.1
*/
class update {

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
	 * Update stored option value
	 * 
	 * @since   0.0.1
	*/
	public static function option( array $array = [] ){

		// @todo - sanitize array values ##
		return \update_option( \q_stand_with_ukraine()::get( 'option' ), $array );

	}

}
