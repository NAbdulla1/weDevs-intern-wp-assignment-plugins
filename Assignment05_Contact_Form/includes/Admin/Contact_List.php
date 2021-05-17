<?php


namespace A05_Contact_Form\Admin;

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

use A05_Contact_Form\DB;
use WP_List_Table;

class Contact_List extends WP_List_Table {
	public function __construct() {
		parent::__construct( [
			'singular' => 'Contact',
			'plural'   => 'Contacts',
			'ajax'     => false,
		] );
	}

	public function prepare_items() {
		$column   = $this->get_columns();
		$hidden   = [];
		$sortable = $this->get_sortable_columns();

		$this->_column_headers = [ $column, $hidden, $sortable ];

		$per_page = 5;
		$page_num = $this->get_pagenum();
		$offset   = ( $page_num - 1 ) * $per_page;

		$db = new DB();

		$args = [
			'per_page' => $per_page,
			'offset'   => $offset,
		];

		if ( ! empty( $_REQUEST['orderby'] ) && ! empty( $_REQUEST['order'] ) ) {
			$args['order_by'] = $_REQUEST['orderby'];
			$args['order']    = $_REQUEST['order'];
		}

		$this->items = $db->fetch_contact_info( $args );

		$this->set_pagination_args( [
			'total_items' => $db->get_contact_count(),
			'per_page'    => $per_page
		] );
	}

	protected function get_sortable_columns() {
		return [
			'first_name' => array( 'first_name', 'desc' ),
			'last_name'  => array( 'last_name', 'desc' ),
			'email'      => array( 'email', 'desc' ),
		];
	}

	public function get_columns() {
		return [
			'cb'         => '<input type="checkbox">',
			'first_name' => __( 'First Name', 'a05_contact_form' ),
			'last_name'  => __( 'Last Name', 'a05_contact_form' ),
			'email'      => __( 'Email', 'a05_contact_form' ),
			'message'    => __( 'Message', 'a05_contact_form' ),
		];
	}

	protected function column_cb( $item ) {
		return "<input type='checkbox' name='contact_id[]' value='{$item->id}'/>";
	}

	public function column_first_name( $item ) {
		return sprintf( '<strong>%s</strong>', $item->first_name );
	}

	protected function column_default( $item, $column_name ) {
		return isset( $item->$column_name ) ? $item->$column_name : '';
	}
}