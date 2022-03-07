<?php

declare(strict_types = 1);

namespace q\stand_with_ukraine\theme;

// If this file is called directly, Bulk!
if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/*
 * Template controllers
*/
class template {

	/**
	 * 
	 * @todo - allow filtering and theme based override
	 * @since 0.0.1
	*/
	public static function get():?string{

		return \apply_filters( 
			'stand_with_ukraine/theme/template', 
			'<div id="qswu-banner">
				<div class="qswu-message qswu-flex">
					<p>{message}</p>
				</div>
				<div class="qswu-actions qswu-flex">
					<a class="btn btn-primary {show_donate}" alt="{title_donate}" title="{title_donate}" href="{url_donate}" target="_blank" data-trigger-qswu-donate>
						{button_donate}
					</a>
					<a type="button" class="btn btn-primary {show_download}" alt="{title_download}" title="{title_download}" href="{url_download}" target="_blank" data-trigger-qswu-get>
						{button_download}
					</a>
				</div>
			</div>'
		);

	}

	/**
	 * Markup template from array of values
	 * 
	 * @todo	Filter input and output
	 * @since 	0.0.2
	*/
	public static function markup( string $template = '', array $array = [] ):?string {

		// escape array values ##
		$array = array_map( 'esc_attr', $array );

		// wrap each array key in {} curvy brackets for markup replacement ##
		$array = \q\stand_with_ukraine\theme\template::curvy_wrap( $array );

		// return formatted string
		return strtr( $template, $array );

	}

	/**
	 * Wrap array keys with other curvy brackets for placeholder markup replacement
	 * 
	 * @param array
	 * @param string
	 * @param string
	 * @since 0.0.2
	*/
	public static function curvy_wrap( array $array = [], string $before = '{', string $after = '}' ):array{

		$_curvy_array = [];
		
		foreach( $array as $_key => $_value ){

			$_curvy_array[ \sanitize_text_field( $before.$_key.$after ) ] = \sanitize_text_field( $_value );

		}

		return $_curvy_array;
	
	}

}
