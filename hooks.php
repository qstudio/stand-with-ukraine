<?php

declare(strict_types = 1);

namespace q\stand_with_ukraine;

// import classes ##
use q\stand_with_ukraine\core\helper as h;

// If this file is called directly, Bulk!
if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/*
* Hooks Factory Class
*/
final class hooks {

    /**
     * Class constructor to define object props --> empty
     * 
     * @since   0.0.1
     * @return  void
    */
    function __construct() {

	}

	/**
	 * admin hooks
	*/
	public function admin( 
		\q\stand_with_ukraine\admin\fetch $fetch  
	):void {

		$fetch->hooks();

	}

	/**
	 * asset hooks
	*/
	public function asset( 
		\q\stand_with_ukraine\asset\enqueue $asset  
	):void {

		$asset->hooks();

	}

}
