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
	public static function get(){

		return \apply_filters( 
			'stand_with_ukraine/theme/template', 
			'<div id="qswu-banner">
				<div class="qswu-message qswu-flex">
					<p>{message}</p>
				</div>
				<div class="qswu-actions qswu-flex">
					<a class="btn btn-primary" alt="{title_donate}" title="{title_donate}" href="{url_donate}" target="_blank" data-trigger-qswu-donate>
						{button_donate}
					</a>
					<a type="button" class="btn btn-primary" alt="{title_download}" title="{title_download}" href="{url_download}" target="_blank" data-trigger-qswu-get>
						{button_download}
					</a>
				</div>
			</div>'
		);

	}

}
