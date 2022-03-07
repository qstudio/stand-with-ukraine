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

		// get stored values - returns defaults, if not viewable ##
		$_values = \q\stand_with_ukraine\admin\read::option();

		// check if banner is visible ##
		if( ! $this->is_visible( $_values ) ){ return false; }

		// get template markup ##
		$_template = \q\stand_with_ukraine\theme\template::get();

		// define button visibillity settings ##
		$_values['show_donate'] = isset( $_values['show_donate'] ) && $_values['show_donate'] === 1 ? 'visible' : 'hidden';
		$_values['show_download'] = isset( $_values['show_download'] ) && $_values['show_download'] === 1 ? 'visible' : 'hidden';

		// markup - array values are escaped ##
		echo \wp_kses_post( 
			\q\stand_with_ukraine\theme\template::markup( $_template, $_values ),
		);

	}

	/**
	 * Validate required data and settings
	 * 
	 * @param	array
	 * @since 	0.0.1
	*/
	public function is_visible( $array ):bool{

		return isset( $array['show_banner'] ) && $array['show_banner'] === 1 ? true : false ;

	}

}
