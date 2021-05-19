<?php


namespace A08_Featured_Post\Admin;

class Settings_Options_Page {
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'add_settings_submenu' ] );
	}

	public function add_settings_submenu() {
		add_options_page( __( 'Featured Posts Settings', 'a08_featured_posts' ), __( 'Featured Post', 'a08_featured_posts' ), 'manage_options', 'a08_featured_posts', [
			$this,
			'page_content'
		] );
	}

	public function page_content() {
		?>
        <form method="POST" action="options.php">
			<?php
			settings_fields( 'a08_featured_posts' );
			do_settings_sections( 'a08_featured_posts' );
			submit_button();
			?>
        </form>
		<?php
	}
}