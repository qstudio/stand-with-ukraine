<?php

declare(strict_types = 1);

namespace q\stand_with_ukraine\admin;

// If this file is called directly, Bulk!
if ( ! defined( 'ABSPATH' ) ) {
	return;
}

/**
 * admin menu and render options screen
 * 
 * @since 0.0.1
*/
class option {

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

		\add_action( "admin_menu", [ $this, "add_submenu_page" ] );

	}

	/** 
	 * Register the menu.
	 * 
	 * @since 	0.0.2
	 */
	public function add_submenu_page() {
   		
		\add_submenu_page( "options-general.php",  // Which menu parent
			"Stand with Ukraine", 		// Page title
			"Stand with Ukraine", 		// Menu title
			"manage_options",       	// Minimum capability (manage_options is an easy way to target administrators)
			"qswu",            			// Menu slug
			[ $this, 'render_screen']	// Callback that prints the markup
		);
	
	}

	/**
	 * Render options screen
	 * 
	 * @since   0.0.2
	*/
	public function render_screen(){

		// secure access ##
		if ( ! \current_user_can( "manage_options" ) )  {
			\wp_die( \__( "You do not have sufficient permissions to access this page." ) );
		}
		
		// show confirmation message ##
		self::confirm();

		// get stored option values ##
		$_array = \q\stand_with_ukraine\admin\read::option();

		?>
		<div class="wrap">
			<h1>Stand with Ukraine banner settings</h1>
			<form method="post" action="<?php echo admin_url( 'admin-post.php'); ?>">
				<input type="hidden" name="action" value="update_qswu" />

				<table class="form-table" role="presentation">
					<tbody>
						<tr>
							<th scope="row"><?php \_e("Show Banner", "q-stand-with-ukraine"); ?></th>
							<td>
								<fieldset>
									<legend class="screen-reader-text">
										<span><?php \_e("Show Banner", "q-stand-with-ukraine"); ?></span>
									</legend>
									<label>
										<input type="radio" name="qswu_show_banner" value="1" <?php \checked('1', $_array['show_banner'] ); ?> /> 
										<span class="date-time-text format-i18n"><?php \_e("Yes", "q-stand-with-ukraine"); ?></span>
									</label><br>
									<label>
										<input type="radio" name="qswu_show_banner" value="0" <?php \checked('0', $_array['show_banner'] ); ?> />
										<span class="date-time-text format-i18n"><?php \_e("No", "q-stand-with-ukraine"); ?></span>
									</label><br>
								</fieldset>
							</td>
						</tr>

						<tr class="qswu_message_tr">
							<th scope="row"><label for="qswu_message"><?php \_e("Message Text:", "q-stand-with-ukraine"); ?></label></th>
							<td>
								<input name="qswu_message" type="text" id="qswu_message" value="<?php echo \esc_html( $_array['message'] ); ?>" class="regular-text" maxlength="100" />
								<p class="description" id="qswu_message-description"><?php \_e("Edit the text shown on the banner - max characters 100.", "q-stand-with-ukraine"); ?></strong></p>
							</td>
						</tr>

						<tr>
							<th scope="row"><?php \_e("Show Donate Link", "q-stand-with-ukraine"); ?></th>
							<td>
								<fieldset>
									<legend class="screen-reader-text">
										<span><?php \_e("Show Donate Link", "q-stand-with-ukraine"); ?></span>
									</legend>
									<label>
										<input type="radio" name="qswu_show_donate" value="1" <?php \checked('1', $_array['show_donate'] ); ?> /> 
										<span class="date-time-text format-i18n"><?php \_e("Yes", "q-stand-with-ukraine"); ?></span>
									</label><br>
									<label>
										<input type="radio" name="qswu_show_donate" value="0" <?php \checked('0', $_array['show_donate'] ); ?> />
										<span class="date-time-text format-i18n"><?php \_e("No", "q-stand-with-ukraine"); ?></span>
									</label><br>
								</fieldset>
							</td>
						</tr>

						<tr>
							<th scope="row"><?php \_e("Donate Link", "q-stand-with-ukraine"); ?></th>
							<td>
								<fieldset>
									<legend class="screen-reader-text">
										<span><?php \_e("Donate Link", "q-stand-with-ukraine"); ?></span>
									</legend>
									<?php

									// track if this is a custom url ##
									$_custom_url = true;

									// get all known donation urls ##
									foreach( \q\stand_with_ukraine\admin\read::get_url_donate() as $_label => $_url ){

										$_label_key = \sanitize_key( $_label ); 

										if ( $_url === $_array['url_donate'] ){ 
											
											$_custom_url = false; 
										
										}

									?>
									<label>
										<input type="radio" name="url_donate" value="<?php echo \esc_url( $_url ); ?>" <?php \checked( $_url, $_array['url_donate'] ); ?> /> 
										<span class="date-time-text format-i18n"><?php echo \esc_attr( $_label ); ?></span>
										<code><?php echo \esc_url( $_url ); ?></code>
									</label><br>
									<?php

									} // foreach ##

									?>
									<label>
										<input type="radio" id="url_donate_custom_radio" name="url_donate" id="url_donate" value="url_donate_custom" <?php if ( $_custom_url ) { echo \esc_attr( 'checked="checked"' ); } ?> /> 
										<span class="date-time-text date-time-custom-text"><?php \_e("Custom URL", "q-stand-with-ukraine"); ?>:
											<span class="screen-reader-text"><?php \_e("Enter a custom URL in the following field", "q-stand-with-ukraine"); ?></span>
										</span>
									</label>
									<label for="url_donate_custom" class="screen-reader-text"><?php \_e("Custom date format", "q-stand-with-ukraine"); ?>:</label>
									<input type="text" name="url_donate_custom" id="url_donate_custom" value="<?php echo \esc_attr( $_array['url_donate_custom'] ); ?>" class="large-text">
								</fieldset>
								<p class="date-time-doc">If you enter a custom donation URL, please validate this is genuine and trustworthy.</p>
							</td>
						</tr>

						<tr>
							<th scope="row"><?php \_e("Show Download Link", "q-stand-with-ukraine"); ?></th>
							<td>
								<fieldset>
									<legend class="screen-reader-text">
										<span><?php \_e("Show Download Link", "q-stand-with-ukraine"); ?></span>
									</legend>
									<label>
										<input type="radio" name="qswu_show_download" value="1" <?php \checked('1', $_array['show_download'] ); ?> /> 
										<span class="date-time-text format-i18n"><?php \_e("Yes", "q-stand-with-ukraine"); ?></span>
									</label><br>
									<label>
										<input type="radio" name="qswu_show_download" value="0" <?php \checked('0', $_array['show_download'] ); ?> />
										<span class="date-time-text format-i18n"><?php \_e("No", "q-stand-with-ukraine"); ?></span>
									</label><br>
								</fieldset>
							</td>
						</tr>

						<tr>
							<th scope="row"><?php \_e("Custom CSS", "q-stand-with-ukraine"); ?></th>
							<td>
								<fieldset>
									<legend class="screen-reader-text">
										<span><?php \_e("Custom CSS", "q-stand-with-ukraine"); ?></span>
									</legend>
									<p>
										<textarea name="qswu_css" rows="4" cols="50" id="qswu_css" class="large-text code"><?php echo \wp_kses_post( $_array['css'] ); ?></textarea>
									</p>
									<p class="date-time-doc"><?php \_e("Add Custom CSS rules to style the banner", "q-stand-with-ukraine"); ?></p>
								</fieldset>
							</td>
						</tr>

					</tbody>
				</table>

				<p class="submit">
					<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php \_e("Save Changes", "q-stand-with-ukraine"); ?>">
				</p>

			</form>
		</div>
		<?php

		self::javascript();

	}

	/**
	 * Show and hide <tr> elements based on radio button values
	 * 
	 * @todo
	 * @since 0.0.2
	*/
	private static function javascript():void{

	?>
   	<script>
		jQuery('input[name="url_donate"]').on('click', function() {
			jQuery('#url_donate_custom').prop('disabled', true);
		});

		jQuery('#url_donate_custom_radio').on('click', function() {
			jQuery('#url_donate_custom').prop('disabled', false);
		});
	</script>
	<?php

	}

	/**
	 * 
	 * 
	 * @since 0.0.2
	*/
	private static function confirm():void{

		if ( isset($_GET['qswu_status']) && $_GET['qswu_status']=='success') {

	?>
   	<div id="message" class="updated notice notice-success is-dismissible">
		<p><?php \_e("Settings updated", "q-stand-with-ukraine"); ?></p>
      	<button type="button" class="notice-dismiss">
			<span class="screen-reader-text"><?php \_e("Dismiss this notice.", "q-stand-with-ukraine"); ?></span>
      	</button>
   	</div>
	<?php

		}

	}

}
