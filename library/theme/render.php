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

		// check if we can load all require ui options ##
		if( ! $this->validate() ){ return false; }

		// @todo - allow markup / template to be filtered or replaced by theme file ##
		$_template = $this->get_template();

		// get default values - later these will come from options table ##
		$_values = array_map( 'esc_attr', \q\stand_with_ukraine\admin\read::option() );

		// markup
		$_string = strtr( $_template, $_values );

		// echo escaped string ##
		echo $_string;

	}

	private function get_template(){

		return 
		'<div class="container-fluid q-consent">
			<div class="container p-0">
				<div class="row align-items-center no-gutters justify-content-between p-3 px-0 no-gutters">
					<div class="col-12 col-md mr-md-auto">
						{message}
					</div>

					<div class="col-12 col-md-auto text-right mt-3 mt-md-0 ml-md-3">
						<a class="btn btn-primary" alt="{button_donate}" href="#" data-trigger-qswu-donate>
							{button_donate}
						</a>
						<button type="button" class="btn btn-primary" alt="{button_install}" data-trigger-qswu-get>
							{button_install}
						</button>
					</div>
				</div>
			</div>
		</div>'
		;

	}

	/**
	 * 
	 * @since 0.0.1
	*/
	public function validate():bool{

		return true;

	}

}
