<?php


namespace A16_Rest_CRUD_Mango\Api;


use WP_Error;

/**
 * Class Mangoes_Repository
 * @package A16_Rest_CRUD_Mango\Api
 */
class Mangoes_Repository {

	private string $table_name;

	/**
	 * Mangoes_Repository constructor.
	 */
	public function __construct() {
		global $wpdb;
		$this->table_name = $wpdb->prefix . 'a16_rest_mangoes';
	}

	/**
	 * returns all the rows from the database table which satisfies the parameters
	 *
	 * @param array $args
	 *
	 * @return array|object|null
	 */
	public function get_mangoes( $args = array() ) {
		global $wpdb;
		$defaults = array(
			'per_page' => 10,
			'offset'   => 0
		);
		$args     = wp_parse_args( $args, $defaults );

		return $wpdb->get_results(
			$wpdb->prepare(
				"SELECT * FROM $this->table_name LIMIT %d OFFSET %d", array(
					$args['per_page'],
					$args['offset']
				)
			),
			ARRAY_A
		);
	}

	/**
	 * returns total number of rows in the database table
	 * @return int
	 */
	public function get_total_count(): int {
		global $wpdb;

		return (int) $wpdb->get_var(
			"SELECT COUNT(*) FROM $this->table_name"
		);
	}

	/**
	 * Retrieve a single mango from table
	 *
	 * @param $id
	 *
	 * @return array|object|void|null
	 */
	public function get_mango( $id ) {
		global $wpdb;
		$mango = $wpdb->get_row(
			$wpdb->prepare( "SELECT * FROM $this->table_name WHERE id = %d", array( $id ) ),
			ARRAY_A
		);

		return $mango;
	}

	/**
	 * Deletes a single row (Mango record) from the table
	 *
	 * @param $id int the id of the item to delete
	 *
	 * @return bool|int
	 */
	public function delete_mango( int $id ) {
		global $wpdb;

		return $wpdb->delete( $this->table_name, array( 'id' => $id ), array( '%d' ) );
	}

	/**
	 * Creates or Updates a Mango records. if the argument has an 'id' key then the
	 * operation is considered as update other wise that is a insert operation
	 *
	 * @param $mango
	 *
	 * @return int|WP_Error
	 */
	public function create_update_mango( $mango ) {
		global $wpdb;

		$defaults = isset( $mango['id'] )
			? $this->get_mango( $mango['id'] )
			: array( 'name' => '', 'price_per_kg' => '', 'origin_district' => null );
		$mango    = wp_parse_args( $mango, $defaults );
		if ( isset( $mango['id'] ) ) {
			$updated = $wpdb->update(
				$this->table_name,
				array(
					'name'            => $mango['name'],
					'price_per_kg'    => $mango['price_per_kg'],
					'origin_district' => $mango['origin_district'],
				),
				array( 'id' => $mango['id'] ),
				array( '%s', '%f', '%s' ),
				array( '%d' )
			);
			if ( $updated === false ) {
				return new WP_Error( 'db-error', $wpdb->last_error );
			}

			return $updated;
		} else {
			$inserted = $wpdb->insert(
				$this->table_name,
				array(
					'name'            => $mango['name'],
					'price_per_kg'    => $mango['price_per_kg'],
					'origin_district' => $mango['origin_district'],
				),
				array( '%s', '%f', '%s' )
			);

			if ( ! $inserted ) {
				return new WP_Error( 'db-error', $wpdb->last_error, array( 'status' => 500 ) );
			}

			return $wpdb->insert_id;
		}
	}
}