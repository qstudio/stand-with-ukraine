<?php

declare(strict_types = 1);

namespace q\stand_with_ukraine\theme;

// If this file is called directly, Bulk!
if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/*
 * Register and Enqueue assets
 * 
 * 
 * blue: #045bbb
 * yellow: #ffd600
*/
class render {

    /**
     * Class constructor to define object props --> empty
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

		if ( \is_admin() ){ return; }

		\add_action( 'wp_head', [ $this, 'banner' ], 1, 0 );

	}

	/**
	 * Render Banner
	 * 
	 * @since 0.0.1
	*/
	public function banner(){

		// @todo - check if we can load all require ui options ##
		if( ! $this->validate() ){ return false; }

		// get template markup ##
		$_template = \q\stand_with_ukraine\theme\template::get();

		// get default values - later these will come from options table ##
		$_values = \q\stand_with_ukraine\admin\read::option();

		// markup - array values are escaped ##
		echo \q\stand_with_ukraine\theme\template::markup( $_template, $_values );

	}

	/**
	 * Validate required data and settings
	 * 
	 * @since 0.0.1
	*/
	public function validate():bool{

		return true;

	}

}
