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

		\add_action( 'admin_post_update_qswu', [ $this, 'option' ] );

	}

	/**
	 * Update stored option value
	 * 
	 * @since   0.0.1
	*/
	public function option(){

		// get stored or default values ##
		$_option = \q\stand_with_ukraine\admin\read::option();

		// new array ##
		$_array = [];

		// validate passed values ##
		$_array['show_banner'] = isset( $_POST["qswu_show_banner"] ) ? (int) $_POST["qswu_show_banner"] : $_option['show_banner'];
		$_array['show_donate'] = isset( $_POST["qswu_show_donate"] ) ? (int) $_POST["qswu_show_donate"] : $_option['show_donate'];
		$_array['show_download'] = isset( $_POST["qswu_show_download"] ) ? (int) $_POST["qswu_show_download"] : $_option['show_download'];
		$_array['message'] = isset( $_POST["qswu_message"] ) ? \sanitize_text_field( $_POST["qswu_message"] ) : $_option['message'];
		$_array['css'] = isset( $_POST["qswu_css"] ) ? \wp_kses_post( $_POST["qswu_css"] ) : $_option['css'];
	 
		// get all known donation urls ##
		foreach( \q\stand_with_ukraine\admin\read::get_url_donate() as $_label => $_url ){

			if( isset( $_POST['url_donate'] ) && $_url == $_POST['url_donate'] ) {

				$_array['url_donate'] = \sanitize_url( $_url );

			}

		}

		// if a custom donate link is passed, save this ##
		if( isset( $_POST["url_donate_custom"] ) && ! empty( $_POST["url_donate_custom"] ) ) {

			$_array['url_donate'] = \sanitize_url( $_POST["url_donate_custom"] );
			$_array['url_donate_custom'] = \sanitize_url( $_POST["url_donate_custom"] );

		}

		// update stored values ##
		\update_option( \q_stand_with_ukraine()::get( 'option' ), $_array );
	 
		// Redirect back to settings page ##
		// The ?page=github corresponds to the "slug"
		// set in the fourth parameter of add_submenu_page() above.
		$redirect_url = \get_bloginfo("url") . "/wp-admin/options-general.php?page=qswu&qswu_status=success";
		
		header( "Location: ".$redirect_url );
		
		exit;

	}

}
