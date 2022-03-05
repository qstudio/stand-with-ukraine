<?php

namespace q\stand_with_ukraine\core;

use q\stand_with_ukraine\core\helper as h;

class log {

	public static 
		$file				= \WP_CONTENT_DIR."/debug.log",
		$empty 				= false,
		$backtrace 			= false,
		$backtrace_key 		= false,
		$delimiters 		= [
			'array' 		=> '~>',
			'value' 		=> ':>'
		],
		$special_keys 		= [
			'd' 			=> 'debug',
			'e' 			=> 'error',
			'n' 			=> 'notice',
			't'				=> 'todo'
		],
		$key_array 			= [],
		$on_run 			= true,
		$on_shutdown 		= true,
		$shutdown_key 		= [ 'error' ],
		$shutdown_key_debug = [ 'debug', 'todo' ]
	;

	public function __construct(){
		// empty ##
	}

	function hooks(){

		$on_run 			= \apply_filters( 'q/core/log/on_run', self::$on_run );
		$on_shutdown 		= \apply_filters( 'q/core/log/on_shutdown', self::$on_shutdown );

		if ( $on_run ) {

			self::empty();  

			if( 
				defined('DOING_AJAX') 
				&& DOING_AJAX
			) {

				self::empty();

			}

		}

		if ( $on_shutdown ) {

			register_shutdown_function( [ get_class(), 'shutdown' ] );

		}

	}

	private static function get_backtrace( $args = null ){

		$backtrace_1 = h::backtrace([ 
			'level' 	=> \apply_filters( 'q/core/log/traceback/function', 3 ), 
			'return' 	=> 'class_function' 
		]);

		$backtrace_1 = strtolower( str_replace( [ '()' ], [ '' ], $backtrace_1 ) );
			
		$backtrace_2 = h::backtrace([ 
			'level' 	=> \apply_filters( 'q/core/log/traceback/file', 2 ), 
			'return' 	=> 'file_line' 
		]);

		self::$backtrace = ' -> '.$backtrace_2;
		self::$backtrace_key = $backtrace_1;

	}

	/**
     * Store logs, to render at end of process
     * 
     */
    public static function set( $args = null ){

		self::get_backtrace( $args );
		
		if (
			! isset( $args )
			|| is_null( $args )
		){

			return false;

		}

		if ( 
			! $log = self::translate( $args )
		){

			return false;

		}

		return true;

	}

	/**
	 * Hardcore way to directly set a log key and value.. no safety here..
	*/
	public static function set_to( $key = null, $value = null ){

		\q_stand_with_ukraine()::get( 'log' )[$key] = $value;

	}

	/**
     * Translate Log Message
	 * 
	 * Possible formats
	 * - array, object, int - direct dump
	 * - string - "hello"
	 * - $log[] = value - "l:>hello"
     * - $notice[] = value - "n:>hello"
	 * - $error[] = value - "e:>hello"
	 * - $group[] = value - "group:>hello"
	 * - $key[$key][$key] = value - "n~>group~>-problem:>this is a string"
     */
    private static function translate( $args = null ){

		if ( 
			is_int( $args )
			|| is_numeric( $args )
		){

			return self::push( 'debug', print_r( $args, true ).self::$backtrace, self::$backtrace_key );
			
		}

		if ( 
			is_array( $args )
		){

			self::push( 'debug', 'Array below from -> '.self::$backtrace, self::$backtrace_key );
			return self::push( 'debug', print_r( $args, true ), self::$backtrace_key );
			
		}

		if ( 
			is_object( $args )
		){

			self::push( 'debug', 'Object below from -> '.self::$backtrace, self::$backtrace_key );
			return self::push( 'debug', print_r( $args, true ), self::$backtrace_key );
			
		}

		if (
			is_bool( $args )
		){

			return self::push( 'debug', ( true === $args ? 'boolean:true' : 'boolean:false' ).self::$backtrace, self::$backtrace_key );

		}

		self::$delimiters = \apply_filters( 'q/core/log/delimit', self::$delimiters );

		if ( 
			is_string( $args ) 
		) {

			if ( ! core\method::strposa( $args, self::$delimiters ) ) {

				return self::push( 'debug', $args.self::$backtrace, self::$backtrace_key );

			}

			if ( 
				false === strpos( $args, self::$delimiters['array'] ) 
				&& false !== strpos( $args, self::$delimiters['value'] ) 
			) {
			
				$key_value = explode( self::$delimiters['value'], $args );

				$key = $key_value[0];
				$value = $key_value[1];

				return self::push( self::key_replace( $key ), $value.self::$backtrace, self::$backtrace_key );

			}

			if ( 
				false !== strpos( $args, self::$delimiters['array'] ) 
				&& false !== strpos( $args, self::$delimiters['value'] ) 
			) {
			
				$array_key_value = explode( self::$delimiters['value'], $args );
				$value_keys = $array_key_value[0];
				$value = $array_key_value[1];
				$keys = explode( self::$delimiters['array'], $value_keys );

				return self::push( $keys, $value.self::$backtrace, self::$backtrace_key );

			}

		}

        return false;

	}
	
	/**
	 * Push item into the array, checking if selected key already exists 
	 * 
	 */
	private static function push( $key = null, $value = null, $new_key = '' ){

		$log = \q_stand_with_ukraine()::get( 'log' );

		if ( 
			is_string( $key )
			|| (
				is_array( $key )
				&& 1 == count( $key )
			)
		){

			$key = is_array( $key ) ? $key[0] : $key ;

			if ( 
				! isset( $log[$key] )
			){

				$log[$key] = [];

			}

			$new_key = isset( $new_key ) ? $new_key : core\method::get_acronym( $value ) ;

			if ( 
				! isset( $log[$key][$new_key] ) 
			){

				$log[$key][$new_key] = [];

			}

			if ( in_array( $value, $log[$key][$new_key], true ) ) {

				return false;

			}

			$log[$key][$new_key][] = $value;

			return \q_stand_with_ukraine()::set( 'log', $log );

		}

		if(
			is_array( $key )
			&& count( $key ) > 1
		){

			if (
				isset( $key[2] )
			){
				if ( ! isset( \q_stand_with_ukraine()::get( 'log' )[ self::key_replace($key[0]) ][ self::key_replace($key[1]) ][ self::key_replace($key[2]) ] ) ) {
					
					\q_stand_with_ukraine()::get( 'log' )[ self::key_replace($key[0]) ][ self::key_replace($key[1]) ][ self::key_replace($key[2]) ] = [];
				
				}

				if ( 
					in_array( $value, \q_stand_with_ukraine()::get( 'log' )[ self::key_replace($key[0]) ][ self::key_replace($key[1]) ][ self::key_replace($key[2]) ], true ) 
				){ 
					return false;
				};

				return \q_stand_with_ukraine()::get( 'log' )[ self::key_replace($key[0]) ][ self::key_replace($key[1]) ][ self::key_replace($key[2]) ][] = $value;

			}

			if (
				isset( $key[1] )
			){

				if ( ! isset( \q_stand_with_ukraine()::get( 'log' )[ self::key_replace($key[0]) ][ self::key_replace($key[1]) ] ) ) {

					\q_stand_with_ukraine()::get( 'log' )[ self::key_replace($key[0]) ][ self::key_replace($key[1]) ] = [];

				}

				if ( 
					in_array( $value, \q_stand_with_ukraine()::get( 'log' )[ self::key_replace($key[0]) ][ self::key_replace($key[1]) ], true ) 
				){ 
					return false;
				};

				return \q_stand_with_ukraine()::get( 'log' )[ self::key_replace($key[0]) ][ self::key_replace($key[1]) ][] = $value;

			}

			if (
				isset( $key[0] )
			){
				if ( ! isset( \q_stand_with_ukraine()::get( 'log' )[self::key_replace($key[0])] ) ) {

					\q_stand_with_ukraine()::get( 'log' )[ self::key_replace($key[0]) ] = [];

				}

				if ( 
					in_array( $value, \q_stand_with_ukraine()::get( 'log' )[ self::key_replace($key[0]) ], true ) 
				){ 
					return false;
				};

				return \q_stand_with_ukraine()::get( 'log' )[ self::key_replace($key[0]) ][] = $value;

			}
			
		}

		return false;

	}

	public static function in_multidimensional_array( $needle, $haystack ) {

		foreach( $haystack as $key => $value ) {

		   $current_key = $key;

		   if( 
			   $needle === $value 
			   || ( 
				   is_array( $value ) 
				   && self::in_multidimensional_array( $needle, $value ) !== false 
				)
			) {

				return $current_key;

			}
		}

		return false;

	}

	/**
	 * Create Multidimensional array from keys ##
	 * 
	 * @link 	https://eval.in/828697 
	 */
	public static function create_multidimensional_array( $array = [], $keys, $value ){    

		$tmp_array = &$array;

		while( count( $keys ) > 0 ){     

			$k = array_shift( $keys );     

			if( ! is_array( $tmp_array ) ) {

				$tmp_array = [];

			}
			$tmp_array = &$tmp_array[self::key_replace( $k )];

		}

		$tmp_array = $value;

		return $array;

	}

	/**
	 * Special Key replacement 
	 *
	 * - e = error
	 * - n = notice
	 * - l = log ( default ) 
	 */
	private static function key_replace( $key = null ){
		
		self::$special_keys = \apply_filters( 'q/core/log/special_keys', self::$special_keys );

		if ( 
			isset( self::$special_keys[$key] )
		){

			return self::$special_keys[$key];

		}

		return $key;

	}

    /**
     * Logging function
     * 
     */
    public static function write( $key = null ){

		if ( 
			! is_null( $key )
			&& ! isset( \q_stand_with_ukraine()::get( 'log' )[ $key ] ) 
		) {

			return false;

		}

		if ( 
			empty( \q_stand_with_ukraine()::get( 'log' )[$key] )
		) {

			return false;

		}

		if ( isset( $key ) ) {
			
			$return = \q_stand_with_ukraine()::get( 'log' )[ $key ];  // key group ##

			unset( \q_stand_with_ukraine()::get( 'log' )[ $key ] );

        } else {

			$return = \q_stand_with_ukraine()::get( 'log' ) ; // all

			\q_stand_with_ukraine()::set( 'log', [] );

		}
			
		if ( ! is_null( $key ) ) { $return = [ $key => $return ]; }

		if ( is_array( $return ) ) { $return = array_reverse( $return ); }

        if ( true === \WP_DEBUG ) {

			if ( 
				is_array( $return ) 
				|| is_object( $return ) 
			) {
				self::error_log( print_r( $return, true ) );
            } else {
				self::error_log( $return );
            }

		}

		return true;

	}
	
	/**
	 * Replacement error_log function, with custom return format 
	 * 
	 * @since 4.1.0
	 */ 
	public static function error_log( $log = null, $file = null )
	{
		
		if(  
			is_null( $log )
		){

			return false;

		}
		
		$log_errors     = ini_get( 'log_errors' );
		$error_log      = ini_get( 'error_log' );
		$file 			= ! is_null( $file ) ? $file : self::$file ;

		// @todo - sanitize ##

		if( $log_errors ){

			$message = sprintf( 
				'%s', 
				$log, 
			);
			file_put_contents( $file, $message.PHP_EOL, FILE_APPEND );

		}

		return true;

	}



	/**
     * Clear Temp Log
     * 
     */
    private static function clear( $args = null ){

		if ( 
			isset( $args['key'] )
			&& ! isset( \q_stand_with_ukraine()::get( 'log' )[ $args['key'] ] ) 
		) {

			return false;

		}

        if ( isset( $args['key'] ) ) {

			$_log = \q_stand_with_ukraine()::get( 'log' );
			unset($_log[ $args['key'] ]);
			\q_stand_with_ukraine()::set( 'log', $_log );

			return true;

		}

		\q_stand_with_ukraine()::set( 'log', [] );

		return true;

	}
	
	/**
     * Empty Log
     * 
     */
    private static function empty( $args = null ){

		if( 
			\is_admin() 
			&& \wp_doing_ajax()
		){ 
		
			return false; 
		
		}

		if( self::$empty ) { return false; }

		$f = @fopen( self::$file, "r+" );
		if ( $f !== false ) {
			
			ftruncate($f, 0);
			fclose($f);

			self::$empty == true;

		}

	}

	private static function php_error(){

		$error = error_get_last();

		if(
			$error !== NULL 
		){

			self::set_to( 'php', self::php_error_decode( $error['type'], $error['message'], $error['file'], $error['line'] ) );

			self::write();

			return true;

		}

		return false;
		
    }

	private static function php_error_decode( $errno, $errstr, $errfile, $errline ) {

        switch ($errno){

            case E_ERROR: // 1 //
                $typestr = 'E_ERROR'; break;
            case E_WARNING: // 2 //
                $typestr = 'E_WARNING'; break;
            case E_PARSE: // 4 //
                $typestr = 'E_PARSE'; break;
            case E_NOTICE: // 8 //
                $typestr = 'E_NOTICE'; break;
            case E_CORE_ERROR: // 16 //
                $typestr = 'E_CORE_ERROR'; break;
            case E_CORE_WARNING: // 32 //
                $typestr = 'E_CORE_WARNING'; break;
            case E_COMPILE_ERROR: // 64 //
                $typestr = 'E_COMPILE_ERROR'; break;
            case E_CORE_WARNING: // 128 //
                $typestr = 'E_COMPILE_WARNING'; break;
            case E_USER_ERROR: // 256 //
                $typestr = 'E_USER_ERROR'; break;
            case E_USER_WARNING: // 512 //
                $typestr = 'E_USER_WARNING'; break;
            case E_USER_NOTICE: // 1024 //
                $typestr = 'E_USER_NOTICE'; break;
            case E_STRICT: // 2048 //
                $typestr = 'E_STRICT'; break;
            case E_RECOVERABLE_ERROR: // 4096 //
                $typestr = 'E_RECOVERABLE_ERROR'; break;
            case E_DEPRECATED: // 8192 //
                $typestr = 'E_DEPRECATED'; break;
            case E_USER_DEPRECATED: // 16384 //
                $typestr = 'E_USER_DEPRECATED'; break;
        }

        $message =
            $typestr .
            ': ' . $errstr .
            ' in ' . $errfile .
            ' on line ' . $errline .
            PHP_EOL;

    	return sprintf( '%s', $message );

    }
	

	/**
     * Shutdown method
     * 
     */
    public static function shutdown(){

		$key = \apply_filters( 'q/core/log/default', self::$shutdown_key );
		$key_debug = \apply_filters( 'q/core/log/debug', self::$shutdown_key_debug );

		if( 
			! $key 
			|| is_null( $key ) 
			|| empty( $key ) 
		){

			return self::write();

		}

		$log = [];
		
		foreach( ( array )$key as $k => $v ) {

			if ( ! isset( \q_stand_with_ukraine()::get( 'log' )[$v] ) ) { continue; }

			$log[$v] = \q_stand_with_ukraine()::get( 'log' )[$v];

		}

		if ( 
			$key_debug
		) {

			foreach( ( array )$key_debug as $k => $v ) {

				if ( is_array( $key ) && array_key_exists( $v, $key ) ) { continue; }

				if ( ! isset( \q_stand_with_ukraine()::get( 'log' )[$v] ) ) { continue; }

				$log[$v] = \q_stand_with_ukraine()::get( 'log' )[$v];

			}

		}

		$_log = \q_stand_with_ukraine()::get( 'log' );
		$_log['q'] = $log;
		\q_stand_with_ukraine()::set( 'log', $_log );

		self::write( 'q' );

		return true;

	}

}
