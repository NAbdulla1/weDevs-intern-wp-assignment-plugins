<?php


namespace A15_Customer_Reg_Form\Frontend;


class Customer_Reg_ShortCode {
	private array $errors = [];
	const tag = 'a15_crf_reg_form_shortcode';

	public function __construct() {
		add_shortcode( self::tag, [ $this, 'render_form' ] );
	}

	public function render_form() {
		if ( ! empty( $_POST['action'] ) && $_POST['action'] == 'a15_crf_registration_form_action' ) {
			$this->errors = [];
			$this->validate();
			if ( empty( $this->errors ) ) {
				$args    = array(
					'user_login' => $_POST['a15_crf_uname'],
					'user_pass'  => $_POST['a15_crf_password'],
					'user_email' => $_POST['a15_crf_email'],
					'first_name' => $_POST['a15_crf_fname'],
					'last_name'  => $_POST['a15_crf_lname'],
					'role'       => 'a15_crf_customer',
				);
				$user_id = wp_insert_user( $args );
				if ( is_wp_error( $user_id ) ) {
					$this->errors["create_error"] = "Can't create user. " . $user_id->get_error_message();
				} else {
					$this->errors["create_success"] = true;
					$this->add_capabilities( $user_id );
				}
			}
		}
		ob_start();
		include __DIR__ . '/views/customer_register_page.php';

		return ob_get_clean();
	}

	public function validate() {
		if ( empty( $_POST['a15_crf_uname'] ) ) {
			$this->errors['a15_crf_nuname'] = 'Please give a unique username';
		} else if ( username_exists( 'a15_crf_uname' ) ) {
			$this->errors['a15_crf_euname'] = 'Username already exists. Please try another';
		}

		if ( empty( $_POST['a15_crf_fname'] ) ) {
			$this->errors['a15_crf_nfname'] = 'Please give first name';
		}

		if ( empty( $_POST['a15_crf_email'] ) ) {
			$this->errors['a15_crf_nemail'] = 'Please give an email';
		} else if ( email_exists( $_POST['a15_crf_email'] ) ) {
			$this->errors['a15_crf_eemail'] = 'Email address already exists. Please try another or login to previous account';
		}

		if ( empty( $_POST['a15_crf_password'] ) ) {
			$this->errors['a15_crf_npassword'] = 'Please give a password';
		} else if ( empty( $_POST['a15_crf_password2'] ) || $_POST['a15_crf_password'] != $_POST['a15_crf_password2'] ) {
			$this->errors['a15_crf_nmatch'] = 'Password doesn\'t match';
		}
	}

	/**
	 * @param $user_id
	 */
	public function add_capabilities( $user_id ): void {
		if ( ! isset( $_POST['capabilities'] ) ) {
			return;
		}
		$user         = new \WP_User( $user_id );
		$capabilities = $_POST['capabilities'];
		foreach ( $capabilities as $capability ) {
			$user->add_cap( $capabilities );
		}
	}
}
