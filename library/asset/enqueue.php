<?php

declare(strict_types = 1);

namespace q\stand_with_ukraine\asset;

// If this file is called directly, Bulk!
if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/*
* Register and Enqueue assets
*/
class enqueue {

	private 
		$plugin
	;

    /**
     * Class constructor to define object props --> empty
     * 
     * @since   0.0.1
     * @return  void
    */
    function __construct( \q\stand_with_ukraine\plugin $plugin ) {

		$this->plugin = $plugin; 

	}
	
	/**
	 * WP Hooks
	 * 
	 * @since  	0.0.1
	 * @return	__void
	*/
	public function hooks(){

		// register user\asset\javascript file ##
		// \add_action( 'wp_head', [ $this, 'javascript' ] );

	}

}
