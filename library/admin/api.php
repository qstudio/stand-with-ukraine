<?php

declare(strict_types = 1);

namespace q\stand_with_ukraine\admin;

// If this file is called directly, Bulk!
if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * Fetch Options to select in admin, such as accredited humanitarion charities to donate to.
 * 
 * @since 0.0.1
*/
class api {

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
	 * 
	 * @since 0.0.1
	*/
	public function get_source_links(){}

	/**
	 * 
	 * @since 0.0.1
	*/
	public function get_dontation_links(){}

}
