<?php

namespace q\stand_with_ukraine\core;

use q\stand_with_ukraine\core;

class helper {

    /**
     * Write to WP Error Log
     *
     * @since       1.5.0
     * @return      void
     */
    public static function log( $args = null ){
		
		if ( true === \WP_DEBUG ) {

			if ( 
				is_array( $args ) 
				|| is_object( $args ) 
			) {
				error_log( print_r( $args, true ) );
            } else {
				error_log( $args );
            }

		}

	}
	
	/**
	 * Debug Calling class + method / function 
	 * 
	 * @since 	4.0.0
	 */
	public static function backtrace( $args = null ){

		// default args ##
		$level = isset( $args['level'] ) ? $args['level'] : 1 ; // direct caller ##

		// check we have a result ##
		$backtrace = debug_backtrace();

		if (
			! isset( $backtrace[$level] )
		) {

			return false;

		}

		// get defined level of data ##
		$caller = $backtrace[$level];

		// class::function() ##
		if ( 
			isset( $args['return'] ) 
			&& 'class_function' == $args['return'] 
		) {

			return sprintf(
				__( '%s%s()', 'Q' )
				,  	isset($caller['class']) ? $caller['class'].'->' : null
				,   $caller['function']
			);

		}

		// config class_function() ##
		if ( 
			isset( $args['return'] ) 
			&& 'config' == $args['return'] 
		) {

			return sprintf(
				__( '%s%s()', 'Q' )
				,  	isset($caller['class']) ? $caller['class'].'_' : null
				,   $caller['function']
			);

		}

		// file::line() ##
		if ( 
			isset( $args['return'] ) 
			&& 'file_line' == $args['return'] 
			&& isset( $caller['file'] )
			&& isset( $caller['line'] )
		) {

			return sprintf(
				__( '%s:%d', 'Q' )
				,   $caller['file']
				,   $caller['line']
			);

		}

		// specific value ##
		if ( 
			isset( $args['return'] ) 
			&& isset( $caller[$args['return']] )
		) {

			return sprintf(
				__( '%s', 'Q' )
				,  $caller[$args['return']] 
			);

		}

		// default - everything ##
		return sprintf(
			__( '%s%s() %s:%d', 'Q' )
			,   isset($caller['class']) ? $caller['class'].'->' : ''
			,   $caller['function']
			,   isset( $caller['file'] ) ? $caller['file'] : 'n'
			,   isset( $caller['line'] ) ? $caller['line'] : 'x'
		);

	}
	
}
