<?php

// Global functions added by q\stand_with_ukraine, site outside of the namespace and are pluggable

// import ##
use q\stand_with_ukraine\core\helper as h;

/** 
 * API 
 *
 */
if ( ! function_exists( 'q_stand_with_ukraine' ) ) {

	function q_stand_with_ukraine(){

		// sanity ##
		if(
			! class_exists( '\q\stand_with_ukraine\plugin' )
		){

			error_log( 'e:>q\stand_with_ukraine is not available to '.__FUNCTION__ );

			return false;

		}

		// cache ##
		$instance = \q\stand_with_ukraine\plugin::get_instance();

		// sanity - make sure willow instance returned ##
		if( 
			is_null( $instance )
			|| ! ( $instance instanceof \q\stand_with_ukraine\plugin ) 
		) {

			// get stored plugin instance from filter ##
			$instance = \apply_filters( 'q/stand_with_ukraine/instance', NULL );

			// sanity - make sure epharmacy instance returned ##
			if( 
				is_null( $instance )
				|| ! ( $instance instanceof \q\stand_with_ukraine\plugin ) 
			) {

				error_log( 'Error in object instance returned to '.__FUNCTION__ );

				return false;

			}

		}

		// __log( 'q\stand_with_ukraine is ok..' );

		// return q\stand_with_ukraine instance ## 
		return $instance;

	}

}

if( ! function_exists( '__log' ) ){

	function __log( $args ){
		
		h::log( $args );

	}

}
