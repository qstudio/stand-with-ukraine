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
	 * Get download URL from API source
	 * 
	 * @return 	mixed
	 * @since	0.0.1
	*/
	public static function get_download_link():?string{}

	/**
	 * Get list of download links from API source
	 * 
	 * @return	mixed
	 * @since 	0.0.1
	*/
	public static function get_donation_links():?array{}

}
