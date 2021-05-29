<?php


namespace A05_Contact_Form\Admin;

/**
 * Class Menu
 * @package A05_Contact_Form\Admin
 */
class Menu {
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'add_admin_menu' ] );
	}

	/**
	 * adds an admin menu page
	 */
	public function add_admin_menu() {
		add_menu_page( __( 'Contact Form Plugin', 'a05_contact_form' ), __( 'Contact Form', 'a05_contact_form' ), 'manage_options', 'a05_contact_form', [
			$this,
			'contact_form_page'
		] );
	}

	/**
	 * callback function to show elements in the menu page
	 */
	public function contact_form_page() {
		ob_start();
		?>
        <div class="wrap">
            <h1 class="wp-heading-inline"><?php _e( 'Contact List', 'a05_contact_form' ) ?></h1>
            <form>
				<?php $table = new \A05_Contact_Form\Admin\Contact_List();
				$table->prepare_items();
				$table->display();
				?>
            </form>
        </div>
		<?php
		$content = ob_get_clean();
		echo $content;
	}
}