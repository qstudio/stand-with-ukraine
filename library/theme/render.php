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

		\add_action( 'wp_head', [ $this, 'banner' ] );

	}

	/**
	 * 
	 * @since 0.0.1
	*/
	public function banner(){

		// @todo - check if we can load all require ui options ##
		if( ! $this->validate() ){ return false; }

		// get template markup ##
		$_template = \q\stand_with_ukraine\theme\template::get();

		// get default values - later these will come from options table ##
		$_values = array_map( 'esc_attr', \q\stand_with_ukraine\admin\read::option() );

		// markup
		$_string = strtr( $_template, $_values );

		// echo escaped string ##
		echo $_string;

	}

	/**
	 * 
	 * @since 0.0.1
	*/
	public function validate():bool{

		return true;

	}

}
