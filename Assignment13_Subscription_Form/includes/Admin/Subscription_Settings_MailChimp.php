<?php


namespace A13_Subscription_Form\Admin;


class Subscription_Settings_MailChimp {
	const option_group = 'a13_subscription_form_settings_options';
	const page_menu_slug = 'a13_subscription_form_mail_chimp_page';

	const mail_api_option = 'a13_subscription_form_mail_chimp_api_option';
	const mail_list_option = 'a13_subscription_form_mail_chimp_list_option';

	const setting_section = 'a13_subscription_form_ss';

	public function __construct() {
		add_action( 'admin_menu', [ $this, 'add_menu_to_settings' ] );
		add_action( 'admin_init', [ $this, 'init_settings' ] );
	}

	public function init_settings() {
		register_setting( self::option_group, self::mail_api_option );
		register_setting( self::option_group, self::mail_list_option );

		add_settings_section( self::setting_section,
			__( "MailChimp Settings", A13_SUBSCRIPTION_FORM_TD ),
			[ $this, 'make_settings_section' ],
			self::page_menu_slug );
	}

	public function make_settings_section() {
		add_settings_field( self::mail_api_option, __( "Mail API", A13_SUBSCRIPTION_FORM_TD ), function () {
			$api = get_option( self::mail_api_option );
			?>
            <input name='<?php echo self::mail_api_option ?>' id='<?php echo self::mail_api_option ?>' type='text'
                   value='<?php echo $api ?>'/>
			<?php
		}, self::page_menu_slug, self::setting_section );

		add_settings_field( self::mail_list_option, __( "Mail List", A13_SUBSCRIPTION_FORM_TD ), function () {
			$list = get_option( self::mail_list_option );
			?>
            <input name='<?php echo self::mail_list_option ?>' id='<?php echo self::mail_list_option ?>' type='text'
                   value='<?php echo $list ?>'/>
			<?php
		}, self::page_menu_slug, self::setting_section );
	}

	public function add_menu_to_settings() {
		add_options_page( __( 'MailChimp Subscriber Options', A13_SUBSCRIPTION_FORM_TD ),
			__( 'MailChimp Subscriber Options', A13_SUBSCRIPTION_FORM_TD ),
			'manage_options',
			self::page_menu_slug,
			[ $this, 'display_settings_page' ]
		);
	}

	public function display_settings_page() {
		?>
        <form method="post" action="options.php">
			<?php
			settings_fields( self::option_group );
			do_settings_sections( self::page_menu_slug );
			submit_button();
			?>
        </form>
		<?php
	}
}

