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

		// @todo - add script file once stable ##
		\add_action( 'wp_head', [ $this, 'style' ] );

	}

	/**
	 * 
	 * @since 0.0.1
	*/
	public function style(){

	?>
	<style>
		#qswu-banner{
			background: linear-gradient( 90deg , #045bbb 50%, #ffd600 0%);
			vertical-align: middle;
			color: #fff;
			display: flex;
		}
		.qswu-message{
			color: #fff;
			flex: 0 0 50%;
			padding: 10px 20px;
		}
		.qswu-message p{
			padding: 0;
			margin: 0;
			font-size: 1.2em;
			font-weight: 600;
			font-family: inherit;
			color: #fff;
			line-height: 1.5em;
		}
		.qswu-actions{
			flex: 1;
			text-align: right;
			padding: 8px 10px;
		}
		.qswu-actions a {
			margin: 2px 3px;
		}
		.qswu-actions a.btn {
			display: inline-block;
			border: 2px solid black;
			text-decoration: none;
			background-color: transparent;
			color: black;
			padding: 4px 7px;
			font-size: 12px;
			border-color: #000;
  			color: black;
		}
		.qswu-actions a.btn:hover {
			background: #045bbb;
			color: #fff;
		}
		.qswu-actions a.btn.hidden{
			display:none;
		}
		.qswu-actions a.btn:not(:disabled):not(.disabled) {
			cursor: pointer;
		}
	</style>
	<?php

	}

}
