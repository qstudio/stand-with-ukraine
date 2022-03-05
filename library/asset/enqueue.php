<?php

declare(strict_types = 1);

namespace q\stand_with_ukraine\asset;

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
class enqueue {

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

		// @todo - add script file ##
		\add_action( 'wp_head', [ $this, 'style' ] );

	}

	/**
	 * 
	 * @since 0.0.1
	*/
	public function style(){

	?>
	<style>

	</style>
	<?php

	}

}
