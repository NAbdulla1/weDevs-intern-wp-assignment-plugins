<?php


namespace A17_STUDENT_INFO;


use A17_STUDENT_INFO\Frontend\Student_Input_Shortcode;

class DB {
	/**
	 * a helper function
	 * @return bool
	 */
	public static function save_to_db(): bool {
		return self::save_student( array_slice( Student_Input_Shortcode::fields, 0, 5 ) );
	}

	/**
	 * save student to database and on success try to insert the meta data. there is an error during saving meta data
	 * then delete the immediately inserted student.
	 *
	 * @param $student_fields
	 *
	 * @return bool
	 */
	private static function save_student( $student_fields ): bool {
		global $wpdb;
		$data  = array(
			'first_name'      => $_POST['a17_si_fname'],
			'last_name'       => $_POST['a17_si_lname'],
			'class'           => $_POST['a17_si_class'],
			'roll_no'         => $_POST['a17_si_roll'],
			'registration_no' => $_POST['a17_si_registration'],
		);
		$table = $wpdb->prefix . 'a17_si_students';
		$err   = $wpdb->insert( $table, $data, array( "%s", "%s", "%s", "%s", "%s", ) );
		if ( is_wp_error( $err ) ) {
			return false;
		}
		$id = $wpdb->insert_id;

		$ok = self::save_student_meta( $id, array_slice( Student_Input_Shortcode::fields, 5 ) );
		if ( ! $ok ) {
			$wpdb->delete( $table, array( 'id' => $id ), array( '%d' ) );
		}

		return $ok;
	}

	/**
	 * save meta data for student
	 *
	 * @param $student_id
	 * @param array $subjects
	 *
	 * @return bool if the save is successful
	 */
	private static function save_student_meta( $student_id, array $subjects ): bool {
		$metaTableObj = 'a17_si_student';//must be same as the $object_name in create_db_table function in Installer.php
		foreach ( $subjects as $subject => $_ ) {
			if ( false === update_metadata( $metaTableObj, $student_id, $subject, $_POST[ $subject ] ) ) {
				return false;
			}
		}

		return true;
	}

	/**
	 *
	 * @param int $page
	 * @param int $per_page
	 *
	 * @return array|object|null
	 */
	public static function get_students( int $page, int $per_page ) {
		$limit  = $per_page;
		$offset = $per_page * ( $page - 1 );

		global $wpdb;

		return $wpdb->get_results(
			$wpdb->prepare( "SELECT * FROM {$wpdb->prefix}a17_si_students WHERE 1=1 LIMIT %d OFFSET %d", array(
				$limit,
				$offset
			) ),
			ARRAY_A
		);
	}

	/**
	 * get total rows
	 *
	 * @return int
	 */
	public static function get_total(): int {
		global $wpdb;

		return (int) $wpdb->get_var( "SELECT COUNT('id') FROM {$wpdb->prefix}a17_si_students WHERE 1=1" );
	}


}