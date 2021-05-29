<?php


namespace A05_Contact_Form\Admin;

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

use A05_Contact_Form\DB;
use WP_List_Table;

/**
 * Shows a contact list which looks like a built in post list or page list in wordpress
 * Class Contact_List
 * @package A05_Contact_Form\Admin
 */
class Contact_List extends WP_List_Table {
	public function __construct() {
		parent::__construct( [
			'singular' => 'Contact',
			'plural'   => 'Contacts',
			'ajax'     => false,
		] );
	}

	/**
	 * prepares items to show in the list
	 */
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

	/**
	 * gets the columns by which we will be able to sort the table list by clicking on the column name
	 * @return \string[][]
	 */
	protected function get_sortable_columns() {
		return [
			'first_name' => array( 'first_name', 'desc' ),
			'last_name'  => array( 'last_name', 'desc' ),
			'email'      => array( 'email', 'desc' ),
		];
	}

	/**
	 * the columns to show in the table
	 * @return array
	 */
	public function get_columns() {
		return [
			'cb'         => '<input type="checkbox">',
			'first_name' => __( 'First Name', 'a05_contact_form' ),
			'last_name'  => __( 'Last Name', 'a05_contact_form' ),
			'email'      => __( 'Email', 'a05_contact_form' ),
			'message'    => __( 'Message', 'a05_contact_form' ),
		];
	}

	/**
	 * gets the element to be shown in the cb column. here cb column is listed in the 'get_columns' function
	 * @param array|object $item
	 *
	 * @return string
	 */
	protected function column_cb( $item ) {
		return "<input type='checkbox' name='contact_id[]' value='{$item->id}'/>";
	}

	/**
	 * gets the element to be shown in the first_name column
	 * @param $item
	 *
	 * @return string
	 */
	public function column_first_name( $item ) {
		return sprintf( '<strong>%s</strong>', $item->first_name );
	}

	/**
	 * the value to be shown for the column for an item
	 * @param array|object $item
	 * @param string $column_name
	 *
	 * @return string|void
	 */
	protected function column_default( $item, $column_name ) {
		return isset( $item->$column_name ) ? $item->$column_name : '';
	}
}