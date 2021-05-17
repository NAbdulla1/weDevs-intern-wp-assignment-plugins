<?php


namespace A05_Contact_Form;


use WP_Error;

class DB {

	public function fetch_contact_info( $args = [] ) {
		$defaults = [
			'per_page' => 10,
			'offset'   => 0,
			'order_by' => 'first_name',
			'order'    => 'asc',
		];
		$data     = wp_parse_args( $args, $defaults );

		global $wpdb;
		$contacts = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}a05_contact_form ORDER BY {$data['order_by']} {$data['order']} LIMIT %d, %d", $data['offset'], $data['per_page'] ) );

		return $contacts;
	}

	public function get_contact_count(): int {
		global $wpdb;

		return (int) $wpdb->get_var( "SELECT COUNT('id') FROM {$wpdb->prefix}a05_contact_form" );
	}

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