<?php


namespace A05_Contact_Form;


use WP_Error;

class DB {
	function insert( $args = [] ) {//assuming all the data are valid. as we have validated in Ajax.php
		$data = [
			'first_name' => $args['a05_contact_form_fname'],
			'last_name'  => $args['a05_contact_form_lname'],
			'email'      => $args['a05_contact_form_email'],
			'message'    => $args['a05_contact_form_message'],
		];

		global $wpdb;
		if ( $wpdb->insert( "{$wpdb->prefix}a05_contact_form", $data, [ "%s", "%s", "%s", "%s" ] ) ) {
			return $wpdb->insert_id;
		}

		return new WP_Error( 'db-error', $wpdb->last_error );
	}
}