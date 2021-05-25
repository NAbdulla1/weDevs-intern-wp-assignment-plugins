<?php


namespace A17_STUDENT_INFO\Frontend;


use A17_STUDENT_INFO\DB;

/**
 * Shows and handles the student information form
 * Class Student_Input_Shortcode
 * @package A17_STUDENT_INFO\Frontend
 */
class Student_Input_Shortcode {
	/**
	 * shortcode tag
	 */
	const tag = 'a17_si_student_input_shortcode';

	/**
	 * the action to use in the nonce field of the student form
	 */
	const nonce_action = 'a17_nonce_action_hnbdtgkolqezx';

	/**
	 * action to identify the submitted form
	 */
	const form_action = 'a17_form_action_unbgqxmlkxzaa';

	/**
	 * the fields to be shown in the form
	 */
	const fields = array(
		'a17_si_fname'        => array( true, "First Name*" ),
		'a17_si_lname'        => array( false, "Last Name" ),
		'a17_si_class'        => array( true, "Class*" ),
		'a17_si_roll'         => array( true, "Roll No*" ),
		'a17_si_registration' => array( false, "Registration No" ),

		'a17_si_ben'  => array( true, "Bengali*" ),
		'a17_si_eng'  => array( true, "English*" ),
		'a17_si_math' => array( true, "Mathematics*" ),
	);

	/**
	 * @var array an array to accumulate the errors
	 */
	private array $errors = array();

	public function __construct() {
		$this->register_meta_data_table();
		add_shortcode( self::tag, [ $this, 'student_input' ] );
	}

	/**
	 * @return false|string renders and handles the submitted form
	 */
	public function student_input() {
		$ok = false;
		if ( isset( $_POST['action'] ) && $_POST['action'] === self::form_action ) {
			$this->form_validate();
			if ( empty( $this->errors ) && DB::save_to_db() ) {
				$ok = true;
				foreach ( self::fields as $fieldName => $val ) {
					unset( $_POST[ $fieldName ] );
				}
			}
		}
		ob_start();
		if ( isset( $this->errors['_wpnonce'] ) ) {
			echo "<div>" . $this->errors['_wpnonce'] . "</div>";
		}
		if ( $ok ) {
			echo "<div>" . "Form submitted successfully" . "</div>";
		} else {
			echo "<div>" . "Error occurred" . "</div>";
		}
		include 'views/student-input-form.php';

		return ob_get_clean();
	}

	/**
	 * validates the submitted form
	 */
	private function form_validate() {
		if ( ! wp_verify_nonce( $_POST['_wpnonce'], self::nonce_action ) ) {
			$this->errors['_wpnonce'] = 'Nonce verification failed';
		}
		foreach ( self::fields as $field => $req ) {
			if ( empty( $_POST[ $field ] ) ) {
				if ( $req[0] ) {
					$this->errors[ $field ] = 'Field must not be empty';
				} else {
					$_POST[ $field ] = null;
				}
			}
		}
	}

	/**
	 * registers the custom metadata table
	 */
	private function register_meta_data_table() {
		global $wpdb;
		$object_name              = 'a17_si_student';//must be same as the $object_name in create_db_table function in Installer.php
		$table_name               = $wpdb->prefix . $object_name . 'meta';//must be same as the $table_name in create_db_table function in Installer.php
		$wpdb->a17_si_studentmeta = $table_name;
		$wpdb->tables[]           = $object_name . 'meta';
	}
}
