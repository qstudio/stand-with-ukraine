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
			flex: 0 0 65%;
			padding: 10px 20px;
		}
		.qswu-message p{
			padding: 0;
			margin: 0;
			font-size: 1.2em;
			font-weight: 600;
			font-family: inherit;
			/* text-shadow: 1px 1px 2px black; */
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
		.qswu-actions a.btn:not(:disabled):not(.disabled) {
			cursor: pointer;
		}
		.qswu-actions a.btn-primary {
			color: #fff;
			background-color: transparent;
			border-color: #006BDD;
		}
		.qswu-actions a.btn {
			display: inline-block;
			font-weight: 400;
			color: #000;
			text-align: center;
			vertical-align: middle;
			-webkit-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			user-select: none;
			padding: 6px 12px;
			padding: 0.375rem 0.75rem;
			border: 1;
			font-size: 16px;
			font-size: 1rem;
			line-height: 1.5;
			border-radius: 0.25rem;
			transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
		}
		.qswu-actions a {
			color: #000;
			text-decoration: none;
			background-color: #fff;
		}
		.qswu-actions a.btn.hidden{
			display:none;
		}
	</style>
	<?php

	}

}
